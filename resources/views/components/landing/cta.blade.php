<section class="py-24 lg:py-32 relative overflow-hidden bg-slate-950">
    {{-- Immersive Background Elements --}}
    <div class="absolute inset-0 z-0">
        <div class="absolute top-0 left-1/4 w-[500px] h-[500px] bg-blue-600/10 blur-[120px] rounded-full"></div>
        <div class="absolute bottom-0 right-1/4 w-[500px] h-[500px] bg-purple-600/10 blur-[120px] rounded-full"></div>
    </div>

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10">
        <div class="relative rounded-[3rem] overflow-hidden">
            {{-- Main Glass Container --}}
            <div class="relative bg-white/[0.03] backdrop-blur-3xl border border-white/10 px-8 py-16 md:py-24 text-center">
                {{-- Decorative SVG Pattern --}}
                <div class="absolute inset-0 opacity-[0.03] pointer-events-none" style="background-image: url('data:image/svg+xml,%3Csvg width=\"60\" height=\"60\" viewBox=\"0 0 60 60\" xmlns=\"http://www.w3.org/2000/svg\"%3E%3Cpath d=\"M54.627 0l.83.83L1.457 55.457l-.83-.83L54.627 0zM59.173 0l.83.83L1.457 60l-.83-.83L59.173 0zM0 0l60 60v-1.414L1.414 0H0z\" fill=\"%23ffffff\" fill-opacity=\"1\" fill-rule=\"evenodd\"/%3E%3C/svg%3E');"></div>

                <div class="relative z-10 max-w-3xl mx-auto">
                    {{-- Premium Icon Badge --}}
                    <div class="inline-flex items-center justify-center w-16 h-16 rounded-2xl bg-gradient-to-br from-blue-500 to-purple-600 shadow-2xl shadow-blue-500/20 mb-8 mx-auto group">
                        <svg class="w-8 h-8 text-white group-hover:scale-110 transition-transform duration-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path>
                        </svg>
                    </div>

                    <h2 class="text-4xl md:text-6xl font-black text-white mb-8 tracking-tighter leading-[1.1] uppercase">
                        Siap Menembus <span class="gradient-text">Impian Jadi ASN?</span>
                    </h2>
                    
                    <p class="text-xl text-slate-400 font-medium mb-12 leading-relaxed">
                        Bergabunglah dengan <span class="text-white font-bold">10.000+</span> pejuang CPNS lainnya. <br class="hidden md:block"> Mulai persiapanmu sekarang dengan simulasi CAT terbaik.
                    </p>

                    <div class="flex flex-col sm:flex-row items-center justify-center gap-6">
                        <a href="{{ route('register') }}" class="group relative px-10 py-5 bg-gradient-to-r from-blue-600 to-purple-600 text-white rounded-2xl font-black text-lg shadow-[0_20px_40px_rgba(37,99,235,0.3)] hover:shadow-[0_25px_50px_rgba(37,99,235,0.4)] transition-all hover:-translate-y-1 overflow-hidden">
                            <div class="absolute inset-0 bg-white/20 group-hover:translate-x-full transition-transform duration-700 -translate-x-full skew-x-12"></div>
                            <span class="relative flex items-center gap-3">
                                Daftar Gratis Sekarang
                                <svg class="w-6 h-6 group-hover:translate-x-2 transition-transform duration-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M17 8l4 4m0 0l-4 4m4-4H3"></path>
                                </svg>
                            </span>
                        </a>
                        
                        <div class="flex items-center gap-4 text-slate-500 font-bold text-sm uppercase tracking-widest">
                            <span class="flex h-2 w-2 rounded-full bg-emerald-500 animate-pulse"></span>
                            Akses Langsung
                        </div>
                    </div>
                </div>

                {{-- Corner Accents --}}
                <div class="absolute top-0 right-0 w-32 h-32 bg-blue-500/20 blur-[60px] rounded-full"></div>
                <div class="absolute bottom-0 left-0 w-32 h-32 bg-purple-500/20 blur-[60px] rounded-full"></div>
            </div>
        </div>
    </div>
</section>
