<?php

namespace App\Services;

use App\Models\Package;
use App\Models\Bundle;
use App\Models\Transaction;
use App\Models\User;
use Midtrans\Config;
use Midtrans\Snap;
use Midtrans\Notification;
use Exception;

class PaymentService
{
    public function __construct()
    {
        Config::$serverKey = config('services.midtrans.server_key');
        Config::$isProduction = config('services.midtrans.is_production', false);
        Config::$isSanitized = true;
        Config::$is3ds = true;

        // Disable SSL verification for local development (Windows SSL issue)
        // CURLOPT_SSL_VERIFYHOST = 81, CURLOPT_SSL_VERIFYPEER = 64
        Config::$curlOptions[81] = 0;
        Config::$curlOptions[64] = 0;
    }

    /**
     * Create a transaction for a package.
     */
    public function createPackageTransaction(User $user, Package $package): Transaction
    {
        return Transaction::create([
            'user_id' => $user->id,
            'package_id' => $package->id,
            'amount' => $package->price,
            'status' => Transaction::STATUS_PENDING,
            'invoice_number' => 'INV-' . time() . '-' . rand(100, 999),
        ]);
    }

    /**
     * Create a transaction for a bundle.
     */
    public function createBundleTransaction(User $user, Bundle $bundle): Transaction
    {
        return Transaction::create([
            'user_id' => $user->id,
            'bundle_id' => $bundle->id,
            'amount' => $bundle->discount_price,
            'status' => Transaction::STATUS_PENDING,
            'invoice_number' => 'INV-BND-' . time() . '-' . rand(100, 999),
        ]);
    }



    /**
     * Generate Midtrans Snap token for a transaction.
     */
    public function generateSnapToken(Transaction $transaction): string
    {
        $itemName = $transaction->package
            ? $transaction->package->name
            : ($transaction->bundle ? $transaction->bundle->name : 'Simulasi CPNS');

        $params = [
            'transaction_details' => [
                'order_id' => $transaction->invoice_number,
                'gross_amount' => (int) $transaction->amount,
            ],
            'customer_details' => [
                'first_name' => $transaction->user->name,
                'email' => $transaction->user->email,
                'phone' => $transaction->user->phone ?? '',
            ],
            'item_details' => [
                [
                    'id' => (string) ($transaction->package_id ?? $transaction->bundle_id),
                    'price' => (int) $transaction->amount,
                    'quantity' => 1,
                    'name' => substr($itemName, 0, 50),
                ],
            ],
            'callbacks' => [
                'finish' => route('payment.finish'),
            ],
            'expiry' => [
                'unit' => 'hours',
                'duration' => 24,
            ],
        ];

        try {
            // Use Laravel HTTP client with SSL verification disabled for development
            $isProduction = config('services.midtrans.is_production', false);
            $url = $isProduction
                ? 'https://app.midtrans.com/snap/v1/transactions'
                : 'https://app.sandbox.midtrans.com/snap/v1/transactions';

            \Illuminate\Support\Facades\Log::info('Midtrans Request', [
                'url' => $url,
                'order_id' => $params['transaction_details']['order_id'] ?? 'N/A',
                'amount' => $params['transaction_details']['gross_amount'] ?? '0'
            ]);

            /** @var \Illuminate\Http\Client\Response $response */
            $response = \Illuminate\Support\Facades\Http::withOptions([
                'verify' => false,
                'connect_timeout' => 10,
                'timeout' => 30,
            ])
                ->withBasicAuth(config('services.midtrans.server_key'), '')
                ->acceptJson()
                ->post($url, $params);

            $body = $response->json() ?: [];

            // Check if token exists in response (Midtrans returns token on success)
            if (isset($body['token'])) {
                return $body['token'];
            }

            // If no token, check for error messages
            $messages = $body['error_messages'] ?? [];
            $messageText = is_array($messages) ? implode(' ', $messages) : ($response->body() ?: '');

            if (str_contains(strtolower($messageText), 'order_id') || str_contains(strtolower($messageText), 'sudah digunakan') || str_contains(strtolower($messageText), 'already used')) {
                if ($transaction instanceof Transaction) {
                    $oldInvoice = $transaction->invoice_number;
                    $transaction->invoice_number = 'INV-' . time() . '-' . rand(1000, 9999);
                    $transaction->save();

                    $params['transaction_details']['order_id'] = $transaction->invoice_number;

                    /** @var \Illuminate\Http\Client\Response $retry */
                    $retry = \Illuminate\Support\Facades\Http::withOptions(['verify' => false])->withBasicAuth(config('services.midtrans.server_key'), '')->acceptJson()->post($url, $params);

                    if ($retry->ok()) {
                        return $retry->json('token');
                    }

                    $transaction->invoice_number = $oldInvoice;
                    $transaction->save();

                    throw new Exception('Midtrans error on retry: ' . $retry->body());
                }
            }

            throw new Exception('Midtrans error: ' . $response->body());
        } catch (Exception $e) {
            throw new Exception('Failed to generate payment token: ' . $e->getMessage());
        }
    }

    /**
     * Handle Midtrans webhook notification.
     */
    public function handleNotification(): Transaction
    {
        $notification = new Notification();

        $transaction = Transaction::where('invoice_number', $notification->order_id)->firstOrFail();

        $transactionStatus = $notification->transaction_status;
        $paymentType = $notification->payment_type;
        $fraudStatus = $notification->fraud_status ?? null;

        // Store payment data
        $transaction->update([
            'payment_data' => [
                'transaction_id' => $notification->transaction_id,
                'transaction_status' => $transactionStatus,
                'payment_type' => $paymentType,
                'fraud_status' => $fraudStatus,
                'gross_amount' => $notification->gross_amount,
                'transaction_time' => $notification->transaction_time ?? null,
            ],
            'payment_gateway_id' => $notification->transaction_id,
            'payment_method' => $paymentType,
        ]);

        // Update transaction status based on notification
        if ($transactionStatus == 'capture') {
            if ($paymentType == 'credit_card') {
                if ($fraudStatus == 'accept') {
                    $transaction->markAsPaid($paymentType, $notification->transaction_id);
                }
            }
        } elseif ($transactionStatus == 'settlement') {
            $transaction->markAsPaid($paymentType, $notification->transaction_id);
        } elseif ($transactionStatus == 'cancel' || $transactionStatus == 'deny' || $transactionStatus == 'expire') {
            $transaction->update(['status' => Transaction::STATUS_FAILED]);
        } elseif ($transactionStatus == 'pending') {
            $transaction->update(['status' => Transaction::STATUS_PENDING]);
        }

        return $transaction;
    }

    /**
     * Check if user has valid (unused) access to a package.
     */
    public function hasValidAccess(User $user, int $packageId): bool
    {
        return $user->hasAccessToPackage($packageId);
    }

    /**
     * Get user's purchase history.
     */
    public function getPurchaseHistory(User $user)
    {
        return $user->transactions()
            ->with(['package', 'bundle'])
            ->orderByDesc('created_at')
            ->get();
    }
}
