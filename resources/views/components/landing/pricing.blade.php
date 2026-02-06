@props(['packages', 'bundles'])

<section class="py-20 lg:py-28 relative overflow-hidden bg-slate-900">
    {{-- Background Decorations --}}
    <div class="absolute top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2 w-full h-full">
        <div class="absolute top-1/4 left-1/4 w-96 h-96 bg-blue-600/10 blur-[120px] rounded-full"></div>
        <div class="absolute bottom-1/4 right-1/4 w-96 h-96 bg-purple-600/10 blur-[120px] rounded-full"></div>
    </div>

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10">
        {{-- Section Header --}}
        <div class="text-center mb-16">
            <h2 class="text-3xl sm:text-4xl lg:text-5xl font-bold text-white mb-4">
                Pilih <span class="gradient-text">Paket Simulasi</span> Anda
            </h2>
            <p class="text-slate-400 text-lg max-w-2xl mx-auto">
                Investasi terbaik untuk persiapan tes CPNS Anda. Dapatkan akses ke ribuan soal berkualitas.
            </p>
        </div>

        {{-- Single Packages Grid --}}
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8 items-stretch mb-16">
            {{-- Free Tier (Lead Magnet) --}}
            <div class="glass-card rounded-3xl p-8 flex flex-col border border-slate-700/50 hover:border-slate-600/50 transition-all duration-300 group">
                <div class="mb-8">
                    <h3 class="text-xl font-bold text-white mb-2">Latihan Gratis</h3>
                    <p class="text-slate-400 text-sm">Coba sistem CAT kami secara gratis.</p>
                </div>
                <div class="mb-8">
                    <span class="text-4xl font-extrabold text-white">Gratis</span>
                </div>
                <ul class="space-y-4 mb-8 flex-grow text-slate-300 text-sm">
                    <li class="flex items-center gap-3">
                        <svg class="w-5 h-5 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                        </svg>
                        {{ $packages->where('is_free', true)->first()->total_questions ?? 30 }} Soal Acak (TWK, TIU, TKP)
                    </li>
                    <li class="flex items-center gap-3">
                        <svg class="w-5 h-5 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                        </svg>
                        Timer Simulasi Aktif
                    </li>
                    <li class="flex items-center gap-3 text-slate-500 opacity-50">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                        </svg>
                        Pembahasan Lengkap
                    </li>
                </ul>
                <a href="{{ route('test.free-simulation') }}" class="w-full py-4 bg-slate-800 hover:bg-slate-700 text-white rounded-xl font-bold transition text-center shadow-lg">
                    Coba Sekarang
                </a>
            </div>

            {{-- Dynamic Individual Packages --}}
            @foreach($packages->where('is_free', false) as $package)
                @php $isPrediksi = str_contains(strtolower($package->name), 'prediksi') || $package->year == 2026; @endphp
                <div class="glass-card rounded-3xl p-8 flex flex-col transition-all duration-300 {{ $isPrediksi ? 'border-2 border-blue-500/50 relative shadow-[0_0_40px_rgba(59,130,246,0.1)] transform md:scale-105 z-20' : 'border border-slate-700/50 hover:border-slate-600/50' }} group">
                    @if($isPrediksi)
                        <div class="absolute -top-4 left-1/2 -translate-x-1/2 bg-gradient-to-r from-blue-600 to-purple-600 text-white px-4 py-1 rounded-full text-[10px] font-bold uppercase tracking-widest shadow-xl">
                            Paling Populer
                        </div>
                    @endif
                    <div class="mb-8">
                        <h3 class="text-xl font-bold text-white mb-2">{{ $package->name }}</h3>
                        <p class="text-slate-400 text-sm line-clamp-2">{{ $package->description }}</p>
                    </div>
                    <div class="mb-8">
                        <div class="flex items-baseline gap-1">
                            <span class="text-4xl font-extrabold text-white">Rp {{ number_format($package->price, 0, ',', '.') }}</span>
                            <span class="text-slate-500 text-sm">/paket</span>
                        </div>
                    </div>
                    <ul class="space-y-4 mb-8 flex-grow text-slate-300 text-sm">
                        <li class="flex items-center gap-3">
                            <svg class="w-5 h-5 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                            </svg>
                            {{ $package->total_questions }} Soal (Lengkap)
                        </li>
                        <li class="flex items-center gap-3">
                            <svg class="w-5 h-5 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                            Waktu {{ $package->duration_minutes }} Menit
                        </li>
                        <li class="flex items-center gap-3 text-green-400">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                            Pembahasan Detail & Skor CAT
                        </li>
                    </ul>
                    <a href="{{ route('payment.checkout', ['slug' => $package->slug, 'type' => 'package']) }}" class="w-full py-4 {{ $isPrediksi ? 'bg-gradient-to-r from-blue-600 to-purple-600 hover:opacity-90 shadow-lg shadow-blue-500/25' : 'bg-slate-800 hover:bg-slate-700' }} text-white rounded-xl font-bold transition text-center">
                        Beli Sekarang
                    </a>
                </div>
            @endforeach
        </div>

        {{-- Bundle Packages Section --}}
        @if($bundles->count() > 0)
            <div class="mt-16 text-center mb-10">
                <span class="inline-block px-4 py-1.5 bg-yellow-500/10 border border-yellow-500/20 text-yellow-400 rounded-full text-xs font-bold uppercase tracking-widest mb-4">
                    Penawaran Hemat
                </span>
                <h3 class="text-2xl sm:text-3xl font-bold text-white">Paket Bundle Lengkap</h3>
            </div>

            <div class="grid grid-cols-1 lg:grid-cols-2 gap-8 items-stretch">
                @foreach($bundles as $bundle)
                    <div class="glass-card rounded-3xl p-8 md:p-10 border border-purple-500/30 hover:border-purple-500/50 transition-all duration-300 relative overflow-hidden group">
                        {{-- Sparkle effect --}}
                        <div class="absolute -right-10 -top-10 w-40 h-40 bg-purple-600/20 blur-[60px] group-hover:bg-purple-600/40 transition-all"></div>
                        
                        <div class="flex flex-col md:flex-row gap-8 justify-between relative z-10">
                            <div class="flex-grow">
                                <h3 class="text-2xl font-bold text-white mb-3">{{ $bundle->name }}</h3>
                                <p class="text-slate-400 mb-6 max-w-lg">{{ $bundle->description }}</p>
                                
                                <ul class="grid grid-cols-1 sm:grid-cols-2 gap-x-6 gap-y-3 mb-8">
                                    <li class="flex items-center gap-3 text-slate-300 text-sm">
                                        <svg class="w-5 h-5 text-purple-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                                        </svg>
                                        Akses Semua Paket SKD
                                    </li>
                                    <li class="flex items-center gap-3 text-slate-300 text-sm">
                                        <svg class="w-5 h-5 text-purple-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                                        </svg>
                                        Pembahasan Terintegrasi
                                    </li>
                                </ul>
                            </div>
                            
                            <div class="md:text-right min-w-[200px] flex flex-col justify-center">
                                <div class="mb-2">
                                    <span class="text-slate-500 line-through text-lg">Rp {{ number_format($bundle->original_price, 0, ',', '.') }}</span>
                                </div>
                                <div class="mb-6">
                                    <span class="text-4xl font-black text-white">Rp {{ number_format($bundle->discount_price, 0, ',', '.') }}</span>
                                    <div class="text-purple-400 text-xs font-bold uppercase mt-1">Hemat {{ $bundle->discount_percentage }}%</div>
                                </div>
                                <a href="{{ route('payment.checkout', ['slug' => $bundle->slug, 'type' => 'bundle']) }}" class="w-full py-4 bg-white text-slate-900 rounded-xl font-bold hover:bg-slate-100 transition shadow-xl text-center">
                                    Ambil Bundle
                                </a>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        @endif
    </div>
</section>
