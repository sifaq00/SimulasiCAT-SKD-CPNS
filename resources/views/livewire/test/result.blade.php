<div class="py-12 pt-20 md:pt-28 bg-gray-50/50 min-h-screen font-sans">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        {{-- Top Navigation --}}
        <div class="mb-8 flex items-center justify-between">
            <a href="{{ route('dashboard') }}" class="inline-flex items-center gap-2 text-slate-500 hover:text-blue-600 transition-colors font-semibold group">
                <svg class="w-5 h-5 group-hover:-translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                </svg>
                Kembali ke Dashboard
            </a>
            <div class="px-4 py-1.5 bg-blue-50 text-blue-600 rounded-full text-xs font-bold uppercase tracking-widest border border-blue-100">
                Official Result
            </div>
        </div>

        {{-- Success/Failure Banner --}}
        <div class="bg-gradient-to-br {{ $result['passed_overall'] ? 'from-green-600 to-emerald-800' : 'from-red-600 to-rose-800' }} rounded-[2.5rem] p-6 md:p-12 mb-8 md:mb-10 text-white relative overflow-hidden shadow-2xl">
            {{-- Decoration --}}
            <div class="absolute -right-20 -top-20 w-80 h-80 bg-white/10 rounded-full blur-3xl"></div>
            <div class="absolute -left-20 -bottom-20 w-80 h-80 {{ $result['passed_overall'] ? 'bg-emerald-400/20' : 'bg-rose-400/20' }} rounded-full blur-3xl"></div>
            
            <div class="relative z-10 flex flex-col items-center text-center">
                <div class="w-20 h-20 md:w-24 md:h-24 bg-white/15 backdrop-blur-md rounded-3xl flex items-center justify-center mb-6 md:mb-8 shadow-xl border border-white/20 rotate-3">
                    @if($result['passed_overall'])
                        <svg class="w-10 h-10 md:w-12 md:h-12 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                    @else
                        <svg class="w-10 h-10 md:w-12 md:h-12 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                    @endif
                </div>
                
                <h1 class="text-2xl md:text-5xl font-black mb-4 tracking-tighter uppercase font-outfit leading-tight">
                    {{ $result['passed_overall'] ? 'Selamat! Anda LULUS' : 'Maaf, Anda TIDAK LULUS' }}
                </h1>
                <p class="text-white/80 text-base md:text-lg mb-8 md:mb-10 max-w-xl font-medium">
                    Hasil ujian simulasi {{ $result['package'] }} Anda telah dianalisis.
                </p>

                <div class="flex flex-wrap justify-center gap-4 md:gap-6">
                    <div class="px-6 py-3 md:px-8 md:py-4 bg-white/15 backdrop-blur-md rounded-3xl border border-white/10">
                        <span class="block text-white/70 text-[10px] font-black uppercase tracking-widest mb-1">Total Skor</span>
                        <span class="text-4xl md:text-5xl font-black font-outfit">{{ $result['total_score'] }}</span>
                        <span class="text-xs md:text-sm text-white/50 ml-1">/ {{ $result['max_total_score'] }}</span>
                    </div>
                    <div class="px-6 py-3 md:px-8 md:py-4 bg-white/15 backdrop-blur-md rounded-3xl border border-white/10 flex flex-col justify-center">
                        <span class="block text-white/70 text-[10px] font-black uppercase tracking-widest mb-1">Status Akhir</span>
                        <span class="text-xl md:text-2xl font-black uppercase tracking-tight font-outfit">
                            {{ $result['passed_overall'] ? 'MEMENUHI PG' : 'TIDAK LULUS PG' }}
                        </span>
                    </div>
                </div>
            </div>
        </div>

        {{-- Bento-style Score Detail Grid --}}
        <div class="grid md:grid-cols-3 gap-4 md:gap-8 mb-8 md:mb-10">
            @foreach(['twk', 'tiu', 'tkp'] as $category)
                @php 
                    $score = $result['scores'][$category]; 
                    $catTitles = [
                        'twk' => 'Tes Wawasan Kebangsaan',
                        'tiu' => 'Tes Intelegensia Umum',
                        'tkp' => 'Tes Karakteristik Pribadi'
                    ];
                @endphp
                <div class="bg-white rounded-[2rem] p-6 md:p-8 border border-gray-100 shadow-sm relative overflow-hidden group hover:shadow-xl transition-all">
                    <div class="relative z-10">
                        <h4 class="text-gray-400 font-black text-[10px] uppercase tracking-widest mb-4">{{ $catTitles[$category] }}</h4>
                        <div class="flex items-end justify-between mb-6">
                            <span class="text-4xl md:text-5xl font-black text-slate-900 font-outfit {{ $score['passed'] ? 'text-green-600' : 'text-red-600' }}">
                                {{ $score['score'] }}
                            </span>
                            <div class="text-right">
                                <span class="block text-[10px] font-black text-slate-400 uppercase tracking-widest">Passing Grade</span>
                                <span class="text-xs md:text-sm font-bold text-slate-800">{{ $score['passing_grade'] }}</span>
                            </div>
                        </div>

                        <div class="w-full bg-gray-100 rounded-full h-3 mb-6 relative overflow-hidden">
                            @php
                                $percentage = ($score['score'] / $score['max_score']) * 100;
                            @endphp
                            <div class="h-3 rounded-full {{ $score['passed'] ? 'bg-green-500' : 'bg-red-500' }} transition-all duration-1000" style="width: {{ min(100, $percentage) }}%"></div>
                        </div>

                        <div class="flex items-center gap-2">
                            @if($score['passed'])
                                <span class="flex-shrink-0 w-6 h-6 bg-green-100 text-green-600 rounded-full flex items-center justify-center">
                                    <svg class="w-4 h-4 shadow-sm" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                                    </svg>
                                </span>
                                <span class="text-[10px] font-black text-green-600 uppercase tracking-wider">Memenuhi PG</span>
                            @else
                                <span class="flex-shrink-0 w-6 h-6 bg-red-100 text-red-600 rounded-full flex items-center justify-center">
                                    <svg class="w-4 h-4 shadow-sm" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                                    </svg>
                                </span>
                                <span class="text-[10px] font-black text-red-600 uppercase tracking-wider">Di Bawah PG</span>
                            @endif
                        </div>
                    </div>
                </div>
            @endforeach
        </div>

        {{-- Exam Info Summary --}}
        <div class="bg-white rounded-[2rem] p-6 md:p-8 mb-8 md:mb-10 border border-gray-100 shadow-sm">
            <h3 class="text-sm font-black text-slate-400 uppercase tracking-widest mb-6 md:mb-8 flex items-center gap-2">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                </svg>
                Informasi Ujian
            </h3>
            <div class="grid grid-cols-2 md:grid-cols-4 gap-6 md:gap-8">
                <div class="flex flex-col gap-1">
                    <span class="text-[10px] font-black text-slate-400 uppercase tracking-widest">Mulai</span>
                    <span class="text-sm font-bold text-slate-800">{{ $result['started_at'] }}</span>
                </div>
                <div class="flex flex-col gap-1">
                    <span class="text-[10px] font-black text-slate-400 uppercase tracking-widest">Selesai</span>
                    <span class="text-sm font-bold text-slate-800">{{ $result['finished_at'] ?? $result['started_at'] }}</span>
                </div>
                <div class="flex flex-col gap-1">
                    <span class="text-[10px] font-black text-slate-400 uppercase tracking-widest">Durasi</span>
                    <span class="text-sm font-bold text-slate-800">{{ $result['duration_minutes'] ?? '-' }} Menit</span>
                </div>
                <div class="flex flex-col gap-1">
                    <span class="text-[10px] font-black text-slate-400 uppercase tracking-widest">Tab Switches</span>
                    <span class="text-sm font-bold {{ $result['tab_switch_count'] > 0 ? 'text-red-500' : 'text-slate-800' }}">
                        {{ $result['tab_switch_count'] }} Pelanggaran
                    </span>
                </div>
            </div>
        </div>

        {{-- Actions --}}
        <div class="flex flex-col sm:flex-row gap-4 justify-center items-center mb-12">
            <button 
                wire:click="toggleReview"
                class="px-10 py-5 {{ $showReview ? 'bg-slate-100 text-slate-600' : 'bg-slate-900 text-white shadow-xl shadow-slate-900/20' }} rounded-2xl font-black transition-all hover:-translate-y-1 flex items-center justify-center gap-3 w-full sm:w-auto"
            >
                @if($showReview)
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29M3 3l18 18"></path>
                    </svg>
                    Sembunyikan Pembahasan
                @else
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01"></path>
                    </svg>
                    Review Pembahasan Lengkap
                @endif
            </button>
            <a 
                href="{{ route('dashboard') }}"
                class="px-10 py-5 bg-white border border-slate-200 text-slate-500 rounded-2xl font-bold hover:bg-slate-50 transition-all flex items-center justify-center gap-2 w-full sm:w-auto"
            >
                Ke Beranda Personal
            </a>
        </div>

        {{-- Review Section --}}
        @if($showReview && !empty($reviewData))
            <div class="mt-12 space-y-8 animate-in fade-in slide-in-from-bottom-5 duration-500">
                <div class="flex items-center justify-between mb-4 px-2">
                    <h2 class="text-2xl font-black text-slate-900 tracking-tight font-outfit uppercase">Analisis Jawaban</h2>
                    <span class="text-xs font-bold text-slate-400 uppercase tracking-widest">{{ count($reviewData) }} Soal Total</span>
                </div>
                
                <div class="grid gap-8">
                    @foreach($reviewData as $item)
                        <div class="bg-white rounded-[2rem] shadow-sm border border-gray-100 overflow-hidden">
                            {{-- Question Header --}}
                            <div class="p-6 md:p-8 border-b bg-gray-50/50">
                                <div class="flex flex-wrap items-center gap-3 mb-6">
                                    <span class="px-3 py-1 bg-blue-600 text-white rounded-lg text-[10px] font-black uppercase tracking-wider">
                                        {{ $item['category'] }}
                                    </span>
                                    <span class="px-3 py-1 bg-slate-100 text-slate-500 rounded-lg text-[10px] font-black uppercase tracking-wider">
                                        Soal #{{ $item['number'] }}
                                    </span>
                                    
                                    @php
                                        $isTkp = $item['category'] === 'TKP';
                                        $statusClass = $item['is_correct'] ? 'bg-green-100 text-green-700' : 'bg-red-100 text-red-700';
                                        if ($isTkp) $statusClass = 'bg-blue-100 text-blue-700';
                                    @endphp
                                    <span class="ml-auto px-4 py-1.5 {{ $statusClass }} rounded-full text-[10px] font-black uppercase tracking-widest flex items-center gap-2">
                                        @if($item['is_correct'])
                                            <svg class="w-3 h-3" fill="currentColor" viewBox="0 0 20 20">
                                                <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"></path>
                                            </svg>
                                        @endif
                                        {{ $isTkp ? '+' . $item['points_earned'] . ' Poin' : ($item['is_correct'] ? 'Benar' : 'Salah') }}
                                    </span>
                                </div>
                                <div class="text-lg text-slate-800 font-medium leading-relaxed">
                                    {!! nl2br(e($item['question_text'])) !!}
                                </div>
                            </div>

                            {{-- Options --}}
                            <div class="p-6 md:p-8 bg-white">
                                <div class="grid gap-4">
                                    @foreach($item['options'] as $option)
                                        @php
                                            $isSelected = ($item['selected_option_id'] == $option['id']);
                                            $isCorrectHighlight = $option['is_correct'];
                                            $isWrongHighlight = $isSelected && !$isCorrectHighlight && !$isTkp;
                                            
                                            $borderClass = 'border-slate-100';
                                            $bgClass = 'bg-white';
                                            if ($isCorrectHighlight) {
                                                $borderClass = 'border-green-500 bg-green-50/30';
                                            } elseif ($isWrongHighlight) {
                                                $borderClass = 'border-red-500 bg-red-50/30';
                                            } elseif ($isSelected) {
                                                $borderClass = 'border-blue-500 bg-blue-50/30';
                                            }
                                        @endphp
                                        <div class="flex items-start gap-4 p-4 rounded-2xl border-2 transition-all {{ $borderClass }} {{ $bgClass }}">
                                            <span class="flex-shrink-0 w-8 h-8 rounded-xl flex items-center justify-center text-sm font-black
                                                {{ $isCorrectHighlight ? 'bg-green-500 text-white' : ($isWrongHighlight ? 'bg-red-500 text-white' : ($isSelected ? 'bg-blue-500 text-white' : 'bg-slate-100 text-slate-500')) }}">
                                                {{ $option['label'] }}
                                            </span>
                                            <div class="flex-1">
                                                <div class="flex flex-wrap items-center gap-2">
                                                    <span class="text-slate-700 font-medium">
                                                        {{ $option['text'] }}
                                                    </span>
                                                    @if($isSelected)
                                                        <span class="px-2 py-0.5 bg-slate-900 text-white text-[8px] font-black rounded uppercase tracking-widest">Pilihan Anda</span>
                                                    @endif
                                                    @if($isCorrectHighlight && !$isTkp)
                                                         <span class="px-2 py-0.5 bg-green-500 text-white text-[8px] font-black rounded uppercase tracking-widest">Jawaban Benar</span>
                                                    @endif
                                                </div>
                                                @if($isTkp)
                                                    <span class="text-[10px] font-black text-blue-500 uppercase tracking-widest mt-1 block">{{ $option['points'] }} POIN</span>
                                                @endif
                                            </div>
                                            @if($isCorrectHighlight || ($isTkp && $option['points'] == 5))
                                                <svg class="w-5 h-5 text-green-500 self-center" fill="currentColor" viewBox="0 0 20 20">
                                                    <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"></path>
                                                </svg>
                                            @endif
                                        </div>
                                    @endforeach
                                </div>
                            </div>

                            {{-- Explanation --}}
                            @if($item['explanation'])
                                <div class="p-6 md:p-8 bg-blue-50/50 border-t border-blue-100">
                                    <div class="flex items-center gap-2 mb-4">
                                        <div class="w-8 h-8 bg-blue-600 text-white rounded-lg flex items-center justify-center">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.663 17h4.673M12 3v1m6.364 1.636l-.707.707M21 12h-1M4 12H3m3.343-5.657l-.707-.707m2.828 9.9a5 5 0 117.072 0l-.548.547A3.374 3.374 0 0014 18.469V19a2 2 0 11-4 0v-.531c0-.895-.356-1.754-.988-2.386l-.548-.547z"></path>
                                            </svg>
                                        </div>
                                        <h5 class="text-sm font-black text-blue-600 uppercase tracking-widest">Pembahasan Strategis</h5>
                                    </div>
                                    <div class="prose prose-sm text-slate-700 max-w-none leading-relaxed">
                                        {!! nl2br(e($item['explanation'])) !!}
                                    </div>
                                </div>
                            @endif
                        </div>
                    @endforeach
                </div>
            </div>
        @endif
    </div>
</div>
