<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-semibold leading-tight text-gray-800">
            {{ __('Checkout') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-3xl px-4 mx-auto sm:px-6 lg:px-8">
            <div class="overflow-hidden bg-white shadow-lg rounded-2xl">
                {{-- Item Info --}}
                <div class="p-6 border-b">
                    <h1 class="mb-4 text-2xl font-bold text-gray-900">{{ $item->name }}</h1>
                    <p class="mb-4 text-gray-600">{{ $item->description }}</p>

                    @if($type === 'package')
                        <div class="grid grid-cols-2 gap-4 text-sm">
                            <div class="flex items-center gap-2">
                                <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                </svg>
                                <span>{{ $item->total_questions }} Soal</span>
                            </div>
                            <div class="flex items-center gap-2">
                                <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                </svg>
                                <span>{{ $item->duration_minutes }} Menit</span>
                            </div>
                        </div>
                    @endif
                </div>

                {{-- Price Summary --}}
                <div class="p-6 bg-gray-50">
                    <div class="flex items-center justify-between mb-2">
                        <span class="text-gray-600">Harga {{ $type === 'bundle' ? 'Bundle' : 'Paket' }}</span>
                        <span class="font-medium">
                            @if($type === 'bundle')
                                <span class="mr-2 text-sm text-gray-400 line-through">Rp {{ number_format($item->original_price, 0, ',', '.') }}</span>
                                {{ $item->formatted_discount_price }}
                            @else
                                {{ $item->formatted_price }}
                            @endif
                        </span>
                    </div>
                    <div class="flex items-center justify-between pt-4 border-t">
                        <span class="text-lg font-semibold">Total</span>
                        <span class="text-2xl font-bold text-blue-600">
                            {{ $type === 'bundle' ? $item->formatted_discount_price : $item->formatted_price }}
                        </span>
                    </div>
                </div>

                {{-- Payment Button --}}
                <div class="p-6">
                    <button
                        id="pay-button"
                        class="flex items-center justify-center w-full gap-2 py-4 text-lg font-semibold text-white transition-colors bg-blue-600 rounded-xl hover:bg-blue-700"
                    >
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 9V7a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2m2 4h10a2 2 0 002-2v-6a2 2 0 00-2-2H9a2 2 0 00-2 2v6a2 2 0 002 2zm7-5a2 2 0 11-4 0 2 2 0 014 0z"></path>
                        </svg>
                        Bayar Sekarang
                    </button>

                    <p class="mt-4 text-sm text-center text-gray-500">
                        Pembayaran diproses secara aman melalui Midtrans
                    </p>

                    @if($transaction && !$snapToken)
                        <div class="p-4 mt-4 text-yellow-700 border-l-4 border-yellow-300 rounded bg-yellow-50">
                            <div class="font-medium">Transaksi menunggu: <strong>{{ $transaction->invoice_number }}</strong></div>
                            <div class="text-sm">Kami tidak dapat membuat token pembayaran otomatis saat ini. Silakan tekan tombol "Coba Lagi" untuk mencoba kembali, atau hubungi dukungan jika masalah berlanjut.</div>
                            <div class="mt-2">
                                <button id="retry-button" class="px-4 py-2 text-white bg-yellow-600 rounded">Coba Lagi</button>
                            </div>
                        </div>
                    @endif
                </div>
            </div>

            {{-- Payment Methods Info --}}
            <div class="p-6 mt-8 bg-white shadow-sm rounded-xl">
                <h3 class="mb-4 font-semibold text-gray-900">Metode Pembayaran yang Tersedia</h3>
                <div class="grid grid-cols-2 gap-4 text-sm text-gray-600 md:grid-cols-4">
                    <div class="flex items-center gap-2">
                        <svg class="w-5 h-5 text-green-500" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/>
                        </svg>
                        Virtual Account
                    </div>
                    <div class="flex items-center gap-2">
                        <svg class="w-5 h-5 text-green-500" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/>
                        </svg>
                        E-Wallet (GoPay, OVO)
                    </div>
                    <div class="flex items-center gap-2">
                        <svg class="w-5 h-5 text-green-500" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/>
                        </svg>
                        QRIS
                    </div>
                    <div class="flex items-center gap-2">
                        <svg class="w-5 h-5 text-green-500" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/>
                        </svg>
                        Credit/Debit Card
                    </div>
                </div>
            </div>

            <div class="mt-4 text-center">
                <a href="{{ route('packages') }}" class="text-blue-600 hover:underline">
                    ← Kembali ke daftar paket
                </a>
            </div>
        </div>
    </div>

    {{-- Midtrans Script --}}
    @if(config('services.midtrans.is_production'))
        <script src="https://app.midtrans.com/snap/snap.js" data-client-key="{{ $clientKey }}"></script>
    @else
        <script src="https://app.sandbox.midtrans.com/snap/snap.js" data-client-key="{{ $clientKey }}"></script>
    @endif

    <script>
        const payButton = document.getElementById('pay-button');

        payButton.addEventListener('click', function() {
            var retryButton = document.getElementById('retry-button');
            if (retryButton) {
            }

            // Disable button and show loading
            payButton.disabled = true;
            payButton.innerHTML = `
                <svg class="w-5 h-5 mr-2 animate-spin" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                    <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                    <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                </svg>
                Memproses...
            `;

            // Request snap token
            fetch('{{ route('payment.process', $item->slug) }}?type={{ $type }}', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                }
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    // Open Midtrans Snap popup
                    window.snap.pay(data.snap_token, {
                        onSuccess: function(result) {
                            window.location.href = '{{ route('payment.finish') }}?order_id=' + data.invoice_number + '&transaction_status=settlement';
                        },
                        onPending: function(result) {
                            window.location.href = '{{ route('payment.finish') }}?order_id=' + data.invoice_number + '&transaction_status=pending';
                        },
                        onError: function(result) {
                            alert('Pembayaran gagal. Silakan coba lagi.');
                            window.location.reload();
                        },
                        onClose: function() {
                            payButton.disabled = false;
                            payButton.innerHTML = `
                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 9V7a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2m2 4h10a2 2 0 002-2v-6a2 2 0 00-2-2H9a2 2 0 00-2 2v6a2 2 0 002 2zm7-5a2 2 0 11-4 0 2 2 0 014 0z"></path>
                                </svg>
                                Bayar Sekarang
                            `;
                        }
                    });
                } else if (data.code === 'existing_pending') {
                    window.location.href = '{{ route('payment.checkout', $item->slug) }}?type={{ $type }}';
                } else {
                    alert(data.message || 'Terjadi kesalahan. Silakan coba lagi.');
                    payButton.disabled = false;
                    payButton.innerHTML = `
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 9V7a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2m2 4h10a2 2 0 002-2v-6a2 2 0 00-2-2H9a2 2 0 00-2 2v6a2 2 0 002 2zm7-5a2 2 0 11-4 0 2 2 0 014 0z"></path>
                        </svg>
                        Bayar Sekarang
                    `;
                }
            })
            .catch(error => {
                console.error('Error:', error);
                alert('Terjadi kesalahan. Silakan coba lagi.');
                payButton.disabled = false;
            });
        });

        var retryBtn = document.getElementById('retry-button');
        retryBtn?.addEventListener('click', function () {
            payButton.click();
        });
    </script>
</x-app-layout>
