<?php

namespace App\Http\Controllers;

use App\Models\Package;
use App\Models\Transaction;
use App\Services\PaymentService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;

class PaymentController extends Controller
{
    protected PaymentService $paymentService;

    public function __construct(PaymentService $paymentService)
    {
        $this->paymentService = $paymentService;
    }

    /**
     * Show checkout page.
     */
    /**
     * Show checkout page.
     */
    public function checkout(Request $request, string $slug)
    {
        $type = $request->query('type', 'package');

        if ($type === 'bundle') {
            $item = \App\Models\Bundle::where('slug', $slug)->firstOrFail();
            $transaction = Transaction::where('user_id', Auth::id())
                ->where('bundle_id', $item->id)
                ->where('status', Transaction::STATUS_PENDING)
                ->where('expired_at', '>', now())
                ->orderByDesc('created_at')
                ->first();
        } else {
            $item = Package::where('slug', $slug)->firstOrFail();
            $transaction = Transaction::where('user_id', Auth::id())
                ->where('package_id', $item->id)
                ->where('status', Transaction::STATUS_PENDING)
                ->where('expired_at', '>', now())
                ->orderByDesc('created_at')
                ->first();
        }

        if ($transaction) {
            try {
                $snapToken = $this->paymentService->generateSnapToken($transaction);
            } catch (\Exception $e) {
                \Illuminate\Support\Facades\Log::warning('Unable to generate snap token for existing transaction: ' . $e->getMessage());
                $snapToken = null;
            }

            return view('payment.checkout', [
                'item' => $item,
                'type' => $type,
                'transaction' => $transaction,
                'snapToken' => $snapToken,
                'clientKey' => config('services.midtrans.client_key'),
            ]);
        }

        return view('payment.checkout', [
            'item' => $item,
            'type' => $type,
            'transaction' => null,
            'snapToken' => null,
            'clientKey' => config('services.midtrans.client_key'),
        ]);
    }

    /**
     * Process payment (create transaction and get snap token).
     */
    public function process(Request $request, string $slug)
    {
        $type = $request->input('type', 'package');
        /** @var \App\Models\User $user */
        $user = Auth::user();

        if ($type === 'bundle') {
            $item = \App\Models\Bundle::where('slug', $slug)->firstOrFail();
            // Check access? For bundles, maybe check if they own all packages or just if they bought this bundle?
            // For now, let's allow buying bundle even if they own some parts (up-selling).
        } else {
            $item = Package::where('slug', $slug)->firstOrFail();
            if ($user->hasAccessToPackage($item->id)) {
                return response()->json([
                    'success' => false,
                    'message' => 'Anda sudah memiliki akses ke paket ini.',
                ], 400);
            }
        }

        if ($type === 'bundle') {
            $existing = Transaction::where('user_id', $user->id)
                ->where('bundle_id', $item->id)
                ->where('status', Transaction::STATUS_PENDING)
                ->where('expired_at', '>', now())
                ->first();
        } else {
            $existing = Transaction::where('user_id', $user->id)
                ->where('package_id', $item->id)
                ->where('status', Transaction::STATUS_PENDING)
                ->where('expired_at', '>', now())
                ->first();
        }

        if ($existing) {
            try {
                $snapToken = $this->paymentService->generateSnapToken($existing);

                return response()->json([
                    'success' => true,
                    'snap_token' => $snapToken,
                    'transaction_id' => $existing->id,
                    'invoice_number' => $existing->invoice_number,
                ]);
            } catch (\Exception $e) {
                Log::warning('Midtrans token generation failed for existing transaction: ' . $e->getMessage());

                return response()->json([
                    'success' => false,
                    'code' => 'existing_pending',
                    'transaction_id' => $existing->id,
                    'invoice_number' => $existing->invoice_number,
                    'message' => 'Anda sudah memiliki transaksi yang menunggu. Silakan selesaikan pembayaran pada halaman checkout.',
                ], 200);
            }
        }

        // Create transaction
        // We need to update PaymentService to handle generic items or bundles
        if ($type === 'bundle') {
            $transaction = $this->paymentService->createBundleTransaction($user, $item);
        } else {
            $transaction = $this->paymentService->createPackageTransaction($user, $item);
        }

        // Generate snap token
        try {
            $snapToken = $this->paymentService->generateSnapToken($transaction);

            return response()->json([
                'success' => true,
                'snap_token' => $snapToken,
                'transaction_id' => $transaction->id,
                'invoice_number' => $transaction->invoice_number,
            ]);
        } catch (\Exception $e) {
            Log::error('Payment error: ' . $e->getMessage());

            $transaction->update(['status' => Transaction::STATUS_FAILED]);

            return response()->json([
                'success' => false,
                'message' => 'Gagal memproses pembayaran: Koneksi ke server Midtrans terputus atau timeout. Silakan periksa koneksi internet Anda atau coba lagi beberapa saat lagi.',
            ], 500);
        }
    }

    /**
     * Handle payment finish redirect.
     */
    public function finish(Request $request)
    {
        $orderId = $request->get('order_id');
        $transactionStatus = $request->get('transaction_status');

        $transaction = Transaction::where('invoice_number', $orderId)->first();

        if (!$transaction) {
            return redirect()->route('packages')->with('error', 'Transaksi tidak ditemukan.');
        }

        // For development: mark as paid when Midtrans returns settlement/capture
        // In production, this should be handled by webhook
        if (in_array($transactionStatus, ['settlement', 'capture']) && !$transaction->isPaid()) {
            $transaction->markAsPaid($request->get('payment_type'), $request->get('transaction_id'));
        }

        if ($transaction->isPaid()) {
            $message = $transaction->bundle_id
                ? 'Pembayaran Bundle berhasil! Semua paket dalam bundle telah aktif.'
                : 'Pembayaran berhasil! Paket simulasi telah aktif dan siap dikerjakan.';

            return redirect()->route('dashboard')->with('success', $message);
        }

        if ($transactionStatus === 'pending') {
            return redirect()->route('dashboard')->with('info', 'Menunggu pembayaran. Silakan selesaikan pembayaran Anda.');
        }

        return redirect()->route('packages')->with('error', 'Pembayaran gagal. Silakan coba lagi.');
    }

    /**
     * Handle Midtrans webhook.
     */
    public function webhook(Request $request)
    {
        try {
            $transaction = $this->paymentService->handleNotification();

            Log::info('Payment webhook processed', [
                'invoice' => $transaction->invoice_number,
                'status' => $transaction->status,
            ]);

            return response()->json(['status' => 'ok']);
        } catch (\Exception $e) {
            Log::error('Webhook error: ' . $e->getMessage());

            return response()->json(['status' => 'error', 'message' => $e->getMessage()], 500);
        }
    }
}
