<div class="py-12 pt-28 min-h-screen bg-slate-50/50 relative overflow-hidden">
    {{-- Subtle Background Accents --}}
    <div class="fixed top-0 left-0 w-full h-full pointer-events-none">
        <div class="absolute top-[-10%] left-[-10%] w-[50%] h-[50%] bg-blue-500/5 blur-[120px] rounded-full"></div>
        <div class="absolute bottom-[-10%] right-[-10%] w-[50%] h-[50%] bg-indigo-500/5 blur-[120px] rounded-full"></div>
    </div>

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10">
        {{-- Welcome Section --}}
        <div class="flex flex-col md:flex-row md:items-center justify-between gap-6 mb-12">
            <div>
                <h1 class="text-3xl md:text-4xl font-extrabold text-slate-900 font-outfit tracking-tight mb-2">
                    Halo, <span class="bg-gradient-to-r from-blue-600 to-indigo-600 bg-clip-text text-transparent">{{ auth()->user()->name }}</span>! 👋
                </h1>
                <p class="text-slate-500 font-medium">Siap tembus CPNS tahun ini? Yuk, lanjut latihan lagi.</p>
            </div>
            

        </div>

        {{-- Stats Grid --}}
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-5 gap-4 mb-10">
            {{-- Card 1: Ujian Selesai (Blue - Default) --}}
            <div class="bg-white rounded-2xl p-4 border border-slate-100 shadow-sm group hover:shadow-lg hover:shadow-blue-500/5 transition-all duration-500 flex items-center gap-4">
                <div class="w-12 h-12 shrink-0 bg-blue-50 text-blue-600 rounded-xl flex items-center justify-center group-hover:bg-blue-600 group-hover:text-white transition-all duration-500 border border-blue-100">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4" /></svg>
                </div>
                <div>
                    <p class="text-[10px] font-black text-slate-400 uppercase tracking-widest mb-0.5">Ujian Selesai</p>
                    <p class="text-2xl font-extrabold text-slate-900 group-hover:text-blue-600 transition-colors font-outfit tracking-tight leading-none">{{ $stats['total_tests'] }}</p>
                </div>
            </div>
            
            {{-- Card 2: Rata-rata Skor (Violet - Wisdom) --}}
            <div class="bg-white rounded-2xl p-4 border border-slate-100 shadow-sm group hover:shadow-lg hover:shadow-violet-500/5 transition-all duration-500 flex items-center gap-4">
                <div class="w-12 h-12 shrink-0 bg-violet-50 text-violet-600 rounded-xl flex items-center justify-center group-hover:bg-violet-600 group-hover:text-white transition-all duration-500 border border-violet-100">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6" /></svg>
                </div>
                <div>
                    <p class="text-[10px] font-black text-slate-400 uppercase tracking-widest mb-0.5">Rata-rata Skor</p>
                    <p class="text-2xl font-extrabold text-slate-900 group-hover:text-violet-600 transition-colors font-outfit tracking-tight leading-none">{{ $stats['average_score'] }}</p>
                </div>
            </div>

            {{-- Card 3: Skor Tertinggi (Amber - Trophy) --}}
            <div class="bg-white rounded-2xl p-4 border border-slate-100 shadow-sm group hover:shadow-lg hover:shadow-amber-500/5 transition-all duration-500 flex items-center gap-4">
                <div class="w-12 h-12 shrink-0 bg-amber-50 text-amber-600 rounded-xl flex items-center justify-center group-hover:bg-amber-600 group-hover:text-white transition-all duration-500 border border-amber-100">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 3v4M3 5h4M6 17v4m-2-2h4m5-16l2.286 6.857L21 12l-5.714 2.143L13 21l-2.286-6.857L5 12l5.714-2.143L13 3z" /></svg>
                </div>
                <div>
                    <p class="text-[10px] font-black text-slate-400 uppercase tracking-widest mb-0.5">Skor Tertinggi</p>
                    <p class="text-2xl font-extrabold text-slate-900 group-hover:text-amber-600 transition-colors font-outfit tracking-tight leading-none">{{ $stats['highest_score'] }}</p>
                </div>
            </div>

            {{-- Card 4: Lulus (Emerald - Success) --}}
            <div class="bg-white rounded-2xl p-4 border border-slate-100 shadow-sm group hover:shadow-lg hover:shadow-emerald-500/5 transition-all duration-500 flex items-center gap-4">
                <div class="w-12 h-12 shrink-0 bg-emerald-50 text-emerald-600 rounded-xl flex items-center justify-center group-hover:bg-emerald-600 group-hover:text-white transition-all duration-500 border border-emerald-100">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" /></svg>
                </div>
                <div>
                    <p class="text-[10px] font-black text-slate-400 uppercase tracking-widest mb-0.5">Lulus</p>
                    <p class="text-2xl font-extrabold text-slate-900 group-hover:text-emerald-600 transition-colors font-outfit tracking-tight leading-none">{{ $stats['passed_count'] }}</p>
                </div>
            </div>

            {{-- Card 5: Pengeluaran (Rose - Contrast) --}}
            <div class="bg-white rounded-2xl p-4 border border-slate-100 shadow-sm group hover:shadow-lg hover:shadow-rose-500/5 transition-all duration-500 flex items-center gap-4">
                <div class="w-12 h-12 shrink-0 bg-rose-50 text-rose-600 rounded-xl flex items-center justify-center group-hover:bg-rose-600 group-hover:text-white transition-all duration-500 border border-rose-100">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 9V7a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2m2 4h10a2 2 0 002-2v-6a2 2 0 00-2-2H9a2 2 0 00-2 2v6a2 2 0 002 2zm7-5a2 2 0 11-4 0 2 2 0 014 0z" /></svg>
                </div>
                <div>
                    <p class="text-[10px] font-black text-slate-400 uppercase tracking-widest mb-0.5">Total Investasi</p>
                    <p class="text-xl font-extrabold text-slate-900 group-hover:text-rose-600 transition-colors font-outfit tracking-tight leading-none">Rp {{ number_format($stats['total_spent'], 0, ',', '.') }}</p>
                </div>
            </div>
        </div>

        <div class="grid lg:grid-cols-3 gap-8 items-start">
            {{-- Main Content --}}
            <div class="lg:col-span-2 space-y-12">
                {{-- Ready to Test Section --}}
                <section>
                    <div class="flex items-center justify-between mb-8">
                        <h2 class="text-2xl font-bold text-slate-900 font-outfit tracking-tight">Paket Saya</h2>
                        <a href="{{ route('packages') }}" class="text-sm font-bold text-blue-600 hover:text-blue-700 transition-colors flex items-center gap-1 group">
                            Cek Paket Lain <svg class="w-4 h-4 group-hover:translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" /></svg>
                        </a>
                    </div>
                    
                    <div class="space-y-4">
                        @forelse($purchasedPackages as $package)
                            <div class="group relative bg-white rounded-2xl border border-slate-100 p-5 shadow-sm hover:shadow-lg hover:shadow-blue-500/5 transition-all duration-500">
                                <div class="relative z-10 flex flex-col sm:flex-row sm:items-center justify-between gap-4">
                                    <div class="flex-1">
                                        <div class="flex items-center gap-3 mb-2">
                                            <span class="px-2.5 py-1 bg-slate-50 text-slate-500 rounded-lg text-[10px] font-black tracking-widest uppercase border border-slate-100">
                                                {{ $package['package_year'] }}
                                            </span>
                                            @if($package['status'] === 'in_progress')
                                                <span class="text-[10px] font-black text-amber-600 uppercase tracking-widest">Berjalan</span>
                                            @endif
                                        </div>
                                        
                                        <h3 class="text-lg font-bold text-slate-900 font-outfit mb-1 tracking-tight group-hover:text-blue-600 transition-colors">{{ $package['package_name'] }}</h3>
                                        <p class="text-slate-400 text-xs font-medium">
                                            @if($package['is_bundle'])
                                                <span class="text-blue-600">[{{ $package['bundle_name'] }}]</span> •
                                            @endif
                                            {{ $package['purchased_at'] }}
                                        </p>
                                    </div>
                                    
                                    <div class="shrink-0">
                                        <a href="{{ route('test.simulation', ['packageSlug' => $package['package_slug'], 'transactionId' => $package['transaction_id']]) }}" 
                                           class="inline-flex items-center justify-center w-full sm:w-auto px-6 py-3 rounded-xl shadow-lg hover:shadow-xl font-bold transition-all duration-300 font-outfit text-sm {{ $package['status'] === 'in_progress' ? 'bg-amber-500 text-white hover:bg-amber-600 shadow-amber-500/20 hover:shadow-amber-500/30' : 'bg-blue-600 text-white hover:bg-blue-700 shadow-blue-600/20 hover:shadow-blue-600/30' }}">
                                            {{ $package['status'] === 'in_progress' ? 'Lanjut' : 'Mulai' }}
                                        </a>
                                    </div>
                                </div>
                            </div>
                        @empty
                            <div class="bg-white rounded-2xl border border-dashed border-slate-200 p-8 text-center shadow-sm">
                                <h3 class="text-base font-bold text-slate-900 mb-1 font-outfit">Belum ada paket aktif</h3>
                                <p class="text-slate-500 text-sm mb-6 max-w-xs mx-auto">Miliki paket latihan pertamamu untuk memulai persiapan.</p>
                                <a href="{{ route('packages') }}" class="inline-flex items-center gap-2 px-6 py-2.5 bg-blue-600 text-white rounded-xl text-sm font-bold hover:bg-blue-700 transition-all font-outfit shadow-lg shadow-blue-600/20">
                                    Beli Paket
                                </a>
                            </div>
                        @endforelse
                    </div>
                </section>

                {{-- Recent History Section --}}
                <section>
                    <div class="flex items-center justify-between mb-8">
                        <h2 class="text-2xl font-bold text-slate-900 font-outfit tracking-tight">Riwayat Ujian</h2>
                        @if(count($recentAttempts) > 0)
                            <a href="{{ route('test.history') }}" class="inline-flex items-center gap-2 px-4 py-2 bg-blue-50 text-blue-600 hover:bg-blue-100 hover:text-blue-700 rounded-xl text-xs font-bold transition-all font-outfit">
                                Lihat Semua
                                <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" /></svg>
                            </a>
                        @endif
                    </div>

                    
                    <div class="bg-white rounded-2xl border border-slate-100 shadow-sm overflow-hidden">
                        <div class="overflow-x-auto">
                            <table class="w-full">
                                <thead>
                                    <tr class="bg-slate-50/50">
                                        <th class="px-6 py-4 text-left text-[10px] font-black text-slate-400 uppercase tracking-widest">Daftar Ujian</th>
                                        <th class="px-6 py-4 text-left text-[10px] font-black text-slate-400 uppercase tracking-widest">Tanggal</th>
                                        <th class="px-6 py-4 text-left text-[10px] font-black text-slate-400 uppercase tracking-widest">Skor</th>
                                        <th class="px-6 py-4 text-left text-[10px] font-black text-slate-400 uppercase tracking-widest">Hasil</th>
                                        <th class="px-6 py-4 text-right text-[10px] font-black text-slate-400 uppercase tracking-widest">Detail</th>
                                    </tr>
                                </thead>
                                <tbody class="divide-y divide-slate-100">
                                    @forelse($recentAttempts as $attempt)
                                        <tr class="hover:bg-slate-50 transition-colors group">
                                            <td class="px-6 py-4">
                                                <div class="font-bold text-slate-900 font-outfit text-sm">{{ $attempt['package_name'] }}</div>
                                            </td>
                                            <td class="px-6 py-4">
                                                <div class="text-xs font-medium text-slate-500 font-outfit">{{ $attempt['date'] }}</div>
                                            </td>
                                            <td class="px-6 py-4">
                                                <div class="flex flex-col gap-1">
                                                    <div class="text-lg font-extrabold text-slate-900 font-outfit leading-none">{{ $attempt['total_score'] }}</div>
                                                    <div class="flex items-center gap-2 text-[10px] font-bold text-slate-500 uppercase tracking-widest">
                                                        <span title="TWK"><span class="text-slate-400">TWK:</span> <span class="{{ $attempt['score_twk'] >= 65 ? 'text-emerald-600' : 'text-rose-500' }}">{{ $attempt['score_twk'] }}</span></span>
                                                        <span class="text-slate-200">|</span>
                                                        <span title="TIU"><span class="text-slate-400">TIU:</span> <span class="{{ $attempt['score_tiu'] >= 80 ? 'text-emerald-600' : 'text-rose-500' }}">{{ $attempt['score_tiu'] }}</span></span>
                                                        <span class="text-slate-200">|</span>
                                                        <span title="TKP"><span class="text-slate-400">TKP:</span> <span class="{{ $attempt['score_tkp'] >= 166 ? 'text-emerald-600' : 'text-rose-500' }}">{{ $attempt['score_tkp'] }}</span></span>
                                                    </div>
                                                </div>
                                            </td>
                                            <td class="px-6 py-4">
                                                @if($attempt['passed'])
                                                    <span class="inline-flex items-center gap-1.5 px-2.5 py-0.5 bg-emerald-50 text-emerald-600 rounded-md text-[10px] font-black uppercase tracking-widest border border-emerald-100">
                                                        LULUS
                                                    </span>
                                                @else
                                                    <span class="inline-flex items-center gap-1.5 px-2.5 py-0.5 bg-rose-50 text-rose-600 rounded-md text-[10px] font-black uppercase tracking-widest border border-rose-100">
                                                        GAGAL
                                                    </span>
                                                @endif
                                            </td>
                                            <td class="px-6 py-4 text-right">
                                                @if($attempt['status'] === 'completed' || $attempt['status'] === 'timeout')
                                                    <a href="{{ route('test.result', $attempt['id']) }}" class="p-1.5 text-slate-400 hover:text-blue-600 transition-colors inline-block" wire:navigate>
                                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3" /></svg>
                                                    </a>
                                                @endif
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="5" class="px-6 py-12 text-center">
                                                <p class="text-slate-500 text-sm font-medium">Belum ada riwayat ujian.</p>
                                            </td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>
                </section>
            </div>

            {{-- Sidebar --}}
            <aside class="space-y-8">
                {{-- Quick Actions --}}
                <div class="bg-gradient-to-br from-blue-600 to-indigo-700 rounded-2xl p-6 shadow-xl shadow-blue-900/10 group relative overflow-hidden">
                    <h3 class="text-lg font-bold text-white font-outfit mb-4 tracking-tight relative z-10">Menu Cepat</h3>
                    <div class="space-y-3 relative z-10">
                        <a href="{{ route('packages') }}" class="flex items-center gap-3 p-3 bg-white/10 hover:bg-white/20 rounded-xl transition-all group/item shadow-lg border border-white/10">
                            <div class="w-8 h-8 bg-white/20 rounded-lg flex items-center justify-center text-white group-hover/item:scale-110 transition-transform">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6" /></svg>
                            </div>
                            <div class="text-left">
                                <p class="text-sm font-bold text-white font-outfit">Tambah Paket</p>
                                <p class="text-[10px] text-white/60 font-medium">Beli simulasi terbaru</p>
                            </div>
                        </a>
                        <a href="{{ route('profile') }}" class="flex items-center gap-3 p-3 bg-white/10 hover:bg-white/20 rounded-xl transition-all group/item shadow-lg border border-white/10">
                            <div class="w-8 h-8 bg-white/20 rounded-lg flex items-center justify-center text-white group-hover/item:scale-110 transition-transform">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" /></svg>
                            </div>
                            <div class="text-left">
                                <p class="text-sm font-bold text-white font-outfit">Edit Profil</p>
                                <p class="text-[10px] text-white/60 font-medium">Kelola data akun Anda</p>
                            </div>
                        </a>
                    </div>
                </div>

                {{-- Passing Grade Info --}}
                <div class="bg-white rounded-2xl border border-slate-100 p-6 shadow-sm overflow-hidden relative group">
                    <div class="flex items-center justify-between mb-6">
                        <h3 class="text-base font-bold text-slate-900 font-outfit tracking-tight">Passing Grade</h3>
                        <div class="group relative cursor-help">
                            <svg class="w-4 h-4 text-slate-300 hover:text-blue-500 transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
                            <div class="absolute right-0 bottom-full mb-2 w-48 p-3 bg-slate-900 text-white text-[10px] rounded-xl opacity-0 group-hover:opacity-100 transition-opacity pointer-events-none z-20 shadow-xl">
                                Nilai ambang batas SKD CPNS 2024
                            </div>
                        </div>
                    </div>

                    <div class="space-y-5">
                        <div class="group/item">
                            <div class="flex justify-between items-end mb-2">
                                <span class="text-[10px] font-bold text-slate-400 uppercase tracking-widest">TWK</span>
                                <div class="flex items-baseline gap-1">
                                    <span class="text-sm font-extrabold text-blue-600 font-outfit">65</span>
                                    <span class="text-[10px] font-bold text-slate-300">/ 150</span>
                                </div>
                            </div>
                            <div class="h-2 w-full bg-slate-100 rounded-full overflow-hidden relative">
                                {{-- Background threshold marker (43.3%) --}}
                                <div class="absolute top-0 bottom-0 w-0.5 bg-slate-300 z-10" style="left: 43.33%"></div>
                                <div class="h-full bg-blue-600 shadow-[0_0_10px_rgba(37,99,235,0.3)] transition-all duration-1000" style="width: 43.33%"></div>
                            </div>
                        </div>

                        <div class="group/item">
                            <div class="flex justify-between items-end mb-2">
                                <span class="text-[10px] font-bold text-slate-400 uppercase tracking-widest">TIU</span>
                                <div class="flex items-baseline gap-1">
                                    <span class="text-sm font-extrabold text-blue-600 font-outfit">80</span>
                                    <span class="text-[10px] font-bold text-slate-300">/ 175</span>
                                </div>
                            </div>
                            <div class="h-2 w-full bg-slate-100 rounded-full overflow-hidden relative">
                                {{-- Background threshold marker (45.7%) --}}
                                <div class="absolute top-0 bottom-0 w-0.5 bg-slate-300 z-10" style="left: 45.71%"></div>
                                <div class="h-full bg-blue-600 shadow-[0_0_10px_rgba(37,99,235,0.3)] transition-all duration-1000" style="width: 45.71%"></div>
                            </div>
                        </div>

                        <div class="group/item">
                            <div class="flex justify-between items-end mb-2">
                                <span class="text-[10px] font-bold text-slate-400 uppercase tracking-widest">TKP</span>
                                <div class="flex items-baseline gap-1">
                                    <span class="text-sm font-extrabold text-blue-600 font-outfit">166</span>
                                    <span class="text-[10px] font-bold text-slate-300">/ 225</span>
                                </div>
                            </div>
                            <div class="h-2 w-full bg-slate-100 rounded-full overflow-hidden relative">
                                {{-- Background threshold marker (73.7%) --}}
                                <div class="absolute top-0 bottom-0 w-0.5 bg-slate-300 z-10" style="left: 73.77%"></div>
                                <div class="h-full bg-blue-600 shadow-[0_0_10px_rgba(37,99,235,0.3)] transition-all duration-1000" style="width: 73.77%"></div>
                            </div>
                        </div>
                        
                        <div class="pt-4 border-t border-slate-50 flex justify-between items-center">
                            <span class="text-[10px] font-bold text-slate-500 uppercase tracking-widest">TOTAL TARGET</span>
                            <div class="flex items-baseline gap-1">
                                <span class="text-sm font-extrabold text-slate-900 font-outfit">311</span>
                                <span class="text-[10px] font-bold text-slate-400">/ 550</span>
                            </div>
                        </div>
                    </div>
                </div>
            </aside>
        </div>
    </div>
</div>
