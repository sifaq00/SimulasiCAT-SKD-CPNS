<div class="py-12">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        {{-- Welcome --}}
        <div class="mb-8">
            <h1 class="text-2xl font-bold text-gray-900">Selamat datang, {{ $user->name }}!</h1>
            <p class="text-gray-500">Berikut ringkasan aktivitas simulasi CPNS Anda.</p>
        </div>

        {{-- Stats Cards --}}
        <div class="grid grid-cols-2 lg:grid-cols-5 gap-4 mb-8">
            <div class="bg-white rounded-xl shadow-sm p-6">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm text-gray-500">Total Simulasi</p>
                        <p class="text-2xl font-bold text-gray-900">{{ $stats['total_tests'] }}</p>
                    </div>
                    <div class="w-12 h-12 bg-blue-100 rounded-full flex items-center justify-center">
                        <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path>
                        </svg>
                    </div>
                </div>
            </div>

            <div class="bg-white rounded-xl shadow-sm p-6">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm text-gray-500">Skor Rata-rata</p>
                        <p class="text-2xl font-bold text-gray-900">{{ $stats['average_score'] }}</p>
                    </div>
                    <div class="w-12 h-12 bg-green-100 rounded-full flex items-center justify-center">
                        <svg class="w-6 h-6 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path>
                        </svg>
                    </div>
                </div>
            </div>

            <div class="bg-white rounded-xl shadow-sm p-6">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm text-gray-500">Skor Tertinggi</p>
                        <p class="text-2xl font-bold text-gray-900">{{ $stats['highest_score'] }}</p>
                    </div>
                    <div class="w-12 h-12 bg-yellow-100 rounded-full flex items-center justify-center">
                        <svg class="w-6 h-6 text-yellow-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 3v4M3 5h4M6 17v4m-2-2h4m5-16l2.286 6.857L21 12l-5.714 2.143L13 21l-2.286-6.857L5 12l5.714-2.143L13 3z"></path>
                        </svg>
                    </div>
                </div>
            </div>

            <div class="bg-white rounded-xl shadow-sm p-6">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm text-gray-500">Lulus</p>
                        <p class="text-2xl font-bold text-green-600">{{ $stats['passed_count'] }}</p>
                    </div>
                    <div class="w-12 h-12 bg-emerald-100 rounded-full flex items-center justify-center">
                        <svg class="w-6 h-6 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                    </div>
                </div>
            </div>

            <div class="bg-white rounded-xl shadow-sm p-6">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm text-gray-500">Total Pembelian</p>
                        <p class="text-xl font-bold text-gray-900">Rp {{ number_format($stats['total_spent'], 0, ',', '.') }}</p>
                    </div>
                    <div class="w-12 h-12 bg-purple-100 rounded-full flex items-center justify-center">
                        <svg class="w-6 h-6 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 9V7a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2m2 4h10a2 2 0 002-2v-6a2 2 0 00-2-2H9a2 2 0 00-2 2v6a2 2 0 002 2zm7-5a2 2 0 11-4 0 2 2 0 014 0z"></path>
                        </svg>
                    </div>
                </div>
            </div>
        </div>

        <div class="grid lg:grid-cols-3 gap-8">
            {{-- Main Content --}}
            <div class="lg:col-span-2 space-y-6">
                {{-- Purchased Packages Ready to Test --}}
                @if(count($purchasedPackages) > 0)
                    <div class="bg-white rounded-xl shadow-sm overflow-hidden">
                        <div class="p-6 border-b bg-gradient-to-r from-green-500 to-emerald-600">
                            <h2 class="text-lg font-semibold text-white">🎯 Paket Siap Dikerjakan</h2>
                            <p class="text-sm text-green-100">Klik tombol mulai untuk memulai simulasi</p>
                        </div>
                        <div class="divide-y">
                            @foreach($purchasedPackages as $pkg)
                                <div class="p-4 hover:bg-gray-50 flex items-center justify-between">
                                    <div>
                                        <p class="font-medium text-gray-900">{{ $pkg['package_name'] }}</p>
                                        <p class="text-sm text-gray-500">Dibeli: {{ $pkg['purchased_at'] }}</p>
                                    </div>
                                    <a href="{{ route('test.simulation', ['packageSlug' => $pkg['package_slug'], 'transactionId' => $pkg['transaction_id']]) }}" 
                                        class="px-4 py-2 bg-green-600 text-white rounded-lg hover:bg-green-700 transition font-medium">
                                        Mulai Ujian
                                    </a>
                                </div>
                            @endforeach
                        </div>
                    </div>
                @endif

                {{-- Recent Attempts --}}
                <div class="bg-white rounded-xl shadow-sm overflow-hidden">
                    <div class="p-6 border-b">
                        <h2 class="text-lg font-semibold text-gray-900">Riwayat Simulasi Terbaru</h2>
                    </div>
                    
                    @if(count($recentAttempts) > 0)
                        <div class="divide-y">
                            @foreach($recentAttempts as $attempt)
                                <div class="p-4 hover:bg-gray-50 flex items-center justify-between">
                                    <div>
                                        <p class="font-medium text-gray-900">{{ $attempt['package_name'] }}</p>
                                        <p class="text-sm text-gray-500">{{ $attempt['date'] }}</p>
                                    </div>
                                    <div class="flex items-center gap-4">
                                        <div class="text-right">
                                            <p class="font-bold {{ $attempt['passed'] ? 'text-green-600' : 'text-red-600' }}">
                                                {{ $attempt['total_score'] }}/550
                                            </p>
                                            <span class="text-xs px-2 py-1 rounded-full 
                                                {{ $attempt['passed'] ? 'bg-green-100 text-green-700' : 'bg-red-100 text-red-700' }}">
                                                {{ $attempt['passed'] ? 'LULUS' : 'TIDAK LULUS' }}
                                            </span>
                                        </div>
                                        @if($attempt['status'] === 'completed' || $attempt['status'] === 'timeout')
                                            <a href="{{ route('test.result', $attempt['id']) }}" 
                                                class="text-blue-600 hover:text-blue-700">
                                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                                                </svg>
                                            </a>
                                        @endif
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @else
                        <div class="p-8 text-center text-gray-500">
                            <svg class="w-12 h-12 mx-auto mb-4 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path>
                            </svg>
                            <p>Belum ada riwayat simulasi</p>
                            <a href="{{ route('packages') }}" class="mt-2 inline-block text-blue-600 hover:underline">
                                Mulai simulasi pertama Anda
                            </a>
                        </div>
                    @endif
                </div>
            </div>

            {{-- Quick Actions --}}
            <div>
                <div class="bg-white rounded-xl shadow-sm p-6">
                    <h2 class="text-lg font-semibold text-gray-900 mb-4">Aksi Cepat</h2>
                    
                    <div class="space-y-3">
                        <a href="{{ route('packages') }}" 
                            class="flex items-center gap-3 p-3 rounded-lg hover:bg-blue-50 transition-colors">
                            <div class="w-10 h-10 bg-blue-100 rounded-lg flex items-center justify-center">
                                <svg class="w-5 h-5 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                                </svg>
                            </div>
                            <div>
                                <p class="font-medium text-gray-900">Beli Paket Baru</p>
                                <p class="text-sm text-gray-500">Lihat paket simulasi tersedia</p>
                            </div>
                        </a>

                        <a href="{{ route('profile') }}" 
                            class="flex items-center gap-3 p-3 rounded-lg hover:bg-gray-50 transition-colors">
                            <div class="w-10 h-10 bg-gray-100 rounded-lg flex items-center justify-center">
                                <svg class="w-5 h-5 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                                </svg>
                            </div>
                            <div>
                                <p class="font-medium text-gray-900">Edit Profil</p>
                                <p class="text-sm text-gray-500">Kelola data akun Anda</p>
                            </div>
                        </a>
                    </div>
                </div>

                {{-- Passing Grade Info --}}
                <div class="bg-gradient-to-br from-blue-500 to-indigo-600 rounded-xl shadow-sm p-6 mt-6 text-white">
                    <h3 class="font-semibold mb-3">Passing Grade SKD</h3>
                    <div class="space-y-2 text-sm">
                        <div class="flex justify-between">
                            <span class="text-white/80">TWK</span>
                            <span class="font-medium">≥ 65</span>
                        </div>
                        <div class="flex justify-between">
                            <span class="text-white/80">TIU</span>
                            <span class="font-medium">≥ 80</span>
                        </div>
                        <div class="flex justify-between">
                            <span class="text-white/80">TKP</span>
                            <span class="font-medium">≥ 166</span>
                        </div>
                        <div class="flex justify-between border-t border-white/20 pt-2 mt-2">
                            <span class="text-white/80">Total Minimum</span>
                            <span class="font-bold">311</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
