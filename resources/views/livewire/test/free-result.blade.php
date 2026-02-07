<div class="py-12 bg-gray-50/50 min-h-screen">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        {{-- Top Navigation --}}
        <div class="mb-6">
            <a href="{{ route('home') }}" class="inline-flex items-center gap-2 text-slate-500 hover:text-blue-600 transition-colors font-semibold group">
                <svg class="w-5 h-5 group-hover:-translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                </svg>
                Kembali ke Beranda
            </a>
        </div>

        {{-- Success Banner --}}
        <div class="bg-gradient-to-br from-blue-700 to-indigo-800 rounded-3xl p-6 md:p-8 mb-8 md:mb-12 text-white relative overflow-hidden shadow-2xl">
            {{-- Decoration --}}
            <div class="absolute -right-20 -top-20 w-80 h-80 bg-white/10 rounded-full blur-3xl"></div>
            <div class="absolute -left-20 -bottom-20 w-80 h-80 bg-purple-600/20 rounded-full blur-3xl"></div>
            
            <div class="relative z-10 flex flex-col items-center text-center">
                <div class="w-20 h-20 md:w-24 md:h-24 bg-white/15 backdrop-blur-md rounded-full flex items-center justify-center mb-6 shadow-xl border border-white/20">
                    <svg class="w-10 h-10 md:w-12 md:h-12 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4M7.835 4.697a3.42 3.42 0 001.946-.806 3.42 3.42 0 014.438 0 3.42 3.42 0 001.946.806 3.42 3.42 0 013.138 3.138 3.42 3.42 0 00.806 1.946 3.42 3.42 0 010 4.438 3.42 3.42 0 00-.806 1.946 3.42 3.42 0 01-3.138 3.138 3.42 3.42 0 00-1.946.806 3.42 3.42 0 01-4.438 0 3.42 3.42 0 00-1.946-.806 3.42 3.42 0 01-3.138-3.138z"></path>
                    </svg>
                </div>
                
                <h2 class="text-2xl md:text-3xl font-black mb-2 tracking-tight">HASIL LATIHAN GUEST</h2>
                <p class="text-blue-100 text-base md:text-lg mb-8 max-w-xl">
                    Luar biasa! Kamu telah menyelesaikan uji coba simulasi CAT CPNS 2026. Lihat progresmu di bawah ini.
                </p>

                <div class="flex flex-wrap justify-center gap-4">
                    <div class="px-6 py-3 bg-white/20 backdrop-blur-md rounded-2xl border border-white/10">
                        <span class="block text-white/70 text-xs font-bold uppercase tracking-widest mb-1">Total Skor</span>
                        <span class="text-3xl md:text-4xl font-black">{{ $result['total_score'] }}</span>
                    </div>
                    <div class="px-6 py-3 bg-white/20 backdrop-blur-md rounded-2xl border border-white/10">
                        <span class="block text-white/70 text-xs font-bold uppercase tracking-widest mb-1">Status Lulus</span>
                        <span class="text-xl md:text-2xl font-black uppercase tracking-tight">
                            {{ $result['passed_overall'] ? 'LULUS SKD' : 'BELUM LULUS' }}
                        </span>
                    </div>
                </div>
            </div>
        </div>

        {{-- Score Details --}}
        <div class="grid md:grid-cols-3 gap-4 md:gap-8 mb-8 md:mb-12">
            @foreach(['twk' => 'Tes Wawasan Kebangsaan', 'tiu' => 'Tes Intelegensia Umum', 'tkp' => 'Tes Karakteristik Pribadi'] as $key => $title)
                <div class="bg-white rounded-3xl p-6 md:p-8 border border-gray-100 shadow-sm relative overflow-hidden group hover:shadow-xl transition-all">
                    <div class="relative z-10">
                        <h4 class="text-gray-400 font-bold text-xs uppercase tracking-widest mb-4">{{ $title }}</h4>
                        <div class="flex items-end justify-between mb-6">
                            <span class="text-4xl md:text-5xl font-black text-slate-800">{{ $result['scores'][$key]['score'] }}</span>
                            <span class="text-xs md:text-sm font-medium text-slate-400 mb-2">/ PG: {{ $result['scores'][$key]['passing_grade'] }}</span>
                        </div>

                        <div class="w-full bg-gray-100 rounded-full h-3 mb-6">
                            @php
                                $maxPerCat = ($key === 'tkp' ? 225 : ($key === 'tiu' ? 175 : 150));
                                $percentage = ($result['scores'][$key]['score'] / $maxPerCat) * 100;
                            @endphp
                            <div class="h-3 rounded-full {{ $result['scores'][$key]['passed'] ? 'bg-green-500' : 'bg-red-500' }}" style="width: {{ min(100, $percentage) }}%"></div>
                        </div>

                        <div class="flex items-center gap-2">
                            @if($result['scores'][$key]['passed'])
                                <span class="flex-shrink-0 w-6 h-6 bg-green-100 text-green-600 rounded-full flex items-center justify-center">
                                    <svg class="w-4 h-4 shadow-sm" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                                    </svg>
                                </span>
                                <span class="text-xs md:text-sm font-bold text-green-600 uppercase tracking-tight">Memenuhi Ambang Batas</span>
                            @else
                                <span class="flex-shrink-0 w-6 h-6 bg-red-100 text-red-600 rounded-full flex items-center justify-center">
                                    <svg class="w-4 h-4 shadow-sm" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                                    </svg>
                                </span>
                                <span class="text-xs md:text-sm font-bold text-red-600 uppercase tracking-tight">Dibawah Ambang Batas</span>
                            @endif
                        </div>
                    </div>
                </div>
            @endforeach
        </div>

        {{-- PROMOTION SECTION (REACTIVE & CREATIVE) --}}
        <div class="bg-gradient-to-br from-slate-900 to-indigo-950 rounded-[2.5rem] p-6 md:p-12 mb-8 md:mb-12 text-white shadow-2xl relative overflow-hidden">
            {{-- Background Effects --}}
            <div class="absolute right-0 top-0 w-1/3 h-full opacity-20 transform translate-x-1/4">
                <svg viewBox="0 0 200 200" xmlns="http://www.w3.org/2000/svg">
                    <path fill="#4F46E5" d="M44.7,-76.4C58.8,-69.2,71.8,-59.1,79.6,-45.8C87.4,-32.5,90,-16.3,88.5,-0.9C87,14.5,81.4,29,72.4,41.4C63.4,53.8,51,64.1,37.1,71.2C23.2,78.3,7.8,82.2,-8.1,80.6C-24,78.9,-40.4,71.7,-53.4,61.4C-66.4,51.1,-76,37.7,-81.2,23.3C-86.3,8.9,-87,-6.6,-82.7,-20.9C-78.4,-35.1,-69.1,-48.1,-56.9,-55.9C-44.7,-63.7,-29.6,-66.2,-15.7,-71.4C-1.8,-76.6,12.7,-84.5,29,-83.6C45.3,-82.7,63.4,-73,44.7,-76.4Z" transform="translate(100 100)" />
                </svg>
            </div>

            <div class="flex flex-col lg:flex-row items-center gap-12 relative z-10">
                <div class="flex-1 text-center lg:text-left">
                    <div class="inline-flex items-center gap-2 px-4 py-1.5 bg-yellow-500/10 border border-yellow-500/30 text-yellow-400 rounded-full text-xs font-bold uppercase tracking-widest mb-6">
                        🔥 SIAP LOLOS CPNS 2026?
                    </div>
                    <h3 class="text-4xl sm:text-5xl font-black mb-6 leading-tight">
                        Ini Baru <span class="text-blue-400">Pemanasan.</span><br>
                        Tantangan Aslinya Menanti!
                    </h3>
                    <p class="text-slate-400 text-lg mb-8 max-w-xl leading-relaxed">
                        Kamu baru saja mengerjakan {{ count($result['answers'] ?? []) }} soal. Simulasi sesungguhnya memiliki <span class="text-white font-bold italic">{{ $result['package_total_questions'] ?? 110 }} soal</span> dengan tingkat kesulitan yang terus diupdate setiap tahun. Jangan biarkan persiapanmu nanggung!
                    </p>
                    <ul class="space-y-4 mb-10 text-slate-300">
                        <li class="flex items-center gap-3">
                            <span class="w-6 h-6 bg-blue-500/20 text-blue-400 rounded-full flex items-center justify-center font-bold text-xs">✓</span>
                            <span>Akses {{ $result['package_total_questions'] ?? 110 }} Soal Prediksi Tertajam 2026</span>
                        </li>
                        <li class="flex items-center gap-3">
                            <span class="w-6 h-6 bg-blue-500/20 text-blue-400 rounded-full flex items-center justify-center font-bold text-xs">✓</span>
                            <span>Sistem CAT Persis Standar BKN (Layar penuh & Anti-Curang)</span>
                        </li>
                        <li class="flex items-center gap-3">
                            <span class="w-6 h-6 bg-blue-500/20 text-blue-400 rounded-full flex items-center justify-center font-bold text-xs">✓</span>
                            <span>Analisis Skor & Pembahasan Detail Per Materi</span>
                        </li>
                    </ul>
                    <div class="flex flex-wrap gap-4 justify-center lg:justify-start">
                        <a href="{{ route('register') }}" class="px-10 py-5 bg-blue-600 hover:bg-blue-700 text-white rounded-2xl font-black shadow-2xl shadow-blue-500/40 transition-all hover:-translate-y-1 block">
                            DAPATKAN AKSES FULL SEKARANG
                        </a>
                        <button wire:click="restart" class="px-10 py-5 bg-white/10 hover:bg-white/15 text-white rounded-2xl font-bold transition-all block text-center">
                            Coba Ulang Gratis
                        </button>
                    </div>
                </div>
                
                <div class="hidden lg:block w-72 flex-shrink-0">
                    <div class="glass-card rounded-3xl p-6 border-blue-500/30 shadow-[0_0_50px_rgba(59,130,246,0.2)]">
                        <div class="text-center mb-6">
                            <p class="text-xs font-bold text-blue-400 uppercase mb-2">Paling Populer</p>
                            <h4 class="text-xl font-bold">Paket Prediksi 2026</h4>
                        </div>
                        <div class="space-y-4 mb-8">
                            <div class="flex items-center justify-between text-sm">
                                <span class="text-slate-400">Harga Normal</span>
                                <span class="text-slate-500 line-through">Rp 150.000</span>
                            </div>
                            <div class="flex items-center justify-between">
                                <span class="text-slate-300">Hanya</span>
                                <span class="text-3xl font-black text-white">Rp 49rb</span>
                            </div>
                        </div>
                        <p class="text-[10px] text-slate-500 text-center uppercase tracking-widest">Akses Selamanya • Update Berkala</p>
                    </div>
                </div>
            </div>
        </div>

        {{-- Review Section --}}
        <h3 class="text-2xl font-bold text-slate-900 mb-6 flex items-center gap-3">
            <svg class="w-8 h-8 text-blue-600 font-bold" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01"></path>
            </svg>
            Review Jawaban
        </h3>

        <div class="space-y-6">
            @if(!$showReview)
                <div class="bg-white rounded-3xl p-12 text-center border border-gray-100 shadow-sm">
                    <div class="w-20 h-20 bg-blue-50 text-blue-500 rounded-full flex items-center justify-center mx-auto mb-6">
                        <svg class="w-10 h-10" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                        </svg>
                    </div>
                    <h4 class="text-xl font-bold text-slate-900 mb-2">Ingin lihat kunci jawaban?</h4>
                    <p class="text-slate-500 mb-8 max-w-sm mx-auto">Lihat penjelasan lengkap setiap materi yang kamu kerjakan barusan untuk dipelajari lebih dalam.</p>
                    <button wire:click="toggleReview" class="px-8 py-3.5 bg-slate-900 text-white rounded-2xl font-bold hover:bg-slate-800 transition-all shadow-xl shadow-slate-900/20">
                        Buka Review Pembahasan
                    </button>
                </div>
            @else
                {{-- PREMIUM LOCK UI --}}
                <div class="bg-white rounded-[2.5rem] p-12 text-center border-4 border-dashed border-gray-100 relative overflow-hidden shadow-2xl">
                    {{-- Decorative Background --}}
                    <div class="absolute -right-20 -top-20 w-64 h-64 bg-yellow-500/5 rounded-full blur-3xl"></div>
                    <div class="absolute -left-20 -bottom-20 w-64 h-64 bg-blue-500/5 rounded-full blur-3xl"></div>
                    
                    <div class="relative z-10">
                        <div class="w-24 h-24 bg-gradient-to-br from-yellow-400 to-orange-500 rounded-3xl flex items-center justify-center mx-auto mb-8 shadow-2xl rotate-3">
                            <svg class="w-12 h-12 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path>
                            </svg>
                        </div>

                        <h4 class="text-3xl font-black text-slate-900 mb-4 tracking-tight">Kunci Jawaban & Pembahasan Terkunci! 🔒</h4>
                        <p class="text-slate-500 mb-10 max-w-lg mx-auto leading-relaxed text-lg">
                            Maaf, modul <span class="font-bold text-slate-700">Pembahasan Lengkap</span> hanya tersedia untuk pengguna <span class="font-bold text-blue-600">Premium</span>. Dapatkan akses penuh untuk melihat strategi menjawab dan kunci jawaban original kami.
                        </p>


                        <div class="flex flex-col sm:flex-row gap-4 justify-center">
                            <a href="{{ route('register') }}" class="px-12 py-5 bg-gradient-to-r from-blue-600 to-indigo-700 hover:from-blue-700 hover:to-indigo-800 text-white rounded-2xl font-black shadow-2xl shadow-blue-500/30 transition-all hover:scale-105">
                                UPGRADE SEKARANG (Diskon 30%)
                            </a>
                            <button wire:click="toggleReview" class="px-8 py-5 bg-white border-2 border-slate-200 text-slate-500 rounded-2xl font-bold hover:bg-slate-50 transition-all">
                                Nanti Saja
                            </button>
                        </div>
                    </div>
                </div>

                <div class="text-center py-12 opacity-5 scale-95 select-none pointer-events-none grayscale blur-sm">
                    @foreach(array_slice($reviewData, 0, 1) as $q)
                        <div class="bg-gray-200 p-8 rounded-3xl mb-4"></div>
                        <div class="bg-gray-200 p-4 rounded-xl w-3/4 mx-auto mb-2"></div>
                        <div class="bg-gray-200 p-4 rounded-xl w-1/2 mx-auto"></div>
                    @endforeach
                </div>
            @endif
        </div>
    </div>
</div>
