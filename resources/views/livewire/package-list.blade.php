<div class="py-12">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        {{-- Hero Section --}}
        <div class="text-center mb-12">
            <h1 class="text-4xl font-bold text-gray-900 mb-4">
                Simulasi SKD CPNS
            </h1>
            <p class="text-xl text-gray-600 max-w-2xl mx-auto">
                Latihan soal SKD CPNS dengan format dan waktu seperti tes sesungguhnya. 
                Tingkatkan peluang kelulusan Anda!
            </p>
        </div>

        {{-- Stats --}}
        <div class="grid grid-cols-2 md:grid-cols-4 gap-4 mb-12">
            <div class="bg-white rounded-xl shadow-sm p-6 text-center">
                <p class="text-3xl font-bold text-blue-600">110</p>
                <p class="text-gray-500">Soal per Paket</p>
            </div>
            <div class="bg-white rounded-xl shadow-sm p-6 text-center">
                <p class="text-3xl font-bold text-blue-600">100</p>
                <p class="text-gray-500">Menit Waktu</p>
            </div>
            <div class="bg-white rounded-xl shadow-sm p-6 text-center">
                <p class="text-3xl font-bold text-blue-600">5</p>
                <p class="text-gray-500">Paket Tersedia</p>
            </div>
            <div class="bg-white rounded-xl shadow-sm p-6 text-center">
                <p class="text-3xl font-bold text-blue-600">550</p>
                <p class="text-gray-500">Skor Maksimal</p>
            </div>
        </div>

        {{-- Packages --}}
        <h2 class="text-2xl font-bold text-gray-900 mb-6">Pilih Paket Simulasi</h2>
        <div class="grid md:grid-cols-2 lg:grid-cols-3 gap-6 mb-12">
            @foreach($packages as $package)
                <div class="bg-white rounded-xl shadow-sm overflow-hidden hover:shadow-lg transition-shadow">
                    <div class="p-6">
                        <div class="flex items-center justify-between mb-4">
                            <span class="px-3 py-1 bg-blue-100 text-blue-700 rounded-full text-sm font-medium">
                                Tahun {{ $package['year'] }}
                            </span>
                            @if($package['year'] == 2026)
                                <span class="px-3 py-1 bg-yellow-100 text-yellow-700 rounded-full text-sm font-medium">
                                    Prediksi
                                </span>
                            @endif
                        </div>
                        <h3 class="text-lg font-semibold text-gray-900 mb-2">{{ $package['name'] }}</h3>
                        <p class="text-gray-500 text-sm mb-4">{{ $package['description'] }}</p>
                        
                        <div class="flex items-center justify-between mb-4">
                            <div>
                                <p class="text-2xl font-bold text-gray-900">
                                    Rp {{ number_format($package['price'], 0, ',', '.') }}
                                </p>
                                <p class="text-sm text-gray-500">per simulasi</p>
                            </div>
                        </div>

                        <div class="text-sm text-gray-500 mb-4">
                            <div class="flex items-center gap-2 mb-1">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                </svg>
                                <span>{{ $package['total_questions'] }} soal</span>
                            </div>
                            <div class="flex items-center gap-2">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                </svg>
                                <span>{{ $package['duration_minutes'] }} menit</span>
                            </div>
                        </div>

                        <button 
                            wire:click="selectPackage({{ $package['id'] }})"
                            class="w-full py-3 bg-blue-600 text-white rounded-lg hover:bg-blue-700 font-medium transition-colors"
                        >
                            Beli Sekarang
                        </button>
                    </div>
                </div>
            @endforeach
        </div>

        {{-- Bundle --}}
        @if(count($bundles) > 0)
            <h2 class="text-2xl font-bold text-gray-900 mb-6">Paket Bundle (Hemat!)</h2>
            @foreach($bundles as $bundle)
                <div class="bg-gradient-to-r from-blue-600 to-indigo-700 rounded-xl shadow-lg p-6 text-white mb-8">
                    <div class="flex flex-col md:flex-row md:items-center md:justify-between">
                        <div class="mb-4 md:mb-0">
                            <span class="inline-block px-3 py-1 bg-yellow-400 text-yellow-900 rounded-full text-sm font-medium mb-2">
                                HEMAT 30%
                            </span>
                            <h3 class="text-2xl font-bold mb-2">{{ $bundle['name'] }}</h3>
                            <p class="text-white/80">{{ $bundle['description'] }}</p>
                        </div>
                        <div class="text-right">
                            <p class="text-white/60 line-through">
                                Rp {{ number_format($bundle['original_price'], 0, ',', '.') }}
                            </p>
                            <p class="text-3xl font-bold">
                                Rp {{ number_format($bundle['discount_price'], 0, ',', '.') }}
                            </p>
                            <button 
                                wire:click="selectBundle({{ $bundle['id'] }})"
                                class="mt-2 px-6 py-3 bg-white text-blue-700 rounded-lg font-medium hover:bg-gray-100 transition-colors"
                            >
                                Beli Bundle
                            </button>
                        </div>
                    </div>
                </div>
            @endforeach
        @endif

        {{-- Features --}}
        <div class="grid md:grid-cols-3 gap-6 mt-12">
            <!-- ... features content ... -->
            <div class="text-center p-6">
                <div class="w-16 h-16 bg-blue-100 rounded-full flex items-center justify-center mx-auto mb-4">
                    <svg class="w-8 h-8 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                </div>
                <h3 class="font-semibold text-gray-900 mb-2">Soal Berkualitas</h3>
                <p class="text-gray-500">Soal berdasarkan tes CPNS tahun-tahun sebelumnya</p>
            </div>
            <div class="text-center p-6">
                <div class="w-16 h-16 bg-green-100 rounded-full flex items-center justify-center mx-auto mb-4">
                    <svg class="w-8 h-8 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                </div>
                <h3 class="font-semibold text-gray-900 mb-2">Timer Realistis</h3>
                <p class="text-gray-500">Waktu 100 menit seperti tes sesungguhnya</p>
            </div>
            <div class="text-center p-6">
                <div class="w-16 h-16 bg-purple-100 rounded-full flex items-center justify-center mx-auto mb-4">
                    <svg class="w-8 h-8 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path>
                    </svg>
                </div>
                <h3 class="font-semibold text-gray-900 mb-2">Pembahasan Lengkap</h3>
                <p class="text-gray-500">Setiap soal disertai pembahasan detail</p>
            </div>
        </div>
    </div>

    {{-- Payment Modal --}}
    @if($showPaymentModal && ($selectedPackage || $selectedBundle))
        @php
            $item = $selectedPackage ?? $selectedBundle;
            $itemName = $selectedPackage ? $item->name : $item->name . ' (Bundle)';
            $itemPrice = $selectedPackage ? $item->price : $item->discount_price; // Bundle uses discount_price
            $itemSlug = $item->slug;
            $checkoutRoute = route('payment.checkout', ['slug' => $itemSlug, 'type' => $selectedPackage ? 'package' : 'bundle']);
        @endphp
        <div class="fixed inset-0 bg-black/50 flex items-center justify-center z-50">
            <div class="bg-white rounded-xl max-w-md w-full mx-4 overflow-hidden">
                <div class="p-6">
                    <h3 class="text-xl font-bold text-gray-900 mb-2">Konfirmasi Pembelian</h3>
                    <p class="text-gray-500 mb-4">{{ $itemName }}</p>
                    
                    <div class="bg-gray-50 rounded-lg p-4 mb-4">
                        <div class="flex justify-between mb-2">
                            <span class="text-gray-600">Harga</span>
                            <span class="font-medium">Rp {{ number_format($itemPrice, 0, ',', '.') }}</span>
                        </div>
                        <div class="flex justify-between border-t pt-2">
                            <span class="font-semibold">Total</span>
                            <span class="font-bold text-blue-600">Rp {{ number_format($itemPrice, 0, ',', '.') }}</span>
                        </div>
                    </div>

                    <p class="text-sm text-gray-500 mb-4">
                        Setelah pembayaran berhasil, Anda dapat langsung memulai simulasi.
                    </p>

                    <div class="flex gap-3">
                        <button 
                            wire:click="closeModal"
                            class="flex-1 py-3 bg-gray-200 text-gray-700 rounded-lg hover:bg-gray-300 font-medium"
                        >
                            Batal
                        </button>
                        <a 
                            href="{{ $checkoutRoute }}"
                            class="flex-1 py-3 bg-blue-600 text-white rounded-lg hover:bg-blue-700 font-medium text-center"
                        >
                            Bayar Sekarang
                        </a>
                    </div>
                </div>
            </div>
        </div>
    @endif
</div>
