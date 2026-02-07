<div class="py-6 pt-20 md:py-12 md:pt-28 min-h-screen bg-slate-50 relative overflow-hidden">
    {{-- Subtle Background Accents --}}
    <div class="fixed top-0 left-0 w-full h-full pointer-events-none">
        <div class="absolute top-[-10%] right-[-10%] w-[40%] h-[40%] bg-blue-500/5 blur-[120px] rounded-full"></div>
        <div class="absolute bottom-[-10%] left-[-10%] w-[40%] h-[40%] bg-indigo-500/5 blur-[120px] rounded-full"></div>
    </div>

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10">
        {{-- Hero Section --}}
        <div class="text-center mb-10 md:mb-16">
            <h1 class="text-2xl sm:text-4xl md:text-5xl font-extrabold text-slate-900 mb-4 md:mb-6 font-jakarta tracking-tight leading-tight flex flex-wrap items-center justify-center gap-2 sm:gap-3">
                Pilih <span class="bg-gradient-to-r from-blue-600 to-indigo-600 bg-clip-text text-transparent">Paket Simulasi</span> Kamu
                <svg class="w-6 h-6 sm:w-10 sm:h-10 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z" /></svg>
            </h1>
            <p class="text-sm md:text-lg text-slate-500 max-w-2xl mx-auto font-medium leading-relaxed">
                Persiapkan dirimu dengan ribuan soal berkualitas yang dirancang khusus menyerupai tes SKD CPNS sesungguhnya.
            </p>
        </div>

        {{-- Flash Sale Banner (Glassmorphism) --}}
        <div class="relative group mb-10 md:mb-16" x-data="flashSaleTimer()">
            <div class="absolute inset-0 bg-gradient-to-r from-rose-500 to-orange-500 rounded-[2rem] blur-2xl opacity-20 group-hover:opacity-30 transition-opacity duration-500"></div>
            
            <div class="relative bg-white/60 backdrop-blur-2xl rounded-[2rem] border border-white/40 p-6 md:p-10 shadow-xl overflow-hidden">
                {{-- Decorative blobs --}}
                <div class="absolute top-0 right-0 w-64 h-64 bg-rose-500/10 blur-[80px] rounded-full -translate-y-1/2 translate-x-1/2"></div>
                <div class="absolute bottom-0 left-0 w-48 h-48 bg-orange-500/10 blur-[60px] rounded-full translate-y-1/2 -translate-x-1/2"></div>
                
                <div class="relative z-10 flex flex-col lg:flex-row items-center justify-between gap-8 md:gap-10">
                    <div class="text-center lg:text-left flex-1">
                        <div class="inline-flex items-center gap-2 px-3 py-1 md:px-4 md:py-1.5 bg-rose-600 text-white rounded-full text-[10px] md:text-xs font-black tracking-widest uppercase mb-4 animate-bounce shadow-lg shadow-rose-500/30">
                            <svg class="w-3 md:w-3.5 h-3 md:h-3.5" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M12.395 2.553a1 1 0 00-1.45-.385c-.345.23-.614.558-.822.88-.214.33-.403.713-.57 1.116-.334.804-.614 1.768-.84 2.734a31.365 31.365 0 00-.613 3.58 2.64 2.64 0 01-.945-1.067c-.328-.68-.398-1.534-.398-2.654A1 1 0 005.05 6.05 6.981 6.981 0 003 11a7 7 0 1011.95-4.95c-.592-.591-.98-1.336-1.15-2.103a11.97 11.97 0 00-.405-1.394 1 1 0 00-.003-.004z" clip-rule="evenodd" /></svg>
                            FLASH SALE!
                        </div>
                        <h3 class="text-2xl md:text-4xl font-extrabold text-slate-900 mb-2 font-jakarta tracking-tight">
                            Diskon <span class="text-rose-600">30%</span> Khusus Paket Bundle!
                        </h3>
                        <p class="text-sm md:text-base text-slate-500 font-bold flex items-center justify-center lg:justify-start gap-2">
                             Penawaran terbatas untuk persiapan maksimal kamu
                        </p>
                    </div>
                    
                    {{-- Countdown Timer --}}
                    <div class="flex flex-wrap items-center justify-center gap-2 sm:gap-4">
                        <div class="flex flex-col items-center">
                            <div class="bg-white/80 backdrop-blur shadow-lg rounded-2xl w-12 h-12 sm:w-16 sm:h-16 md:w-20 md:h-20 flex items-center justify-center border border-white">
                                <span class="text-lg sm:text-2xl md:text-3xl font-black text-rose-600 font-jakarta" x-text="days">00</span>
                            </div>
                            <span class="text-[9px] md:text-[10px] font-black text-slate-400 uppercase tracking-widest mt-2">Hari</span>
                        </div>
                        <span class="text-lg md:text-2xl font-bold text-slate-300 mb-6">:</span>
                        <div class="flex flex-col items-center">
                            <div class="bg-white/80 backdrop-blur shadow-lg rounded-2xl w-12 h-12 sm:w-16 sm:h-16 md:w-20 md:h-20 flex items-center justify-center border border-white">
                                <span class="text-lg sm:text-2xl md:text-3xl font-black text-rose-600 font-jakarta" x-text="hours">00</span>
                            </div>
                            <span class="text-[9px] md:text-[10px] font-black text-slate-400 uppercase tracking-widest mt-2">Jam</span>
                        </div>
                        <span class="text-lg md:text-2xl font-bold text-slate-300 mb-6">:</span>
                        <div class="flex flex-col items-center">
                            <div class="bg-white/80 backdrop-blur shadow-lg rounded-2xl w-12 h-12 sm:w-16 sm:h-16 md:w-20 md:h-20 flex items-center justify-center border border-white">
                                <span class="text-lg sm:text-2xl md:text-3xl font-black text-rose-600 font-jakarta" x-text="minutes">00</span>
                            </div>
                            <span class="text-[9px] md:text-[10px] font-black text-slate-400 uppercase tracking-widest mt-2">Menit</span>
                        </div>
                        <span class="text-lg md:text-2xl font-bold text-slate-300 mb-6">:</span>
                        <div class="flex flex-col items-center">
                            <div class="bg-rose-600 shadow-lg shadow-rose-200 rounded-2xl w-12 h-12 sm:w-16 sm:h-16 md:w-20 md:h-20 flex items-center justify-center border border-rose-500">
                                <span class="text-lg sm:text-2xl md:text-3xl font-black text-white font-jakarta" x-text="seconds">00</span>
                            </div>
                            <span class="text-[9px] md:text-[10px] font-black text-slate-400 uppercase tracking-widest mt-2">Detik</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <script>
            function flashSaleTimer() {
                return {
                    days: '00',
                    hours: '00',
                    minutes: '00',
                    seconds: '00',
                    init() {
                        const endDate = new Date();
                        endDate.setDate(endDate.getDate() + 3);
                        endDate.setHours(23, 59, 59, 0);
                        this.updateCountdown(endDate);
                        setInterval(() => this.updateCountdown(endDate), 1000);
                    },
                    updateCountdown(endDate) {
                        const now = new Date();
                        const diff = endDate - now;
                        if (diff > 0) {
                            this.days = String(Math.floor(diff / (1000 * 60 * 60 * 24))).padStart(2, '0');
                            this.hours = String(Math.floor((diff % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60))).padStart(2, '0');
                            this.minutes = String(Math.floor((diff % (1000 * 60 * 60)) / (1000 * 60))).padStart(2, '0');
                            this.seconds = String(Math.floor((diff % (1000 * 60)) / 1000)).padStart(2, '0');
                        }
                    }
                }
            }
        </script>

        {{-- Main Stats Grid --}}
        <div class="grid grid-cols-2 lg:grid-cols-4 gap-4 md:gap-6 mb-12 md:mb-20">
            <div class="bg-white/60 backdrop-blur-xl rounded-2xl border border-white/40 p-4 md:p-6 shadow-sm hover:shadow-lg transition-all duration-300 group">
                <div class="text-2xl md:text-3xl font-black text-blue-600 font-jakarta mb-1 group-hover:scale-110 transition-transform origin-left">{{ $packages[0]['total_questions'] ?? 110 }}</div>
                <p class="text-[9px] md:text-[10px] font-black text-slate-400 uppercase tracking-widest leading-tight">Soal per Paket</p>
                <div class="w-8 h-1 bg-blue-100 mt-3 rounded-full group-hover:w-full transition-all duration-500"></div>
            </div>
            <div class="bg-white/60 backdrop-blur-xl rounded-2xl border border-white/40 p-4 md:p-6 shadow-sm hover:shadow-lg transition-all duration-300 group">
                <div class="text-2xl md:text-3xl font-black text-indigo-600 font-jakarta mb-1 group-hover:scale-110 transition-transform origin-left">{{ $packages[0]['duration_minutes'] ?? 100 }}</div>
                <p class="text-[9px] md:text-[10px] font-black text-slate-400 uppercase tracking-widest leading-tight">Menit Waktu</p>
                <div class="w-8 h-1 bg-indigo-100 mt-3 rounded-full group-hover:w-full transition-all duration-500"></div>
            </div>
            <div class="bg-white/60 backdrop-blur-xl rounded-2xl border border-white/40 p-4 md:p-6 shadow-sm hover:shadow-lg transition-all duration-300 group">
                <div class="text-2xl md:text-3xl font-black text-emerald-600 font-jakarta mb-1 group-hover:scale-110 transition-transform origin-left">{{ count($packages) }}</div>
                <p class="text-[9px] md:text-[10px] font-black text-slate-400 uppercase tracking-widest leading-tight">Paket Tersedia</p>
                <div class="w-8 h-1 bg-emerald-100 mt-3 rounded-full group-hover:w-full transition-all duration-500"></div>
            </div>
            <div class="bg-white/60 backdrop-blur-xl rounded-2xl border border-white/40 p-4 md:p-6 shadow-sm hover:shadow-lg transition-all duration-300 group">
                <div class="text-2xl md:text-3xl font-black text-amber-600 font-jakarta mb-1 group-hover:scale-110 transition-transform origin-left">550</div>
                <p class="text-[9px] md:text-[10px] font-black text-slate-400 uppercase tracking-widest leading-tight">Skor Maksimal</p>
                <div class="w-8 h-1 bg-amber-100 mt-3 rounded-full group-hover:w-full transition-all duration-500"></div>
            </div>
        </div>

        {{-- Packages Header --}}
        <div class="flex items-center gap-4 mb-6 md:mb-8">
            <h2 class="text-xl md:text-2xl font-bold text-slate-900 font-jakarta tracking-tight whitespace-nowrap">Pilih Paket Simulasi</h2>
            <div class="h-px w-full bg-slate-200"></div>
        </div>

        {{-- Packages Grid --}}
        <div class="grid md:grid-cols-2 lg:grid-cols-3 gap-8 mb-20">
            @foreach($packages as $package)
                <div class="group relative bg-white rounded-3xl border border-slate-100 p-1 shadow-sm hover:shadow-2xl hover:shadow-blue-500/10 transition-all duration-500 overflow-hidden flex flex-col h-full">
                    <div class="p-8 flex-1 flex flex-col">
                        <div class="flex items-center justify-between mb-6">
                            <span class="px-3 py-1 bg-slate-900 text-white rounded-full text-[10px] font-black tracking-widest uppercase shadow-sm">
                                SKD {{ $package['year'] }}
                            </span>
                            @if($package['year'] >= 2026)
                                <span class="flex items-center gap-1.5 px-3 py-1 bg-amber-50 text-amber-600 rounded-full text-[10px] font-black tracking-widest uppercase border border-amber-100">
                                    <span class="w-1.5 h-1.5 bg-amber-500 rounded-full animate-ping"></span>
                                    PREDIKSI
                                </span>
                            @endif
                        </div>
                        
                        <h3 class="text-xl font-bold text-slate-900 font-jakarta leading-tight mb-3 group-hover:text-blue-600 transition-colors duration-300">
                            {{ $package['name'] }}
                        </h3>
                        <p class="text-slate-500 text-sm font-medium mb-8 flex-1">
                            {{ $package['description'] }}
                        </p>
                        
                        <div class="space-y-4 mb-8">
                            <div class="flex items-center gap-3 text-sm font-bold text-slate-600">
                                <div class="w-6 h-6 rounded-lg bg-blue-50 text-blue-600 flex items-center justify-center">
                                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8.228 9c.549-1.165 2.03-2 3.772-2 2.21 0 4 1.343 4 3 0 1.4-1.278 2.575-3.006 2.907-.542.104-.994.54-.994 1.093m0 3h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
                                </div>
                                <span class="font-jakarta">{{ $package['total_questions'] }} Soal Lengkap</span>
                            </div>
                            <div class="flex items-center gap-3 text-sm font-bold text-slate-600">
                                <div class="w-6 h-6 rounded-lg bg-indigo-50 text-indigo-600 flex items-center justify-center">
                                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
                                </div>
                                <span class="font-jakarta">{{ $package['duration_minutes'] }} Menit Simulasi</span>
                            </div>
                            <div class="flex items-center gap-3 text-sm font-bold text-slate-600">
                                <div class="w-6 h-6 rounded-lg bg-emerald-50 text-emerald-600 flex items-center justify-center">
                                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
                                </div>
                                <span class="font-jakarta">Pembahasan Detail</span>
                            </div>
                        </div>

                        <div class="mb-8 pt-6 border-t border-slate-50">
                            <div class="flex items-baseline gap-1">
                                <span class="text-xs font-bold text-slate-400 uppercase tracking-widest">Hanya</span>
                                <span class="text-3xl font-black text-slate-900 font-jakarta">Rp {{ number_format($package['price'], 0, ',', '.') }}</span>
                            </div>
                        </div>

                        <button 
                            wire:click="selectPackage({{ $package['id'] }})"
                            class="relative w-full inline-flex items-center justify-center p-4 rounded-2xl group/btn overflow-hidden transition-all duration-300"
                        >
                            <div class="absolute inset-0 bg-gradient-to-r from-blue-600 to-indigo-700 opacity-100 group-hover/btn:opacity-90 transition-opacity"></div>
                            <span class="relative flex items-center gap-2 font-bold text-white font-jakarta text-sm tracking-wide">
                                Beli Sekarang
                                <svg class="w-4 h-4 group-hover/btn:translate-x-1.5 transition-transform duration-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3" /></svg>
                            </span>
                        </button>
                    </div>
                </div>
            @endforeach
        </div>

        {{-- Bundle Section --}}
        @if(count($bundles) > 0)
            <div class="flex items-center gap-4 mb-8">
                <h2 class="text-2xl font-bold text-slate-900 font-jakarta tracking-tight whitespace-nowrap flex items-center gap-2">
                    Penawaran Bundle Hemat
                    <svg class="w-6 h-6 text-amber-500 fill-current" viewBox="0 0 24 24"><path d="M12 2l3.09 6.26L22 9.27l-5 4.87 1.18 6.88L12 17.77l-6.18 3.25L7 14.14 2 9.27l6.91-1.01L12 2z"/></svg> 
                </h2>
                <div class="h-px w-full bg-slate-200"></div>
            </div>

            <div class="space-y-8 mb-20">
                @foreach($bundles as $bundle)
                    <div class="relative group">
                        {{-- Outer Glow --}}
                        <div class="absolute inset-0 bg-gradient-to-r from-blue-600 to-indigo-700 rounded-[2.5rem] blur-2xl opacity-10 group-hover:opacity-20 transition-opacity duration-500"></div>
                        
                        <div class="relative bg-gradient-to-br from-slate-950 via-slate-900 to-blue-950 rounded-[2.5rem] p-8 md:p-12 overflow-hidden shadow-2xl border border-white/5">
                            {{-- Geometric Shapes Decor (Premium) --}}
                            <div class="absolute top-0 right-0 w-96 h-96 bg-blue-500/10 blur-[100px] rounded-full translate-x-1/2 -translate-y-1/2"></div>
                            <div class="absolute bottom-0 left-0 w-64 h-64 bg-indigo-500/10 blur-[70px] rounded-full -translate-x-1/2 translate-y-1/2"></div>
                            
                            {{-- Pattern Overlay --}}
                            <div class="absolute inset-0 opacity-[0.03] pointer-events-none" style="background-image: radial-gradient(#fff 0.5px, transparent 0.5px); background-size: 24px 24px;"></div>

                            <div class="relative z-10 flex flex-col lg:flex-row items-center justify-between gap-10 text-white">
                                <div class="text-center lg:text-left">
                                    <div class="inline-flex items-center gap-2 px-3 py-1 bg-gradient-to-r from-yellow-400 to-amber-500 text-slate-950 rounded-full text-[10px] font-black tracking-widest uppercase mb-4 shadow-xl shadow-yellow-400/20">
                                        PREMIUM VALUE • SAVE {{ round((($bundle['original_price'] - $bundle['discount_price']) / $bundle['original_price']) * 100) }}%
                                    </div>
                                    <h3 class="text-3xl md:text-5xl font-black mb-4 font-jakarta tracking-tight leading-tight flex items-center justify-center lg:justify-start gap-4">
                                        {{ $bundle['name'] }}
                                        <svg class="w-8 h-8 text-yellow-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 3v4M3 5h4M6 17v4m-2-2h4m5-16l2.286 6.857L21 12l-5.714 2.143L13 21l-2.286-6.857L5 12l5.714-2.143L13 3z" /></svg>
                                    </h3>
                                    <p class="text-white/60 text-lg font-medium max-w-xl">
                                        {{ $bundle['description'] }}
                                    </p>
                                </div>

                                <div class="bg-white/5 backdrop-blur-md rounded-3xl p-8 border border-white/10 min-w-[280px] text-center lg:text-right shadow-inner">
                                    <p class="text-white/20 text-sm font-bold truncate line-through mb-1 uppercase tracking-widest">
                                        Rp {{ number_format($bundle['original_price'], 0, ',', '.') }}
                                    </p>
                                    <div class="text-4xl md:text-5xl font-black font-jakarta mb-6 text-yellow-400 leading-none drop-shadow-sm">
                                        Rp {{ number_format($bundle['discount_price'], 0, ',', '.') }}
                                    </div>
                                    <button 
                                        wire:click="selectBundle({{ $bundle['id'] }})"
                                        class="w-full py-4 bg-white text-slate-950 rounded-2xl font-black text-sm uppercase tracking-widest hover:bg-yellow-400 transition-all duration-300 shadow-xl active:scale-95"
                                    >
                                        Beli Bundle
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        @endif

        {{-- Benefits Grid --}}
        <div class="grid md:grid-cols-3 gap-10 mt-20 pt-20 border-t border-slate-100">
            <div class="group">
                <div class="w-16 h-16 bg-blue-50 text-blue-600 rounded-3xl flex items-center justify-center mb-6 group-hover:scale-110 group-hover:rotate-6 transition-all duration-300">
                    <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                </div>
                <h3 class="text-xl font-bold text-slate-900 mb-2 font-jakarta">Soal Berkualitas</h3>
                <p class="text-slate-500 font-medium leading-relaxed">Setiap butir soal disusun berdasarkan kurikulum ter-update dan pola tes CPNS asli.</p>
            </div>
            <div class="group">
                <div class="w-16 h-16 bg-indigo-50 text-indigo-600 rounded-3xl flex items-center justify-center mb-6 group-hover:scale-110 group-hover:-rotate-6 transition-all duration-300">
                    <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                </div>
                <h3 class="text-xl font-bold text-slate-900 mb-2 font-jakarta">Timer Realistis</h3>
                <p class="text-slate-500 font-medium leading-relaxed">Simulasi menggunakan timer yang presisi untuk melatih manajemen waktu kamu.</p>
            </div>
            <div class="group">
                <div class="w-16 h-16 bg-emerald-50 text-emerald-600 rounded-3xl flex items-center justify-center mb-6 group-hover:scale-110 group-hover:rotate-6 transition-all duration-300">
                    <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6"></path></svg>
                </div>
                <h3 class="text-xl font-bold text-slate-900 mb-2 font-jakarta">Pembahasan Detail</h3>
                <p class="text-slate-500 font-medium leading-relaxed">Setelah ujian, kamu bisa langsung akses kunci jawaban beserta penjelasan mendalam.</p>
            </div>
        </div>
    </div>

    {{-- Payment Modal (Glassmorphism) --}}
    @if($showPaymentModal && ($selectedPackage || $selectedBundle))
        @php
            $item = $selectedPackage ?? $selectedBundle;
            $itemName = $selectedPackage ? $item->name : $item->name . ' (Bundle)';
            $itemPrice = $selectedPackage ? $item->price : $item->discount_price;
            $itemSlug = $item->slug;
            $checkoutRoute = route('payment.checkout', ['slug' => $itemSlug, 'type' => $selectedPackage ? 'package' : 'bundle']);
        @endphp
        <div class="fixed inset-0 z-[100] flex items-center justify-center p-4 sm:p-6 overflow-y-auto">
            {{-- Backdrop --}}
            <div class="fixed inset-0 bg-slate-900/40 backdrop-blur-md transition-opacity duration-300" wire:click="closeModal"></div>
            
            {{-- Modal Content --}}
            <div class="relative bg-white/90 backdrop-blur-2xl rounded-[2.5rem] w-full max-w-md shadow-[0_0_50px_rgba(0,0,0,0.1)] border border-white overflow-hidden transform transition-all duration-300 scale-100">
                <div class="p-8 md:p-10">
                    <div class="flex items-center gap-4 mb-8">
                        <div class="w-12 h-12 bg-blue-600 rounded-2xl flex items-center justify-center text-white flex-shrink-0 shadow-lg shadow-blue-500/30">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z" /></svg>
                        </div>
                        <div>
                            <h3 class="text-2xl font-extrabold text-slate-900 font-jakarta leading-tight">Konfirmasi</h3>
                            <p class="text-slate-400 font-bold text-[10px] uppercase tracking-widest">Detail Pesanan Kamu</p>
                        </div>
                    </div>

                    <div class="space-y-6 mb-10">
                        <div class="p-6 bg-slate-50 rounded-2xl border border-slate-100 relative overflow-hidden group">
                           <div class="relative z-10 flex justify-between items-start">
                                <span class="text-sm font-bold text-slate-500 font-jakarta">{{ $itemName }}</span>
                                <span class="text-sm font-black text-slate-900 font-jakarta">Rp {{ number_format($itemPrice, 0, ',', '.') }}</span>
                           </div>
                           <div class="absolute top-0 right-0 w-32 h-32 bg-blue-500/5 blur-2xl rounded-full translate-x-12 -translate-y-12 transition-transform duration-500 group-hover:scale-150"></div>
                        </div>

                        <div class="flex justify-between items-center px-2">
                             <span class="text-sm font-black text-slate-400 uppercase tracking-widest">Total Bayar</span>
                             <span class="text-3xl font-black text-blue-600 font-jakarta tracking-tight">Rp {{ number_format($itemPrice, 0, ',', '.') }}</span>
                        </div>
                    </div>

                    <p class="text-slate-500 text-sm font-medium mb-10 text-center px-4 leading-relaxed">
                        Akses simulasi akan terbuka otomatis <span class="text-slate-900 font-bold text-indigo-500">SEKETIKA</span> setelah pembayaran kamu berhasil diverifikasi.
                    </p>

                    <div class="grid grid-cols-2 gap-4">
                        <button 
                            wire:click="closeModal"
                            class="py-4 bg-slate-100 text-slate-500 rounded-2xl font-bold text-sm tracking-wide hover:bg-slate-200 transition-all duration-300"
                        >
                            Batal
                        </button>
                        <a 
                            href="{{ $checkoutRoute }}"
                            class="relative inline-flex items-center justify-center py-4 rounded-2xl group/btn_p overflow-hidden transition-all duration-300"
                        >
                            <div class="absolute inset-0 bg-gradient-to-r from-blue-600 to-indigo-700"></div>
                            <span class="relative font-jakarta font-black text-white text-sm tracking-widest uppercase">Bayar</span>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    @endif
</div>
