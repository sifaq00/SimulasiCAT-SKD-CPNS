<div class="py-6 pt-20 md:py-12 md:pt-28 min-h-screen bg-slate-50/50 relative overflow-hidden" x-data="{ showExamModal: false, examUrl: '', examName: '' }">
    {{-- Subtle Background Accents --}}
    <div class="fixed top-0 left-0 w-full h-full pointer-events-none">
        <div class="absolute top-[-10%] left-[-10%] w-[50%] h-[50%] bg-blue-500/5 blur-[120px] rounded-full"></div>
        <div class="absolute bottom-[-10%] right-[-10%] w-[50%] h-[50%] bg-indigo-500/5 blur-[120px] rounded-full"></div>
    </div>

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10">
        {{-- Welcome Section --}}
        <div class="flex flex-col md:flex-row md:items-center justify-between gap-4 md:gap-6 mb-8 md:mb-12">
            <div>
                <h1 class="text-2xl md:text-3xl lg:text-4xl font-extrabold text-slate-900 font-jakarta tracking-tight mb-2">
                    Halo, <span class="bg-gradient-to-r from-blue-600 to-indigo-600 bg-clip-text text-transparent">{{ auth()->user()->name }}</span>!
                    <svg class="inline-block w-6 h-6 md:w-8 md:h-8 lg:w-10 lg:h-10 text-amber-500 animate-bounce ml-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14.828 14.828a4 4 0 01-5.656 0M9 10h.01M15 10h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
                </h1>
                <p class="text-sm md:text-base text-slate-500 font-medium">Siap tembus CPNS tahun ini? Yuk, lanjut latihan lagi.</p>
            </div>
        </div>

        {{-- Stats Grid --}}
        <div class="grid grid-cols-2 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-5 gap-3 md:gap-4 mb-8 md:mb-10">
            {{-- Card 1: Ujian Selesai --}}
            <div class="bg-white/60 backdrop-blur-xl rounded-2xl p-3 md:p-4 border border-white/40 shadow-sm group hover:shadow-lg hover:shadow-blue-500/5 transition-all duration-500 flex flex-col sm:flex-row items-center sm:items-start gap-2 md:gap-3 text-center sm:text-left">
                <div class="w-8 h-8 md:w-10 md:h-10 shrink-0 bg-blue-50 text-blue-600 rounded-xl flex items-center justify-center group-hover:bg-blue-600 group-hover:text-white transition-all duration-500 border border-blue-100">
                    <svg class="w-4 h-4 md:w-5 md:h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4" /></svg>
                </div>
                <div>
                    <p class="text-[8px] md:text-[9px] font-black text-slate-400 uppercase tracking-widest mb-0.5">Ujian Selesai</p>
                    <p class="text-lg md:text-xl font-extrabold text-slate-900 group-hover:text-blue-600 transition-colors font-jakarta tracking-tight leading-none">{{ $stats['total_tests'] }}</p>
                </div>
            </div>

            {{-- Card 2: Rata-rata Skor --}}
            <div class="bg-white/60 backdrop-blur-xl rounded-2xl p-3 md:p-4 border border-white/40 shadow-sm group hover:shadow-lg hover:shadow-violet-500/5 transition-all duration-500 flex flex-col sm:flex-row items-center sm:items-start gap-2 md:gap-3 text-center sm:text-left">
                <div class="w-8 h-8 md:w-10 md:h-10 shrink-0 bg-violet-50 text-violet-600 rounded-xl flex items-center justify-center group-hover:bg-violet-600 group-hover:text-white transition-all duration-500 border border-violet-100">
                    <svg class="w-4 h-4 md:w-5 md:h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6" /></svg>
                </div>
                <div>
                    <p class="text-[8px] md:text-[9px] font-black text-slate-400 uppercase tracking-widest mb-0.5">Rata Skor</p>
                    <p class="text-lg md:text-xl font-extrabold text-slate-900 group-hover:text-violet-600 transition-colors font-jakarta tracking-tight leading-none">{{ $stats['average_score'] }}</p>
                </div>
            </div>

            {{-- Card 3: Skor Tertinggi --}}
            <div class="bg-white/60 backdrop-blur-xl rounded-2xl p-3 md:p-4 border border-white/40 shadow-sm group hover:shadow-lg hover:shadow-amber-500/5 transition-all duration-500 flex flex-col sm:flex-row items-center sm:items-start gap-2 md:gap-3 text-center sm:text-left">
                <div class="w-8 h-8 md:w-10 md:h-10 shrink-0 bg-amber-50 text-amber-600 rounded-xl flex items-center justify-center group-hover:bg-amber-600 group-hover:text-white transition-all duration-500 border border-amber-100">
                    <svg class="w-4 h-4 md:w-5 md:h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 3v4M3 5h4M6 17v4m-2-2h4m5-16l2.286 6.857L21 12l-5.714 2.143L13 21l-2.286-6.857L5 12l5.714-2.143L13 3z" /></svg>
                </div>
                <div>
                    <p class="text-[8px] md:text-[9px] font-black text-slate-400 uppercase tracking-widest mb-0.5">Skor Terbaik</p>
                    <p class="text-lg md:text-xl font-extrabold text-slate-900 group-hover:text-amber-600 transition-colors font-jakarta tracking-tight leading-none">{{ $stats['highest_score'] }}</p>
                </div>
            </div>

            {{-- Card 4: Lulus --}}
            <div class="bg-white/60 backdrop-blur-xl rounded-2xl p-3 md:p-4 border border-white/40 shadow-sm group hover:shadow-lg hover:shadow-emerald-500/5 transition-all duration-500 flex flex-col sm:flex-row items-center sm:items-start gap-2 md:gap-3 text-center sm:text-left">
                <div class="w-8 h-8 md:w-10 md:h-10 shrink-0 bg-emerald-50 text-emerald-600 rounded-xl flex items-center justify-center group-hover:bg-emerald-600 group-hover:text-white transition-all duration-500 border border-emerald-100">
                    <svg class="w-4 h-4 md:w-5 md:h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" /></svg>
                </div>
                <div>
                    <p class="text-[8px] md:text-[9px] font-black text-slate-400 uppercase tracking-widest mb-0.5">Target Lulus</p>
                    <p class="text-lg md:text-xl font-extrabold text-slate-900 group-hover:text-emerald-600 transition-colors font-jakarta tracking-tight leading-none">{{ $stats['passed_count'] }}</p>
                </div>
            </div>

            {{-- Card 5: Investasi --}}
            <div class="col-span-2 xl:col-span-1 bg-white/60 backdrop-blur-xl rounded-2xl p-3 md:p-4 border border-white/40 shadow-sm group hover:shadow-lg hover:shadow-rose-500/5 transition-all duration-500 flex flex-col sm:flex-row items-center sm:items-start gap-2 md:gap-3 text-center sm:text-left">
                <div class="w-8 h-8 md:w-10 md:h-10 shrink-0 bg-rose-50 text-rose-600 rounded-xl flex items-center justify-center group-hover:bg-rose-600 group-hover:text-white transition-all duration-500 border border-rose-100">
                    <svg class="w-4 h-4 md:w-5 md:h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 9V7a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2m2 4h10a2 2 0 002-2v-6a2 2 0 00-2-2H9a2 2 0 00-2 2v6a2 2 0 002 2zm7-5a2 2 0 11-4 0 2 2 0 014 0z" /></svg>
                </div>
                <div class="flex-1 min-w-0">
                    <p class="text-[8px] md:text-[9px] font-black text-slate-400 uppercase tracking-widest mb-0.5">Investasi</p>
                    <p class="text-sm md:text-[15px] font-extrabold text-slate-900 group-hover:text-rose-600 transition-colors font-jakarta tracking-tight leading-none truncate">Rp {{ number_format($stats['total_spent'], 0, ',', '.') }}</p>
                </div>
            </div>
        </div>

        {{-- Mobile Quick Actions (Visible only on small screens) --}}
        <div class="grid grid-cols-2 gap-3 mb-8 md:hidden">
            <a href="{{ route('packages') }}" class="flex flex-col items-center justify-center gap-2 p-4 bg-white/60 backdrop-blur-xl rounded-2xl border border-white/40 shadow-sm hover:bg-white/80 transition-all group">
                <div class="w-10 h-10 bg-blue-100 text-blue-600 rounded-xl flex items-center justify-center group-active:scale-95 transition-transform">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" /></svg>
                </div>
                <span class="text-[10px] font-black text-slate-900 uppercase tracking-widest font-jakarta">Tambah Paket</span>
            </a>
            <a href="{{ route('profile') }}" class="flex flex-col items-center justify-center gap-2 p-4 bg-white/60 backdrop-blur-xl rounded-2xl border border-white/40 shadow-sm hover:bg-white/80 transition-all group">
                <div class="w-10 h-10 bg-slate-100 text-slate-600 rounded-xl flex items-center justify-center group-active:scale-95 transition-transform">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" /></svg>
                </div>
                <span class="text-[10px] font-black text-slate-900 uppercase tracking-widest font-jakarta">Edit Profil</span>
            </a>
        </div>

        <div class="grid md:grid-cols-2 lg:grid-cols-3 gap-6 md:gap-8 items-start">
            {{-- Main Content --}}
            <div class="md:col-span-1 lg:col-span-2 space-y-12">
                {{-- Ready to Test Section --}}
                <section>
                    <div class="flex items-center justify-between mb-8">
                        <h2 class="text-xl md:text-2xl font-bold text-slate-900 font-jakarta tracking-tight flex items-center gap-2">
                            Paket Saya
                            <svg class="w-5 h-5 md:w-6 md:h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10" /></svg>
                        </h2>
                        <a href="{{ route('packages') }}" class="text-xs md:text-sm font-bold text-blue-600 hover:text-blue-700 transition-colors flex items-center gap-1 group">
                            Cek Paket Lain <svg class="w-3.5 h-3.5 md:w-4 md:h-4 group-hover:translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" /></svg>
                        </a>
                    </div>
                    
                    <div class="grid sm:grid-cols-2 gap-4 md:gap-6">
                        @forelse($purchasedPackages as $package)
                            <div class="group relative bg-white/60 backdrop-blur-xl rounded-3xl border border-white/40 p-5 md:p-6 shadow-sm hover:shadow-2xl hover:shadow-blue-500/10 transition-all duration-500 overflow-hidden flex flex-col">
                                {{-- Decorative corner --}}
                                <div class="absolute top-0 right-0 w-24 h-24 bg-blue-500/5 blur-2xl rounded-full translate-x-10 -translate-y-10 group-hover:scale-150 transition-transform duration-700"></div>

                                <div class="relative z-10 flex flex-col h-full">
                                    <div class="flex items-center justify-between mb-4">
                                        <span class="px-2.5 py-1 bg-slate-900 text-white rounded-lg text-[10px] font-black tracking-widest uppercase shadow-sm">
                                            SKD {{ $package['package_year'] }}
                                        </span>
                                        @if($package['status'] === 'in_progress')
                                            <span class="flex items-center gap-1.5 px-3 py-1 bg-amber-50 text-amber-600 rounded-full text-[10px] font-black tracking-widest uppercase border border-amber-100 animate-pulse">
                                                <span class="w-1.5 h-1.5 bg-amber-500 rounded-full"></span>
                                                BERJALAN
                                            </span>
                                        @endif
                                    </div>
                                    
                                    <h3 class="text-base md:text-lg font-bold text-slate-900 font-jakarta mb-1 tracking-tight group-hover:text-blue-600 transition-colors leading-tight">
                                        {{ $package['package_name'] }}
                                    </h3>
                                    
                                    <div class="flex items-center gap-2 mb-6">
                                        @if($package['is_bundle'])
                                            <span class="text-[9px] font-bold text-blue-600 bg-blue-50 px-2 py-0.5 rounded uppercase font-jakarta tracking-wide">{{ $package['bundle_name'] }}</span>
                                        @endif
                                        <span class="text-slate-400 text-[10px] font-bold uppercase tracking-wider font-jakarta">{{ $package['purchased_at'] }}</span>
                                    </div>

                                    <div class="mt-auto pt-4 border-t border-slate-100/50 flex items-center justify-between gap-4">
                                        <div class="flex items-center gap-2">
                                            <div class="w-8 h-8 rounded-lg bg-blue-50 text-blue-600 flex items-center justify-center">
                                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
                                            </div>
                                            <span class="text-[10px] font-bold text-slate-500 uppercase tracking-widest font-jakarta">100 Menit</span>
                                        </div>

                                        <button 
                                            @click="showExamModal = true; examUrl = '{{ route('test.simulation', ['packageSlug' => $package['package_slug'], 'transactionId' => $package['transaction_id']]) }}'; examName = '{{ $package['package_name'] }}'"
                                            class="inline-flex items-center justify-center px-6 py-2.5 rounded-xl shadow-lg hover:shadow-xl font-bold transition-all duration-300 font-jakarta text-[10px] md:text-xs tracking-widest uppercase {{ $package['status'] === 'in_progress' ? 'bg-amber-500 text-white hover:bg-amber-600 shadow-amber-500/20' : 'bg-blue-600 text-white hover:bg-blue-700 shadow-blue-600/20' }}">
                                            {{ $package['status'] === 'in_progress' ? 'Lanjut' : 'Mulai' }}
                                        </button>
                                    </div>
                                </div>
                            </div>
                        @empty
                            <div class="col-span-full bg-white/40 backdrop-blur rounded-[2rem] border border-dashed border-slate-200 p-8 md:p-12 text-center shadow-sm">
                                <div class="w-16 h-16 bg-slate-50 rounded-2xl flex items-center justify-center mx-auto mb-4 text-slate-300">
                                    <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4" /></svg>
                                </div>
                                <h3 class="text-lg font-bold text-slate-900 mb-1 font-jakarta">Belum ada paket aktif</h3>
                                <p class="text-slate-500 text-sm mb-8 max-w-xs mx-auto font-medium">Miliki paket latihan pertamamu untuk memulai persiapan menembus CPNS.</p>
                                <a href="{{ route('packages') }}" class="inline-flex items-center gap-2 px-8 py-3 bg-blue-600 text-white rounded-xl md:rounded-2xl text-xs md:text-sm font-black uppercase tracking-widest hover:bg-blue-700 transition-all font-jakarta shadow-xl shadow-blue-600/20">
                                    Beli Paket Sekarang
                                </a>
                            </div>
                        @endforelse
                    </div>
                </section>

                {{-- Recent History Section --}}
                <section>
                    <div class="flex items-center justify-between mb-6 md:mb-8">
                        <h2 class="text-xl md:text-2xl font-bold text-slate-900 font-jakarta tracking-tight flex items-center gap-2">
                            Riwayat Ujian
                            <svg class="w-5 h-5 md:w-6 md:h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
                        </h2>
                        @if(count($recentAttempts) > 0)
                            <a href="{{ route('test.history') }}" class="inline-flex items-center gap-2 px-3 py-1.5 md:px-4 md:py-2 bg-blue-50 text-blue-600 hover:bg-blue-100 hover:text-blue-700 rounded-xl text-xs font-bold transition-all font-jakarta uppercase tracking-widest shadow-sm">
                                Lihat Semua
                                <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" /></svg>
                            </a>
                        @endif
                    </div>

                    {{-- Desktop History Table --}}
                    <div class="hidden md:block bg-white/60 backdrop-blur-xl rounded-[2rem] border border-white/40 shadow-sm overflow-hidden">
                        <div class="overflow-x-auto">
                            <table class="w-full">
                                <thead>
                                    <tr class="bg-slate-50/50">
                                        <th class="px-6 py-5 text-left text-[10px] font-black text-slate-400 uppercase tracking-widest font-jakarta">Daftar Ujian</th>
                                        <th class="px-6 py-5 text-left text-[10px] font-black text-slate-400 uppercase tracking-widest font-jakarta">Tanggal</th>
                                        <th class="px-6 py-5 text-left text-[10px] font-black text-slate-400 uppercase tracking-widest font-jakarta">Skor</th>
                                        <th class="px-6 py-5 text-left text-[10px] font-black text-slate-400 uppercase tracking-widest font-jakarta">Hasil</th>
                                        <th class="px-6 py-5 text-right text-[10px] font-black text-slate-400 uppercase tracking-widest font-jakarta">Detail</th>
                                    </tr>
                                </thead>
                                <tbody class="divide-y divide-slate-100">
                                    @forelse($recentAttempts as $attempt)
                                        <tr class="hover:bg-blue-50/30 transition-colors group">
                                            <td class="px-6 py-5">
                                                <div class="font-bold text-slate-900 font-jakarta text-sm leading-tight">{{ $attempt['package_name'] }}</div>
                                            </td>
                                            <td class="px-6 py-5">
                                                <div class="text-[11px] font-bold text-slate-500 font-jakarta uppercase tracking-wider">{{ $attempt['date'] }}</div>
                                            </td>
                                            <td class="px-6 py-5">
                                                <div class="flex flex-col gap-1.5">
                                                    <div class="text-lg font-black text-slate-900 font-jakarta leading-none tracking-tight">{{ $attempt['total_score'] }}</div>
                                                    <div class="flex flex-wrap items-center gap-2 text-[9px] font-black text-slate-400 uppercase tracking-widest font-jakarta">
                                                        <span class="flex items-center gap-0.5"><span class="w-1 h-1 rounded-full {{ $attempt['score_twk'] >= 65 ? 'bg-emerald-500' : 'bg-slate-300' }}"></span> TWK: <span class="{{ $attempt['score_twk'] >= 65 ? 'text-emerald-600' : 'text-slate-500' }}">{{ $attempt['score_twk'] }}</span></span>
                                                        <span class="text-slate-200">•</span>
                                                        <span class="flex items-center gap-0.5"><span class="w-1 h-1 rounded-full {{ $attempt['score_tiu'] >= 80 ? 'bg-emerald-500' : 'bg-slate-300' }}"></span> TIU: <span class="{{ $attempt['score_tiu'] >= 80 ? 'text-emerald-600' : 'text-slate-500' }}">{{ $attempt['score_tiu'] }}</span></span>
                                                        <span class="text-slate-200">•</span>
                                                        <span class="flex items-center gap-0.5"><span class="w-1 h-1 rounded-full {{ $attempt['score_tkp'] >= 166 ? 'bg-emerald-500' : 'bg-slate-300' }}"></span> TKP: <span class="{{ $attempt['score_tkp'] >= 166 ? 'text-emerald-600' : 'text-slate-500' }}">{{ $attempt['score_tkp'] }}</span></span>
                                                    </div>
                                                </div>
                                            </td>
                                            <td class="px-6 py-5">
                                                @if($attempt['passed'])
                                                    <span class="inline-flex items-center gap-1.5 px-3 py-1 bg-emerald-50 text-emerald-600 rounded-full text-[10px] font-black uppercase tracking-widest border border-emerald-100 shadow-sm">
                                                        <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" /></svg>
                                                        LULUS
                                                    </span>
                                                @else
                                                    <span class="inline-flex items-center gap-1.5 px-3 py-1 bg-rose-50 text-rose-500 rounded-full text-[10px] font-black uppercase tracking-widest border border-rose-100 shadow-sm">
                                                        <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" /></svg>
                                                        GAGAL
                                                    </span>
                                                @endif
                                            </td>
                                            <td class="px-6 py-5 text-right">
                                                @if($attempt['status'] === 'completed' || $attempt['status'] === 'timeout')
                                                    <a href="{{ route('test.result', $attempt['id']) }}" class="w-8 h-8 rounded-lg bg-white border border-slate-100 text-slate-400 hover:text-blue-600 hover:border-blue-200 hover:shadow-lg transition-all inline-flex items-center justify-center group/btn" wire:navigate>
                                                        <svg class="w-4 h-4 group-hover/btn:translate-x-0.5 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3" /></svg>
                                                    </a>
                                                @endif
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="5" class="px-6 py-16 text-center">
                                                <div class="w-12 h-12 bg-slate-50 rounded-xl flex items-center justify-center mx-auto mb-3 text-slate-300">
                                                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" /></svg>
                                                </div>
                                                <p class="text-slate-500 text-sm font-bold font-jakarta">Belum ada riwayat ujian.</p>
                                            </td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>

                    {{-- Mobile History Cards --}}
                    <div class="md:hidden space-y-3">
                        @forelse($recentAttempts as $attempt)
                            <div class="bg-white/60 backdrop-blur-xl rounded-2xl border border-white/40 p-5 shadow-sm">
                                <div class="flex justify-between items-start mb-4">
                                    <div class="pr-2">
                                        <h4 class="font-bold text-slate-900 font-jakarta text-sm leading-tight mb-1">{{ $attempt['package_name'] }}</h4>
                                        <p class="text-[10px] font-bold text-slate-400 uppercase tracking-widest font-jakarta">{{ $attempt['date'] }}</p>
                                    </div>
                                    @if($attempt['passed'])
                                        <span class="inline-flex items-center gap-1 px-2.5 py-0.5 bg-emerald-50 text-emerald-600 rounded-full text-[9px] font-black uppercase tracking-widest border border-emerald-100">
                                            LULUS
                                        </span>
                                    @else
                                        <span class="inline-flex items-center gap-1 px-2.5 py-0.5 bg-rose-50 text-rose-500 rounded-full text-[9px] font-black uppercase tracking-widest border border-rose-100">
                                            GAGAL
                                        </span>
                                    @endif
                                </div>
                                
                                <div class="flex items-center justify-between pt-4 border-t border-slate-100/50">
                                    <div>
                                        <p class="text-[8px] font-black text-slate-400 uppercase tracking-widest mb-0.5">Total Skor</p>
                                        <p class="text-xl font-black text-slate-900 font-jakarta leading-none tracking-tight">{{ $attempt['total_score'] }}</p>
                                    </div>
                                    
                                    @if($attempt['status'] === 'completed' || $attempt['status'] === 'timeout')
                                        <a href="{{ route('test.result', $attempt['id']) }}" class="flex items-center gap-1.5 px-4 py-2 bg-slate-900 text-white rounded-xl text-[10px] font-bold uppercase tracking-widest hover:bg-slate-800 transition-colors shadow-lg shadow-slate-900/10" wire:navigate>
                                            Detail
                                            <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3" /></svg>
                                        </a>
                                    @endif
                                </div>
                            </div>
                        @empty
                            <div class="bg-white/60 backdrop-blur-xl rounded-2xl border border-white/40 p-8 text-center shadow-sm">
                                <div class="w-10 h-10 bg-slate-50 rounded-xl flex items-center justify-center mx-auto mb-3 text-slate-300">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
                                </div>
                                <p class="text-slate-500 text-xs font-bold font-jakarta">Belum ada riwayat ujian.</p>
                            </div>
                        @endforelse
                    </div>
                </section>
            </div>

            {{-- Sidebar --}}
            <aside class="space-y-8">
                {{-- Quick Actions (Desktop Only) --}}
                <div class="hidden md:block bg-gradient-to-br from-slate-900 to-blue-900 rounded-[2rem] p-6 shadow-xl shadow-blue-900/10 group relative overflow-hidden border border-white/5">
                    {{-- Decorative highlight --}}
                    <div class="absolute -top-10 -right-10 w-32 h-32 bg-blue-500/10 blur-3xl rounded-full group-hover:bg-blue-500/20 transition-all duration-700"></div>
                    
                    <h3 class="text-lg font-bold text-white font-jakarta mb-6 tracking-tight relative z-10 flex items-center gap-2">
                        Menu Cepat
                        <span class="inline-block w-1.5 h-1.5 bg-blue-400 rounded-full animate-pulse"></span>
                    </h3>
                    
                    <div class="space-y-3 relative z-10">
                        <a href="{{ route('packages') }}" class="flex items-center gap-4 p-4 bg-white/5 hover:bg-white/10 rounded-2xl transition-all group/item border border-white/5 hover:border-white/10 shadow-lg">
                            <div class="w-10 h-10 bg-blue-600 text-white rounded-xl flex items-center justify-center group-hover/item:rotate-12 transition-all">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6" /></svg>
                            </div>
                            <div class="text-left">
                                <p class="text-[13px] font-black text-white font-jakarta uppercase tracking-wider">Tambah Paket</p>
                                <p class="text-[10px] text-slate-400 font-bold uppercase tracking-widest">Akses Tryout Baru</p>
                            </div>
                        </a>
                        
                        <a href="{{ route('profile') }}" class="flex items-center gap-4 p-4 bg-white/5 hover:bg-white/10 rounded-2xl transition-all group/item border border-white/5 hover:border-white/10 shadow-lg">
                            <div class="w-10 h-10 bg-slate-700 text-white rounded-xl flex items-center justify-center group-hover/item:-rotate-12 transition-all">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" /></svg>
                            </div>
                            <div class="text-left">
                                <p class="text-[13px] font-black text-white font-jakarta uppercase tracking-wider">Edit Profil</p>
                                <p class="text-[10px] text-slate-400 font-bold uppercase tracking-widest">Informasi Akun</p>
                            </div>
                        </a>
                    </div>
                </div>

                {{-- Passing Grade Info --}}
                <div class="bg-white/60 backdrop-blur-xl rounded-[2rem] border border-white/40 p-8 shadow-sm relative group overflow-visible" x-data="{ showInfo: false }">
                    {{-- Premium Background Glow --}}
                    <div class="absolute -top-24 -right-24 w-48 h-48 bg-blue-500/5 blur-[80px] rounded-full pointer-events-none"></div>
                    
                    <div class="flex items-center justify-between mb-6 relative z-10">
                        <div>
                            <h3 class="text-lg font-black text-slate-900 font-jakarta tracking-tight">Passing Grade</h3>
                            <p class="text-[10px] font-bold text-slate-400 uppercase tracking-widest mt-0.5">Target SKD 2024</p>
                        </div>
                        <button @click="showInfo = !showInfo" :class="showInfo ? 'bg-blue-600 text-white rotate-180' : 'bg-slate-50 text-slate-300 hover:text-blue-600 hover:bg-blue-50'" class="w-8 h-8 rounded-xl flex items-center justify-center transition-all border border-slate-100 shadow-sm">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" /></svg>
                        </button>
                    </div>

                    {{-- Expandable Info Panel --}}
                    <div x-show="showInfo" 
                         x-transition:enter="transition ease-out duration-200"
                         x-transition:enter-start="opacity-0 -translate-y-2"
                         x-transition:enter-end="opacity-100 translate-y-0"
                         x-transition:leave="transition ease-in duration-150"
                         x-transition:leave-start="opacity-100 translate-y-0"
                         x-transition:leave-end="opacity-0 -translate-y-2"
                         class="mb-8 p-5 bg-slate-900/95 backdrop-blur-xl text-white rounded-2xl shadow-xl font-jakarta border border-white/10 relative z-20">
                        <div class="flex items-center gap-2 mb-3">
                            <div class="w-2 h-2 bg-blue-400 rounded-full shadow-[0_0_8px_rgba(96,165,250,0.8)]"></div>
                            <span class="text-[10px] font-black uppercase tracking-widest text-blue-100">Info Ambang Batas</span>
                        </div>
                        <p class="text-xs leading-relaxed text-slate-300 font-medium">
                            Data di bawah menunjukkan perbandingan skor terbaik Anda dengan ambang batas resmi Kepmenpan-RB. Skor harus melewati garis target untuk status <span class="text-emerald-400 font-bold">AMAN</span>.
                        </p>
                        <div class="mt-4 pt-4 border-t border-white/10 grid grid-cols-2 gap-2 text-[10px] uppercase font-black tracking-tighter">
                            <div class="flex items-center gap-2"><span class="w-2 h-2 rounded-full bg-blue-500 shadow"></span> Skor Kamu</div>
                            <div class="flex items-center gap-2"><span class="w-2 h-2 rounded-full bg-emerald-500 shadow"></span> Target</div>
                        </div>
                    </div>

                    <div class="space-y-8 relative z-10">
                        {{-- TWK Item --}}
                        <div class="group/item relative">
                            <div class="flex justify-between items-end mb-3">
                                <div>
                                    <span class="text-[10px] font-black text-slate-400 uppercase tracking-[0.2em] font-jakarta block mb-1">Tes Wawasan Kebangsaan</span>
                                    <div class="flex items-center gap-2">
                                        <span class="text-2xl font-black {{ $stats['highest_twk'] >= 65 ? 'text-emerald-600' : 'text-slate-900' }} font-jakarta tracking-tighter">{{ $stats['highest_twk'] }}</span>
                                        <div class="px-2 py-0.5 rounded-md bg-slate-50 border border-slate-100">
                                            <span class="text-[9px] font-black text-slate-400 uppercase tracking-widest">Skor Terbaikmu</span>
                                        </div>
                                    </div>
                                </div>
                                <div class="text-right">
                                    <div class="flex items-center gap-1.5 justify-end">
                                        <span class="text-[10px] font-black text-slate-300 uppercase">Target:</span>
                                        <span class="text-xs font-black text-blue-600 font-jakarta">65</span>
                                    </div>
                                    <span class="text-[9px] font-bold text-slate-400">Max: 150</span>
                                </div>
                            </div>
                            <div class="h-3 w-full bg-slate-100 rounded-full overflow-hidden relative border border-slate-50 shadow-inner">
                                {{-- Target Line --}}
                                <div class="absolute left-[43.3%] top-0 w-0.5 h-full bg-slate-300 z-10"></div>
                                <div class="h-full {{ $stats['highest_twk'] >= 65 ? 'bg-gradient-to-r from-emerald-400 to-emerald-600 shadow-[0_0_15px_rgba(16,185,129,0.4)]' : 'bg-gradient-to-r from-blue-400 to-blue-600 shadow-[0_0_15px_rgba(37,99,235,0.4)]' }} transition-all duration-[1.5s] ease-out rounded-full" style="width: {{ min(100, ($stats['highest_twk'] / 150) * 100) }}%"></div>
                            </div>
                        </div>

                        {{-- TIU Item --}}
                        <div class="group/item relative">
                            <div class="flex justify-between items-end mb-3">
                                <div>
                                    <span class="text-[10px] font-black text-slate-400 uppercase tracking-[0.2em] font-jakarta block mb-1">Tes Intelegensia Umum</span>
                                    <div class="flex items-center gap-2">
                                        <span class="text-2xl font-black {{ $stats['highest_tiu'] >= 80 ? 'text-emerald-600' : 'text-slate-900' }} font-jakarta tracking-tighter">{{ $stats['highest_tiu'] }}</span>
                                        <div class="px-2 py-0.5 rounded-md bg-slate-50 border border-slate-100">
                                            <span class="text-[9px] font-black text-slate-400 uppercase tracking-widest">Skor Terbaikmu</span>
                                        </div>
                                    </div>
                                </div>
                                <div class="text-right">
                                    <div class="flex items-center gap-1.5 justify-end">
                                        <span class="text-[10px] font-black text-slate-300 uppercase">Target:</span>
                                        <span class="text-xs font-black text-blue-600 font-jakarta">80</span>
                                    </div>
                                    <span class="text-[9px] font-bold text-slate-400">Max: 175</span>
                                </div>
                            </div>
                            <div class="h-3 w-full bg-slate-100 rounded-full overflow-hidden relative border border-slate-50 shadow-inner">
                                {{-- Target Line (80/175 = 45.7%) --}}
                                <div class="absolute left-[45.7%] top-0 w-0.5 h-full bg-slate-300 z-10"></div>
                                <div class="h-full {{ $stats['highest_tiu'] >= 80 ? 'bg-gradient-to-r from-emerald-400 to-emerald-600 shadow-[0_0_15px_rgba(16,185,129,0.4)]' : 'bg-gradient-to-r from-blue-400 to-blue-600 shadow-[0_0_15px_rgba(37,99,235,0.4)]' }} transition-all duration-[1.5s] ease-out rounded-full" style="width: {{ min(100, ($stats['highest_tiu'] / 175) * 100) }}%"></div>
                            </div>
                        </div>

                        {{-- TKP Item --}}
                        <div class="group/item relative">
                            <div class="flex justify-between items-end mb-3">
                                <div>
                                    <span class="text-[10px] font-black text-slate-400 uppercase tracking-[0.2em] font-jakarta block mb-1">Tes Karakteristik Pribadi</span>
                                    <div class="flex items-center gap-2">
                                        <span class="text-2xl font-black {{ $stats['highest_tkp'] >= 166 ? 'text-emerald-600' : 'text-slate-900' }} font-jakarta tracking-tighter">{{ $stats['highest_tkp'] }}</span>
                                        <div class="px-2 py-0.5 rounded-md bg-slate-50 border border-slate-100">
                                            <span class="text-[9px] font-black text-slate-400 uppercase tracking-widest">Skor Terbaikmu</span>
                                        </div>
                                    </div>
                                </div>
                                <div class="text-right">
                                    <div class="flex items-center gap-1.5 justify-end">
                                        <span class="text-[10px] font-black text-slate-300 uppercase">Target:</span>
                                        <span class="text-xs font-black text-blue-600 font-jakarta">166</span>
                                    </div>
                                    <span class="text-[9px] font-bold text-slate-400">Max: 225</span>
                                </div>
                            </div>
                            <div class="h-3 w-full bg-slate-100 rounded-full overflow-hidden relative border border-slate-50 shadow-inner">
                                {{-- Target Line (166/225 = 73.7%) --}}
                                <div class="absolute left-[73.7%] top-0 w-0.5 h-full bg-slate-300 z-10"></div>
                                <div class="h-full {{ $stats['highest_tkp'] >= 166 ? 'bg-gradient-to-r from-emerald-400 to-emerald-600 shadow-[0_0_15px_rgba(16,185,129,0.4)]' : 'bg-gradient-to-r from-blue-400 to-blue-600 shadow-[0_0_15px_rgba(37,99,235,0.4)]' }} transition-all duration-[1.5s] ease-out rounded-full" style="width: {{ min(100, ($stats['highest_tkp'] / 225) * 100) }}%"></div>
                            </div>
                        </div>
                        
                        <div class="pt-6 border-t border-slate-100/50 flex flex-col gap-4">
                            <div class="flex justify-between items-center">
                                <span class="text-[10px] font-black text-slate-400 uppercase tracking-widest font-jakarta">Kesimpulan Target</span>
                                @if($stats['highest_twk'] >= 65 && $stats['highest_tiu'] >= 80 && $stats['highest_tkp'] >= 166)
                                    <div class="flex items-center gap-1.5 px-3 py-1 bg-emerald-50 text-emerald-600 rounded-full border border-emerald-100 group-hover:scale-105 transition-transform duration-500">
                                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7" /></svg>
                                        <span class="text-[11px] font-black uppercase font-jakarta">SIAP TEMBUS!</span>
                                    </div>
                                @else
                                    <div class="flex items-center gap-1.5 px-3 py-1 bg-rose-50 text-rose-500 rounded-full border border-rose-100 group-hover:scale-105 transition-transform duration-500">
                                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
                                        <span class="text-[11px] font-black uppercase font-jakarta">BUTUH LATIHAN</span>
                                    </div>
                                @endif
                            </div>

                            @if(!($stats['highest_twk'] >= 65 && $stats['highest_tiu'] >= 80 && $stats['highest_tkp'] >= 166))
                                <p class="text-[10px] text-slate-400 font-medium leading-relaxed italic">
                                    "Teruslah berlatih, satu langkah lagi untuk mencapai ambang batas aman!"
                                </p>
                            @endif
                        </div>
                    </div>
                </div>
            </aside>
        </div>
    </div>

    {{-- Start Exam Confirmation Modal --}}
    <div x-show="showExamModal" 
         style="display: none;"
         class="fixed inset-0 z-[100] flex items-center justify-center p-4 bg-slate-900/60 backdrop-blur-sm"
         x-transition:enter="transition ease-out duration-300"
         x-transition:enter-start="opacity-0"
         x-transition:enter-end="opacity-100"
         x-transition:leave="transition ease-in duration-200"
         x-transition:leave-start="opacity-100"
         x-transition:leave-end="opacity-0">
        
        <div class="bg-white rounded-[2rem] p-8 max-w-md w-full relative shadow-2xl border border-white/50"
             @click.away="showExamModal = false"
             x-transition:enter="transition ease-out duration-300"
             x-transition:enter-start="opacity-0 scale-95 translate-y-4"
             x-transition:enter-end="opacity-100 scale-100 translate-y-0"
             x-transition:leave="transition ease-in duration-200"
             x-transition:leave-start="opacity-100 scale-100 translate-y-0"
             x-transition:leave-end="opacity-0 scale-95 translate-y-4">

            {{-- Close Button --}}
            <button @click="showExamModal = false" class="absolute top-4 right-4 text-slate-400 hover:text-slate-600 transition-colors">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" /></svg>
            </button>

            {{-- Icon --}}
            <div class="w-16 h-16 bg-blue-50 text-blue-600 rounded-2xl flex items-center justify-center mb-6 mx-auto shadow-lg shadow-blue-500/20">
                <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z" /></svg>
            </div>

            <div class="text-center mb-8">
                <h3 class="text-2xl font-bold text-slate-900 font-jakarta mb-2">Konfirmasi Ujian</h3>
                <p class="text-slate-500 font-medium text-sm">Anda akan memulai pengerjaan paket:</p>
                <div class="mt-2 px-4 py-2 bg-slate-50 rounded-xl inline-block border border-slate-100">
                    <span class="text-blue-700 font-bold text-sm font-jakarta" x-text="examName"></span>
                </div>
            </div>

            {{-- Rules / Info --}}
            <div class="space-y-3 mb-8 bg-slate-50/50 p-4 rounded-xl border border-slate-100 text-left">
                <div class="flex items-start gap-3">
                    <svg class="w-5 h-5 text-slate-400 mt-0.5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
                    <p class="text-xs text-slate-600 font-medium"><span class="font-bold text-slate-800">Waktu 100 Menit.</span> Timer berjalan otomatis saat tombol Mulai ditekan.</p>
                </div>
                <div class="flex items-start gap-3">
                    <svg class="w-5 h-5 text-rose-500 mt-0.5 shrink-0 animate-pulse" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" /></svg>
                    <p class="text-xs text-slate-600 font-medium"><span class="font-bold text-slate-800">Mode Keamanan Aktif.</span> Dilarang pindah tab/aplikasi atau layar akan terkunci.</p>
                </div>
                <div class="flex items-start gap-3">
                    <svg class="w-5 h-5 text-slate-400 mt-0.5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8.111 16.404a5.5 5.5 0 017.778 0M12 20h.01m-7.08-7.071c3.904-3.905 10.236-3.905 14.141 0M1.394 9.393c5.857-5.857 15.355-5.857 21.213 0" /></svg>
                    <p class="text-xs text-slate-600 font-medium">Pastikan koneksi internet Anda stabil.</p>
                </div>
            </div>

            <div class="grid grid-cols-2 gap-4">
                <button @click="showExamModal = false" class="px-6 py-3 bg-slate-100 text-slate-600 font-bold rounded-xl hover:bg-slate-200 transition-colors font-jakarta text-sm">
                    Batal
                </button>
                <button @click="window.location.href = examUrl" class="px-6 py-3 bg-blue-600 text-white font-bold rounded-xl hover:bg-blue-700 transition-colors font-jakarta text-sm shadow-lg shadow-blue-600/30">
                    Mulai Sekarang
                </button>
            </div>

        </div>
    </div>
</div>
