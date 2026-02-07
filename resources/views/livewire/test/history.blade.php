<div class="min-h-screen bg-slate-50 py-12 pt-20 md:pt-28 relative overflow-hidden">
    {{-- Subtle Background Accents --}}
    <div class="fixed top-0 left-0 w-full h-full pointer-events-none">
        <div class="absolute top-[-10%] left-[-10%] w-[50%] h-[50%] bg-blue-500/5 blur-[120px] rounded-full"></div>
        <div class="absolute bottom-[-10%] right-[-10%] w-[50%] h-[50%] bg-indigo-500/5 blur-[120px] rounded-full"></div>
    </div>
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        {{-- Header --}}
        <div class="mb-10">
            <h1 class="text-3xl font-black text-slate-900 font-outfit tracking-tight mb-2">Riwayat Ujian</h1>
            <p class="text-slate-500 font-medium">Arsip lengkap hasil simulasi dan latihan Anda.</p>
        </div>

        {{-- Content --}}
        <div class="bg-white rounded-[2rem] border border-slate-100 shadow-xl shadow-slate-200/50 overflow-hidden">
            {{-- Mobile Card View --}}
            <div class="md:hidden space-y-4">
                @forelse($attempts as $attempt)
                    <div class="bg-white rounded-2xl p-5 border border-slate-100 shadow-sm relative overflow-hidden group">
                        <div class="flex justify-between items-start mb-4">
                            <div>
                                <h3 class="font-bold text-slate-900 font-outfit text-base leading-tight mb-1">{{ $attempt->package->name }}</h3>
                                <p class="text-xs text-slate-500 font-medium">{{ $attempt->package->year }} • {{ $attempt->created_at->format('d M Y, H:i') }}</p>
                            </div>
                            @if($attempt->passed_overall)
                                <span class="shrink-0 inline-flex items-center justify-center w-8 h-8 rounded-full bg-emerald-100 text-emerald-600">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" /></svg>
                                </span>
                            @else
                                <span class="shrink-0 inline-flex items-center justify-center w-8 h-8 rounded-full bg-rose-100 text-rose-500">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" /></svg>
                                </span>
                            @endif
                        </div>
                        
                        <div class="flex items-center gap-4 mb-4 py-3 border-y border-slate-50">
                            <div class="flex-1">
                                <span class="block text-[10px] uppercase font-bold text-slate-400 tracking-widest mb-0.5">Skor Total</span>
                                <span class="text-xl font-black text-slate-900 font-outfit">{{ $attempt->total_score }}</span>
                            </div>
                            <div class="flex gap-2">
                                <div class="text-center px-2">
                                    <span class="block text-[8px] font-bold text-slate-400 mb-0.5">TWK</span>
                                    <span class="text-xs font-bold {{ $attempt->score_twk >= 65 ? 'text-emerald-600' : 'text-rose-500' }}">{{ $attempt->score_twk }}</span>
                                </div>
                                <div class="text-center px-2 border-l border-slate-100">
                                    <span class="block text-[8px] font-bold text-slate-400 mb-0.5">TIU</span>
                                    <span class="text-xs font-bold {{ $attempt->score_tiu >= 80 ? 'text-emerald-600' : 'text-rose-500' }}">{{ $attempt->score_tiu }}</span>
                                </div>
                                <div class="text-center px-2 border-l border-slate-100">
                                    <span class="block text-[8px] font-bold text-slate-400 mb-0.5">TKP</span>
                                    <span class="text-xs font-bold {{ $attempt->score_tkp >= 166 ? 'text-emerald-600' : 'text-rose-500' }}">{{ $attempt->score_tkp }}</span>
                                </div>
                            </div>
                        </div>

                        <a href="{{ route('test.result', $attempt->id) }}" class="block w-full py-2.5 text-center bg-slate-50 hover:bg-blue-50 text-slate-600 hover:text-blue-600 rounded-xl text-sm font-bold transition-colors border border-slate-100">
                            Lihat Detail Hasil
                        </a>
                    </div>
                @empty
                    <div class="text-center py-12 bg-white rounded-3xl border border-slate-100 border-dashed">
                        <div class="w-12 h-12 bg-slate-50 rounded-xl flex items-center justify-center mx-auto mb-3 text-slate-300">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
                        </div>
                        <p class="text-slate-500 text-sm font-medium">Belum ada riwayat ujian.</p>
                    </div>
                @endforelse
            </div>

            {{-- Desktop Table View --}}
            <div class="hidden md:block overflow-x-auto">
                <table class="w-full">
                    <thead class="bg-slate-50 border-b border-slate-100">
                        <tr>
                            <th class="px-6 py-5 text-left text-xs font-bold text-slate-400 uppercase tracking-wider font-outfit">Paket Ujian</th>
                            <th class="px-6 py-5 text-left text-xs font-bold text-slate-400 uppercase tracking-wider font-outfit">Tanggal</th>
                            <th class="px-6 py-5 text-center text-xs font-bold text-slate-400 uppercase tracking-wider font-outfit">Skor Total</th>
                            <th class="px-6 py-5 text-left text-xs font-bold text-slate-400 uppercase tracking-wider font-outfit">Rincian Skor</th>
                            <th class="px-6 py-5 text-center text-xs font-bold text-slate-400 uppercase tracking-wider font-outfit">Status</th>
                            <th class="px-6 py-5 text-right text-xs font-bold text-slate-400 uppercase tracking-wider font-outfit">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100">
                        @forelse($attempts as $attempt)
                            <tr class="group hover:bg-slate-50/50 transition-colors">
                                <td class="px-6 py-5">
                                    <div>
                                        <div class="font-bold text-slate-900 font-outfit text-base group-hover:text-blue-600 transition-colors">
                                            {{ $attempt->package->name }}
                                        </div>
                                        <div class="text-xs text-slate-400 font-medium mt-1">
                                            {{ $attempt->package->year }}
                                        </div>
                                    </div>
                                </td>
                                <td class="px-6 py-5">
                                    <div class="text-sm font-bold text-slate-600 font-outfit">
                                        {{ $attempt->created_at->format('d M Y') }}
                                    </div>
                                    <div class="text-xs text-slate-400 font-medium mt-0.5">
                                        {{ $attempt->created_at->format('H:i') }} WIB
                                    </div>
                                </td>
                                <td class="px-6 py-5 text-center">
                                    <span class="inline-flex items-center justify-center px-4 py-2 rounded-xl bg-slate-100 text-slate-900 font-black font-outfit text-lg border border-slate-200">
                                        {{ $attempt->total_score }}
                                    </span>
                                </td>
                                <td class="px-6 py-5">
                                    <div class="flex flex-col gap-1.5">
                                        <div class="flex items-center justify-between text-xs font-bold bg-slate-50 px-3 py-1.5 rounded-lg border border-slate-100">
                                            <span class="text-slate-500">TWK</span>
                                            <span class="{{ $attempt->score_twk >= 65 ? 'text-emerald-600' : 'text-rose-500' }}">
                                                {{ $attempt->score_twk }}
                                            </span>
                                        </div>
                                        <div class="flex items-center justify-between text-xs font-bold bg-slate-50 px-3 py-1.5 rounded-lg border border-slate-100">
                                            <span class="text-slate-500">TIU</span>
                                            <span class="{{ $attempt->score_tiu >= 80 ? 'text-emerald-600' : 'text-rose-500' }}">
                                                {{ $attempt->score_tiu }}
                                            </span>
                                        </div>
                                        <div class="flex items-center justify-between text-xs font-bold bg-slate-50 px-3 py-1.5 rounded-lg border border-slate-100">
                                            <span class="text-slate-500">TKP</span>
                                            <span class="{{ $attempt->score_tkp >= 166 ? 'text-emerald-600' : 'text-rose-500' }}">
                                                {{ $attempt->score_tkp }}
                                            </span>
                                        </div>
                                    </div>
                                </td>
                                <td class="px-6 py-5 text-center">
                                    @if($attempt->passed_overall)
                                        <span class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-lg bg-emerald-50 text-emerald-600 border border-emerald-100 text-xs font-bold uppercase tracking-wider">
                                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
                                            Lulus
                                        </span>
                                    @else
                                        <span class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-lg bg-rose-50 text-rose-500 border border-rose-100 text-xs font-bold uppercase tracking-wider">
                                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" /></svg>
                                            Tidak Lulus
                                        </span>
                                    @endif
                                </td>
                                <td class="px-6 py-5 text-right">
                                    <a href="{{ route('test.result', $attempt->id) }}" class="inline-flex items-center gap-2 px-4 py-2 bg-white text-slate-600 hover:text-blue-600 hover:bg-blue-50 border border-slate-200 hover:border-blue-100 rounded-xl transition-all duration-300 font-bold text-sm shadow-sm group-hover:shadow-md">
                                        Detail
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" /></svg>
                                    </a>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="px-6 py-20 text-center">
                                    <div class="flex flex-col items-center justify-center">
                                        <div class="w-16 h-16 bg-slate-50 rounded-2xl flex items-center justify-center mb-4 text-slate-300">
                                            <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4" /></svg>
                                        </div>
                                        <h3 class="text-lg font-bold text-slate-900 font-outfit mb-1">Belum Ada Riwayat</h3>
                                        <p class="text-slate-500">Anda belum menyelesaikan ujian apapun.</p>
                                    </div>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            
            @if($attempts->hasPages())
                <div class="px-6 py-6 border-t border-slate-100 bg-slate-50">
                    {{ $attempts->links() }}
                </div>
            @endif
        </div>
    </div>
</div>
