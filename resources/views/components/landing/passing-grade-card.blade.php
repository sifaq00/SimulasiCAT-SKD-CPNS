<div x-data="{ 
    show: false,
    resetting: false,
    twk: 0,
    tiu: 0,
    tkp: 0,
    total: 0,
    async startCycle() {
        this.show = true;
        while(true) {
            // Reset values
            this.resetting = true;
            this.twk = 0; this.tiu = 0; this.tkp = 0; this.total = 0;
            
            // Wait a tiny bit for the width resets to propagate without transition if possible
            // but simpler to just let them reset.
            await new Promise(r => setTimeout(r, 50));
            this.resetting = false;

            // Start count up
            await Promise.all([
                this.countTo('twk', 65, 2000),
                this.countTo('tiu', 80, 2000),
                this.countTo('tkp', 166, 2000),
                this.countTo('total', 311, 2000)
            ]);
            
            // Wait 3 seconds at the finish
            await new Promise(r => setTimeout(r, 3000));
        }
    },
    countTo(prop, target, duration) {
        return new Promise(resolve => {
            const start = Date.now();
            const timer = setInterval(() => {
                const time = Date.now() - start;
                const progress = Math.min(time / duration, 1);
                const ease = 1 - Math.pow(1 - progress, 3); // Ease out cubic
                this[prop] = Math.floor(ease * target);
                if (progress === 1) {
                    clearInterval(timer);
                    resolve();
                }
            }, 16);
        });
    }
}" x-init="setTimeout(() => startCycle(), 800)" class="glass-card rounded-3xl p-7 sm:p-9 max-w-lg ml-auto shadow-2xl transition-all duration-1000 transform" :class="show ? 'translate-y-0 opacity-100' : 'translate-y-8 opacity-0'">
    {{-- Card Header --}}
    <div class="flex items-center justify-between mb-8">
        <div>
            <h3 class="text-white text-xl sm:text-2xl font-bold">Passing Grade</h3>
            <p class="text-slate-400 text-sm">Skor minimal kelulusan wajib dicapai</p>
        </div>
        <div class="px-4 py-1.5 bg-blue-500/10 border border-blue-500/20 rounded-full h-fit">
            <span class="text-blue-400 text-xs font-bold uppercase tracking-wider">SKD 2026</span>
        </div>
    </div>

    {{-- Score Cards --}}
    <div class="space-y-6">
        {{-- TWK --}}
        <div class="row-item transition-all duration-700 delay-300" :class="show ? 'translate-x-0 opacity-100' : '-translate-x-4 opacity-0'">
            <div class="flex justify-between items-end mb-3">
                <div class="flex items-center gap-4">
                    <span class="w-10 h-10 bg-blue-500/20 rounded-xl flex items-center justify-center text-blue-400 font-bold text-sm shadow-sm">TWK</span>
                    <span class="text-slate-200 font-semibold text-sm sm:text-base">Wawasan Kebangsaan</span>
                </div>
                <span class="text-blue-400 font-bold text-lg"><span x-text="twk">0</span><span class="text-slate-500 text-sm font-normal">/150</span></span>
            </div>
            <div class="h-2.5 bg-slate-700/50 rounded-full overflow-hidden">
                <div class="h-full bg-gradient-to-r from-blue-600 to-blue-400 rounded-full shadow-[0_0_15px_rgba(59,130,246,0.6)] transition-all duration-700 ease-out" 
                     :style="'width: ' + (twk / 150 * 100) + '%'"></div>
            </div>
        </div>

        {{-- TIU --}}
        <div class="row-item transition-all duration-700 delay-500" :class="show ? 'translate-x-0 opacity-100' : '-translate-x-4 opacity-0'">
            <div class="flex justify-between items-end mb-3">
                <div class="flex items-center gap-4">
                    <span class="w-10 h-10 bg-purple-500/20 rounded-xl flex items-center justify-center text-purple-400 font-bold text-sm shadow-sm">TIU</span>
                    <span class="text-slate-200 font-semibold text-sm sm:text-base">Intelegensia Umum</span>
                </div>
                <span class="text-purple-400 font-bold text-lg"><span x-text="tiu">0</span><span class="text-slate-500 text-sm font-normal">/175</span></span>
            </div>
            <div class="h-2.5 bg-slate-700/50 rounded-full overflow-hidden">
                <div class="h-full bg-gradient-to-r from-purple-600 to-purple-400 rounded-full shadow-[0_0_15px_rgba(139,92,246,0.6)] transition-all duration-700 ease-out" 
                     :style="'width: ' + (tiu / 175 * 100) + '%'"></div>
            </div>
        </div>

        {{-- TKP --}}
        <div class="row-item transition-all duration-700 delay-700" :class="show ? 'translate-x-0 opacity-100' : '-translate-x-4 opacity-0'">
            <div class="flex justify-between items-end mb-3">
                <div class="flex items-center gap-4">
                    <span class="w-10 h-10 bg-cyan-500/20 rounded-xl flex items-center justify-center text-cyan-400 font-bold text-sm shadow-sm">TKP</span>
                    <span class="text-slate-200 font-semibold text-sm sm:text-base">Karakteristik Pribadi</span>
                </div>
                <span class="text-cyan-400 font-bold text-lg"><span x-text="tkp">0</span><span class="text-slate-500 text-sm font-normal">/225</span></span>
            </div>
            <div class="h-2.5 bg-slate-700/50 rounded-full overflow-hidden">
                <div class="h-full bg-gradient-to-r from-cyan-600 to-cyan-400 rounded-full shadow-[0_0_15px_rgba(6,182,212,0.6)] transition-all duration-700 ease-out" 
                     :style="'width: ' + (tkp / 225 * 100) + '%'"></div>
            </div>
        </div>
    </div>

    {{-- Total --}}
    <div class="mt-8 pt-6 border-t border-slate-700/50 flex justify-between items-center transition-all duration-1000 delay-1000" :class="show ? 'opacity-100' : 'opacity-0'">
        <div>
            <span class="text-slate-400 text-sm sm:text-base block">Total Target Skor</span>
            <span class="text-slate-500 text-xs uppercase font-bold tracking-widest">Minimal Lolos SKD</span>
        </div>
        <div class="text-right">
            <span class="text-4xl font-black text-white tracking-tighter shadow-blue-500/20" x-text="total">0</span>
            <span class="text-slate-500 text-xl font-medium">/550</span>
        </div>
    </div>
</div>
