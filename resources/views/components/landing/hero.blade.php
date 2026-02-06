@props(['package' => null])
<section class="landing-hero min-h-screen flex items-center relative overflow-hidden pt-16">
    {{-- Animated Background Blobs --}}
    <div class="blob blob-1 w-[500px] h-[500px] bg-blue-600 -top-40 -left-40"></div>
    <div class="blob blob-2 w-[400px] h-[400px] bg-purple-600 top-1/3 -right-20"></div>
    <div class="blob blob-3 w-[300px] h-[300px] bg-cyan-500 bottom-10 left-1/4"></div>

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12 lg:py-20 relative z-10">
        <div class="grid lg:grid-cols-2 gap-12 lg:gap-16 items-center">
            {{-- Left Content --}}
            <div class="text-center lg:text-left">
                {{-- Promo Badge --}}
                <div class="inline-flex items-center gap-2 px-4 py-2 bg-red-500/10 border border-red-500/20 rounded-full mb-8 pulse-badge">
                    <span class="w-2 h-2 bg-red-500 rounded-full animate-pulse"></span>
                    <span class="text-red-400 text-sm font-medium">🔥 Diskon 30% - Berakhir dalam 3 hari!</span>
                </div>

                {{-- Main Heading --}}
                <h1 class="text-4xl sm:text-5xl lg:text-[58px] font-black text-white leading-[1.1] mb-6 tracking-tighter uppercase">
                    <span class="whitespace-nowrap">Raih Skor <span class="gradient-text">Tertinggi</span></span> <br class="hidden lg:block"> di Tes SKD CPNS
                </h1>

                {{-- Subheading --}}
                <p class="text-lg sm:text-xl text-slate-400 mb-10 leading-relaxed max-w-xl mx-auto lg:mx-0">
                    Latihan soal SKD CPNS dengan sistem seperti CAT BKN. Tersedia ribuan soal TWK, TIU, dan TKP dengan pembahasan lengkap.
                </p>

                {{-- CTA Buttons --}}
                <div class="flex flex-col sm:flex-row gap-4 mb-12">
                    <a href="{{ route('test.free-simulation') }}" class="btn-primary px-8 py-4 rounded-xl font-bold flex items-center justify-center gap-2 group">
                        Mulai Latihan Gratis
                        <svg class="w-5 h-5 group-hover:translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path>
                        </svg>
                    </a>
                    <a href="#pricing" class="px-8 py-4 btn-secondary text-white rounded-xl font-semibold text-lg flex items-center justify-center gap-2">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"></path>
                        </svg>
                        Lihat Paket
                    </a>
                </div>

                {{-- Feature Highlights --}}
                <div class="flex flex-wrap gap-x-6 gap-y-3 justify-center lg:justify-start text-slate-400">
                    <div class="flex items-center gap-2">
                        <svg class="w-5 h-5 text-green-500" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/>
                        </svg>
                        <span class="text-sm font-medium">{{ $package->total_questions ?? 110 }} soal/paket</span>
                    </div>
                    <div class="flex items-center gap-2">
                        <svg class="w-5 h-5 text-green-500" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/>
                        </svg>
                        <span class="text-sm font-medium">Timer {{ $package->duration_minutes ?? 100 }} menit</span>
                    </div>
                    <div class="flex items-center gap-2">
                        <svg class="w-5 h-5 text-green-500" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/>
                        </svg>
                        <span class="text-sm font-medium">Pembahasan lengkap</span>
                    </div>
                </div>
            </div>

            {{-- Right Content - Passing Grade Card --}}
            <div class="relative">
                <x-landing.passing-grade-card />
            </div>
        </div>
    </div>
</section>
