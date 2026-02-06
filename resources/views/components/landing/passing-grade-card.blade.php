<div class="glass-card rounded-3xl p-7 sm:p-9 max-w-lg ml-auto shadow-2xl">
    {{-- Card Header --}}
    <div class="flex items-center justify-between mb-8">
        <div>
            <h3 class="text-white text-xl sm:text-2xl font-bold">Passing Grade</h3>
            <p class="text-slate-400 text-sm">Skor minimal kelulusan wajib dicapai</p>
        </div>
        <div class="px-4 py-1.5 bg-blue-500/10 border border-blue-500/20 rounded-full">
            <span class="text-blue-400 text-xs font-bold uppercase tracking-wider">SKD 2026</span>
        </div>
    </div>

    {{-- Score Cards --}}
    <div class="space-y-6">
        {{-- TWK --}}
        <div class="row-item">
            <div class="flex justify-between items-end mb-3">
                <div class="flex items-center gap-4">
                    <span class="w-10 h-10 bg-blue-500/20 rounded-xl flex items-center justify-center text-blue-400 font-bold text-sm shadow-sm">TWK</span>
                    <span class="text-slate-200 font-semibold text-sm sm:text-base">Wawasan Kebangsaan</span>
                </div>
                <span class="text-blue-400 font-bold text-lg">65<span class="text-slate-500 text-sm font-normal">/150</span></span>
            </div>
            <div class="h-2.5 bg-slate-700/50 rounded-full overflow-hidden">
                <div class="h-full bg-gradient-to-r from-blue-600 to-blue-400 rounded-full transition-all duration-1000 shadow-[0_0_15px_rgba(59,130,246,0.6)]" style="width: 43%"></div>
            </div>
        </div>

        {{-- TIU --}}
        <div class="row-item">
            <div class="flex justify-between items-end mb-3">
                <div class="flex items-center gap-4">
                    <span class="w-10 h-10 bg-purple-500/20 rounded-xl flex items-center justify-center text-purple-400 font-bold text-sm shadow-sm">TIU</span>
                    <span class="text-slate-200 font-semibold text-sm sm:text-base">Intelegensia Umum</span>
                </div>
                <span class="text-purple-400 font-bold text-lg">80<span class="text-slate-500 text-sm font-normal">/175</span></span>
            </div>
            <div class="h-2.5 bg-slate-700/50 rounded-full overflow-hidden">
                <div class="h-full bg-gradient-to-r from-purple-600 to-purple-400 rounded-full transition-all duration-1000 shadow-[0_0_15px_rgba(139,92,246,0.6)]" style="width: 46%"></div>
            </div>
        </div>

        {{-- TKP --}}
        <div class="row-item">
            <div class="flex justify-between items-end mb-3">
                <div class="flex items-center gap-4">
                    <span class="w-10 h-10 bg-cyan-500/20 rounded-xl flex items-center justify-center text-cyan-400 font-bold text-sm shadow-sm">TKP</span>
                    <span class="text-slate-200 font-semibold text-sm sm:text-base">Karakteristik Pribadi</span>
                </div>
                <span class="text-cyan-400 font-bold text-lg">166<span class="text-slate-500 text-sm font-normal">/225</span></span>
            </div>
            <div class="h-2.5 bg-slate-700/50 rounded-full overflow-hidden">
                <div class="h-full bg-gradient-to-r from-cyan-600 to-cyan-400 rounded-full transition-all duration-1000 shadow-[0_0_15px_rgba(6,182,212,0.6)]" style="width: 74%"></div>
            </div>
        </div>
    </div>

    {{-- Total --}}
    <div class="mt-8 pt-6 border-t border-slate-700/50 flex justify-between items-center">
        <div>
            <span class="text-slate-400 text-sm sm:text-base block">Total Target Skor</span>
            <span class="text-slate-500 text-xs uppercase font-bold tracking-widest">Minimal Lolos SKD</span>
        </div>
        <div class="text-right">
            <span class="text-4xl font-black text-white tracking-tighter shadow-blue-500/20">311</span>
            <span class="text-slate-500 text-xl font-medium">/550</span>
        </div>
    </div>
</div>
