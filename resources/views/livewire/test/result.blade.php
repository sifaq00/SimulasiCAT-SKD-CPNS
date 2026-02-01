<div class="py-12">
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
        {{-- Result Header --}}
        <div class="bg-white rounded-2xl shadow-lg overflow-hidden mb-8">
            <div class="p-8 text-center {{ $result['passed_overall'] ? 'bg-gradient-to-r from-green-500 to-emerald-600' : 'bg-gradient-to-r from-red-500 to-rose-600' }}">
                <div class="mb-4">
                    @if($result['passed_overall'])
                        <svg class="w-20 h-20 mx-auto text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                    @else
                        <svg class="w-20 h-20 mx-auto text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                    @endif
                </div>
                <h1 class="text-3xl font-bold text-white mb-2">
                    {{ $result['passed_overall'] ? 'Selamat! Anda LULUS' : 'Maaf, Anda TIDAK LULUS' }}
                </h1>
                <p class="text-white/80">{{ $result['package'] }}</p>
            </div>

            {{-- Total Score --}}
            <div class="p-6 text-center border-b">
                <p class="text-gray-500 mb-1">Total Skor</p>
                <p class="text-5xl font-bold text-gray-800">{{ $result['total_score'] }}</p>
                <p class="text-gray-500">dari {{ $result['max_total_score'] }}</p>
            </div>

            {{-- Category Scores --}}
            <div class="grid grid-cols-3 divide-x">
                @foreach(['twk', 'tiu', 'tkp'] as $category)
                    @php $score = $result['scores'][$category]; @endphp
                    <div class="p-6 text-center">
                        <p class="text-sm text-gray-500 mb-1">{{ strtoupper($category) }}</p>
                        <p class="text-3xl font-bold {{ $score['passed'] ? 'text-green-600' : 'text-red-600' }}">
                            {{ $score['score'] }}
                        </p>
                        <p class="text-sm text-gray-500">
                            PG: {{ $score['passing_grade'] }} | Max: {{ $score['max_score'] }}
                        </p>
                        <span class="inline-block mt-2 px-2 py-1 rounded-full text-xs font-medium
                            {{ $score['passed'] ? 'bg-green-100 text-green-700' : 'bg-red-100 text-red-700' }}">
                            {{ $score['passed'] ? 'LULUS' : 'TIDAK LULUS' }}
                        </span>
                    </div>
                @endforeach
            </div>
        </div>

        {{-- Additional Info --}}
        <div class="bg-white rounded-xl shadow-sm p-6 mb-8">
            <h2 class="font-semibold text-gray-800 mb-4">Informasi Ujian</h2>
            <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
                <div>
                    <p class="text-sm text-gray-500">Waktu Mulai</p>
                    <p class="font-medium">{{ $result['started_at'] }}</p>
                </div>
                <div>
                    <p class="text-sm text-gray-500">Waktu Selesai</p>
                    <p class="font-medium">{{ $result['finished_at'] ?? '-' }}</p>
                </div>
                <div>
                    <p class="text-sm text-gray-500">Durasi</p>
                    <p class="font-medium">{{ $result['duration_minutes'] ?? '-' }} menit</p>
                </div>
                <div>
                    <p class="text-sm text-gray-500">Tab Switch</p>
                    <p class="font-medium {{ $result['tab_switch_count'] > 0 ? 'text-red-600' : '' }}">
                        {{ $result['tab_switch_count'] }}x
                    </p>
                </div>
            </div>
        </div>

        {{-- Actions --}}
        <div class="flex flex-col sm:flex-row gap-4 justify-center">
            <button 
                wire:click="toggleReview"
                class="px-6 py-3 bg-blue-600 text-white rounded-lg hover:bg-blue-700 font-medium flex items-center justify-center gap-2"
            >
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                </svg>
                {{ $showReview ? 'Sembunyikan Pembahasan' : 'Lihat Pembahasan' }}
            </button>
            
            <a 
                href="{{ route('dashboard') }}"
                class="px-6 py-3 bg-gray-200 text-gray-700 rounded-lg hover:bg-gray-300 font-medium flex items-center justify-center gap-2"
            >
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"></path>
                </svg>
                Kembali ke Dashboard
            </a>
        </div>

        {{-- Review Section --}}
        @if($showReview && !empty($reviewData))
            <div class="mt-8">
                <h2 class="text-xl font-bold text-gray-800 mb-4">Pembahasan Soal</h2>
                
                <div class="space-y-6">
                    @foreach($reviewData as $item)
                        <div class="bg-white rounded-xl shadow-sm overflow-hidden">
                            {{-- Question --}}
                            <div class="p-4 border-b">
                                <div class="flex items-center gap-2 mb-2">
                                    <span class="px-2 py-1 bg-blue-100 text-blue-700 rounded text-sm font-medium">
                                        {{ $item['category'] }}
                                    </span>
                                    <span class="text-gray-500">Soal {{ $item['number'] }}</span>
                                    @if($item['is_correct'])
                                        <span class="ml-auto px-2 py-1 bg-green-100 text-green-700 rounded-full text-xs font-medium">
                                            +{{ $item['points_earned'] }} poin
                                        </span>
                                    @else
                                        <span class="ml-auto px-2 py-1 bg-red-100 text-red-700 rounded-full text-xs font-medium">
                                            +{{ $item['points_earned'] }} poin
                                        </span>
                                    @endif
                                </div>
                                <p class="text-gray-800">{!! nl2br(e($item['question_text'])) !!}</p>
                            </div>

                            {{-- Options --}}
                            <div class="p-4 bg-gray-50">
                                <div class="space-y-2">
                                    @foreach($item['options'] as $option)
                                        @php
                                            $isSelected = ($item['selected_option_id'] == $option['id']);
                                            $isCorrectHighlight = $option['is_correct'];
                                            $isWrongHighlight = $isSelected && !$isCorrectHighlight && $item['category'] !== 'TKP';
                                            
                                            // Special logic for TKP visuals: 
                                            // If selected and not 5 points, show subtle indicator but not "Wrong"
                                            if ($item['category'] === 'TKP' && $isSelected && $option['points'] < 5) {
                                                $isWrongHighlight = false;
                                            }
                                        @endphp
                                        <div class="flex items-start gap-2 p-2 rounded transition-colors
                                            {{ $isCorrectHighlight ? 'bg-green-100 border border-green-200' : ($isWrongHighlight ? 'bg-red-100 border border-red-200' : 'border border-transparent') }}">
                                            <span class="flex-shrink-0 w-6 h-6 rounded-full flex items-center justify-center text-sm font-bold
                                                {{ $isCorrectHighlight ? 'bg-green-500 text-white' : ($isWrongHighlight ? 'bg-red-500 text-white' : 'bg-gray-200 text-gray-700') }}">
                                                {{ $option['label'] }}
                                            </span>
                                            <div class="flex-1">
                                                <div class="flex items-center gap-2">
                                                    <span class="text-sm {{ $isCorrectHighlight ? 'text-green-800 font-medium' : ($isWrongHighlight ? 'text-red-800' : 'text-gray-700') }}">
                                                        {{ $option['text'] }}
                                                    </span>
                                                    @if($isSelected)
                                                        <span class="px-1.5 py-0.5 bg-blue-100 text-blue-700 text-[10px] font-bold rounded uppercase">Jawaban Anda</span>
                                                    @endif
                                                </div>
                                                @if($item['category'] == 'TKP')
                                                    <span class="text-[10px] text-gray-500">{{ $option['points'] }} poin</span>
                                                @endif
                                            </div>
                                            @if($isCorrectHighlight)
                                                <svg class="w-4 h-4 text-green-600 self-center" fill="currentColor" viewBox="0 0 20 20">
                                                    <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"></path>
                                                </svg>
                                            @endif
                                        </div>
                                    @endforeach
                                </div>
                            </div>

                            {{-- Explanation --}}
                            @if($item['explanation'])
                                <div class="p-4 border-t bg-blue-50">
                                    <p class="text-sm font-medium text-blue-700 mb-1">Pembahasan:</p>
                                    <p class="text-sm text-gray-700">{!! nl2br(e($item['explanation'])) !!}</p>
                                </div>
                            @endif
                        </div>
                    @endforeach
                </div>
            </div>
        @endif
    </div>
</div>
