<div class="py-12">
    <div class="px-4 mx-auto max-w-7xl sm:px-6 lg:px-8">
        {{-- Welcome --}}
        <div class="mb-8">
            <h1 class="text-2xl font-bold text-gray-900">Selamat datang, {{ $user->name }}!</h1>
            <p class="text-gray-500">Berikut ringkasan aktivitas simulasi CPNS Anda.</p>
        </div>

        {{-- Stats Cards --}}
        <div class="grid grid-cols-2 gap-4 mb-8 lg:grid-cols-5">
            <div class="p-6 bg-white shadow-sm rounded-xl">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm text-gray-500">Total Simulasi</p>
                        <p class="text-2xl font-bold text-gray-900">{{ $stats['total_tests'] }}</p>
                    </div>
                    <div class="flex items-center justify-center w-12 h-12 bg-blue-100 rounded-full">
                        <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2">
                            </path>
                        </svg>
                    </div>
                </div>
            </div>

            <div class="p-6 bg-white shadow-sm rounded-xl">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm text-gray-500">Skor Rata-rata</p>
                        <p class="text-2xl font-bold text-gray-900">{{ $stats['average_score'] }}</p>
                    </div>
                    <div class="flex items-center justify-center w-12 h-12 bg-green-100 rounded-full">
                        <svg class="w-6 h-6 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z">
                            </path>
                        </svg>
                    </div>
                </div>
            </div>

            <div class="p-6 bg-white shadow-sm rounded-xl">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm text-gray-500">Skor Tertinggi</p>
                        <p class="text-2xl font-bold text-gray-900">{{ $stats['highest_score'] }}</p>
                    </div>
                    <div class="flex items-center justify-center w-12 h-12 bg-yellow-100 rounded-full">
                        <svg class="w-6 h-6 text-yellow-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M5 3v4M3 5h4M6 17v4m-2-2h4m5-16l2.286 6.857L21 12l-5.714 2.143L13 21l-2.286-6.857L5 12l5.714-2.143L13 3z">
                            </path>
                        </svg>
                    </div>
                </div>
            </div>

            <div class="p-6 bg-white shadow-sm rounded-xl">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm text-gray-500">Lulus</p>
                        <p class="text-2xl font-bold text-green-600">{{ $stats['passed_count'] }}</p>
                    </div>
                    <div class="flex items-center justify-center w-12 h-12 rounded-full bg-emerald-100">
                        <svg class="w-6 h-6 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                    </div>
                </div>
            </div>

            <div class="p-6 bg-white shadow-sm rounded-xl">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm text-gray-500">Total Pembelian</p>
                        <p class="text-xl font-bold text-gray-900">Rp
                            {{ number_format($stats['total_spent'], 0, ',', '.') }}</p>
                    </div>
                    <div class="flex items-center justify-center w-12 h-12 bg-purple-100 rounded-full">
                        <svg class="w-6 h-6 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M17 9V7a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2m2 4h10a2 2 0 002-2v-6a2 2 0 00-2-2H9a2 2 0 00-2 2v6a2 2 0 002 2zm7-5a2 2 0 11-4 0 2 2 0 014 0z">
                            </path>
                        </svg>
                    </div>
                </div>
            </div>
        </div>

        <div class="grid gap-8 lg:grid-cols-3">
            {{-- Main Content --}}
            <div class="space-y-6 lg:col-span-2">
                {{-- Purchased Packages Ready to Test --}}
                @if (count($purchasedPackages) > 0)
                    <div class="overflow-hidden bg-white shadow-sm rounded-xl">
                        <div class="p-6 border-b bg-gradient-to-r from-green-500 to-emerald-600">
                            <h2 class="text-lg font-semibold text-white">🎯 Paket Siap Dikerjakan</h2>
                            <p class="text-sm text-green-100">Klik tombol mulai untuk memulai simulasi</p>
                        </div>
                        <div class="divide-y">
                            @foreach ($purchasedPackages as $pkg)
                                <div class="flex items-center justify-between p-4 hover:bg-gray-50">
                                    <div>
                                        <p class="font-medium text-gray-900">{{ $pkg['package_name'] }}</p>
                                        <p class="text-sm text-gray-500">
                                            @if ($pkg['is_bundle'])
                                                <span
                                                    class="font-medium text-blue-600">[{{ $pkg['bundle_name'] }}]</span>
                                                •
                                            @endif
                                            Dibeli: {{ $pkg['purchased_at'] }}
                                        </p>
                                    </div>
                                    <a href="{{ route('test.simulation', ['packageSlug' => $pkg['package_slug'], 'transactionId' => $pkg['transaction_id']]) }}"
                                        class="px-4 py-2 {{ $pkg['status'] === 'in_progress' ? 'bg-blue-600 hover:bg-blue-700' : 'bg-green-600 hover:bg-green-700' }} text-white rounded-lg transition font-medium">
                                        {{ $pkg['status'] === 'in_progress' ? 'Lanjutkan Ujian' : 'Mulai Ujian' }}
                                    </a>
                                </div>
                            @endforeach
                        </div>
                    </div>
                @endif

                {{-- Recent Attempts --}}
                <div class="overflow-hidden bg-white shadow-sm rounded-xl">
                    <div class="p-6 border-b">
                        <h2 class="text-lg font-semibold text-gray-900">Riwayat Simulasi Terbaru</h2>
                    </div>

                    @if (count($recentAttempts) > 0)
                        <div class="divide-y">
                            @foreach ($recentAttempts as $attempt)
                                <div class="flex items-center justify-between p-4 hover:bg-gray-50">
                                    <div>
                                        <p class="font-medium text-gray-900">{{ $attempt['package_name'] }}</p>
                                        <p class="text-sm text-gray-500">{{ $attempt['date'] }}</p>
                                    </div>
                                    <div class="flex items-center gap-4">
                                        <div class="text-right">
                                            <p
                                                class="font-bold {{ $attempt['passed'] ? 'text-green-600' : 'text-red-600' }}">
                                                {{ $attempt['total_score'] }}/550
                                            </p>
                                            <span
                                                class="text-xs px-2 py-1 rounded-full
                                                {{ $attempt['passed'] ? 'bg-green-100 text-green-700' : 'bg-red-100 text-red-700' }}">
                                                {{ $attempt['passed'] ? 'LULUS' : 'TIDAK LULUS' }}
                                            </span>
                                        </div>
                                        @if ($attempt['status'] === 'completed' || $attempt['status'] === 'timeout')
                                            <a href="{{ route('test.result', $attempt['id']) }}"
                                                class="text-blue-600 hover:text-blue-700">
                                                <svg class="w-5 h-5" fill="none" stroke="currentColor"
                                                    viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round"
                                                        stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                                    <path stroke-linecap="round" stroke-linejoin="round"
                                                        stroke-width="2"
                                                        d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z">
                                                    </path>
                                                </svg>
                                            </a>
                                        @endif
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @else
                        <div class="p-8 text-center text-gray-500">
                            <svg class="w-12 h-12 mx-auto mb-4 text-gray-300" fill="none" stroke="currentColor"
                                viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2">
                                </path>
                            </svg>
                            <p>Belum ada riwayat simulasi</p>
                            <a href="{{ route('packages') }}"
                                class="inline-block mt-2 text-blue-600 hover:underline">
                                Mulai simulasi pertama Anda
                            </a>
                        </div>
                    @endif
                </div>
            </div>

            {{-- Quick Actions --}}
            <div>
                <div class="p-6 bg-white shadow-sm rounded-xl">
                    <h2 class="mb-4 text-lg font-semibold text-gray-900">Aksi Cepat</h2>

                    <div class="space-y-3">
                        <a href="{{ route('packages') }}" id="buyPackageBtn"
                            class="relative flex items-center gap-3 p-4 overflow-hidden transition-all duration-300 transform shadow-lg rounded-xl bg-gradient-to-r from-blue-600 to-purple-600 hover:from-blue-700 hover:to-purple-700 hover:scale-105 hover:shadow-xl group">
                            <div class="absolute inset-0 transition-opacity bg-white opacity-0 group-hover:opacity-10"></div>
                            <div class="relative z-10 flex items-center justify-center w-12 h-12 transition-transform duration-300 rounded-lg bg-white/20 backdrop-blur-sm group-hover:rotate-12">
                                <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24">
                                </svg>
                            </div>
                            <div class="relative z-10">
                                <p class="text-lg font-bold text-white">Beli Paket Baru</p>
                                <p class="text-sm text-white">Lihat paket simulasi tersedia</p>
                            </div>
                            <div class="absolute transition-opacity opacity-50 right-4 group-hover:opacity-100">
                                <svg class="w-6 h-6 text-white animate-pulse" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7l5 5m0 0l-5 5m5-5H6"></path>
                                </svg>
                            </div>
                        </a>

                        <a href="{{ route('profile') }}"
                            class="flex items-center gap-3 p-3 transition-colors rounded-lg hover:bg-gray-50">
                            <div class="flex items-center justify-center w-10 h-10 bg-gray-100 rounded-lg">
                                <svg class="w-5 h-5 text-gray-600" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
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
                <div class="p-6 mt-6 text-white shadow-sm bg-gradient-to-br from-blue-500 to-indigo-600 rounded-xl">
                    <h3 class="mb-3 font-semibold">Passing Grade SKD</h3>
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
                        <div class="flex justify-between pt-2 mt-2 border-t border-white/20">
                            <span class="text-white/80">Total Minimum</span>
                            <span class="font-bold">311</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const buyPackageBtn = document.getElementById('buyPackageBtn');

        // Floating animation
        let direction = 1;
        let position = 0;

        setInterval(() => {
            position += 0.5 * direction;
            if (position >= 5 || position <= -5) {
                direction *= -1;
            }
            buyPackageBtn.style.transform = `translateY(${position}px)`;
        }, 50);

        // Pulse effect on the icon
        const icon = buyPackageBtn.querySelector('.w-12');
        setInterval(() => {
            icon.classList.add('scale-110');
            setTimeout(() => {
                icon.classList.remove('scale-110');
            }, 200);
        }, 2000);
    });
</script>
