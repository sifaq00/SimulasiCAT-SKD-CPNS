<div class="min-h-screen flex flex-col" x-data="{ showSubmitModal: false }">
    {{-- Header --}}
    <header class="bg-white shadow-sm border-b sticky top-0 z-50">
        <div class="max-w-7xl mx-auto px-4 py-3 flex items-center justify-between">
            {{-- Package Info --}}
            <div>
                <h1 class="text-lg font-semibold text-gray-800">{{ $package->name }}</h1>
                <p class="text-sm text-gray-500">{{ $navigation['answered_count'] ?? 0 }}/{{ $totalQuestions }} soal terjawab</p>
            </div>

            {{-- Timer --}}
            <div class="flex items-center gap-4">
                <div 
                    class="flex items-center gap-2 px-4 py-2 rounded-lg font-mono text-lg"
                    x-data="timer({{ $remainingTime }})"
                    :class="minutes < 10 ? 'bg-red-100 text-red-700' : 'bg-blue-100 text-blue-700'"
                >
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                    <span x-text="display"></span>
                </div>

                <button 
                    @click="showSubmitModal = true"
                    class="px-4 py-2 bg-green-600 text-white rounded-lg hover:bg-green-700 font-medium flex items-center gap-2"
                >
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                    </svg>
                    Selesai
                </button>
            </div>
        </div>
    </header>

    <div class="flex flex-1">
        {{-- Sidebar Navigation --}}
        <aside class="w-64 bg-white border-r p-4 hidden lg:block overflow-y-auto">
            @foreach($navigation['categories'] ?? [] as $category)
                <div class="mb-4">
                    <h3 class="font-semibold text-gray-700 mb-2">{{ $category['name'] }}</h3>
                    <div class="grid grid-cols-5 gap-1">
                        @foreach($category['questions'] as $q)
                            <button 
                                wire:click="goToQuestion({{ $q['number'] - 1 }})"
                                class="w-8 h-8 rounded text-sm font-medium 
                                    {{ $currentQuestionIndex == ($q['number'] - 1) ? 'ring-2 ring-blue-500' : '' }}
                                    {{ $q['is_answered'] ? 'bg-green-500 text-white' : 'bg-gray-200 text-gray-700' }}
                                    {{ $q['is_bookmarked'] ? 'border-2 border-orange-400' : '' }}"
                            >
                                {{ $q['number'] }}
                            </button>
                        @endforeach
                    </div>
                </div>
            @endforeach

            <div class="mt-4 pt-4 border-t text-sm text-gray-600">
                <div class="flex items-center gap-2 mb-2">
                    <span class="w-4 h-4 bg-green-500 rounded"></span>
                    <span>Sudah dijawab</span>
                </div>
                <div class="flex items-center gap-2 mb-2">
                    <span class="w-4 h-4 bg-gray-200 rounded"></span>
                    <span>Belum dijawab</span>
                </div>
                <div class="flex items-center gap-2">
                    <span class="w-4 h-4 bg-gray-200 rounded border-2 border-orange-400"></span>
                    <span>Ditandai ragu</span>
                </div>
            </div>
        </aside>

        {{-- Main Content --}}
        <main class="flex-1 p-6 overflow-y-auto">
            @if($currentQuestion)
                <div class="max-w-3xl mx-auto">
                    {{-- Question Header --}}
                    <div class="flex items-center justify-between mb-4">
                        <div class="flex items-center gap-2">
                            <span class="px-3 py-1 bg-blue-100 text-blue-700 rounded-full text-sm font-medium">
                                {{ $currentQuestion['category'] }}
                            </span>
                            <span class="text-gray-500">Soal {{ $currentQuestion['number'] }} dari {{ $totalQuestions }}</span>
                        </div>
                        <button 
                            wire:click="toggleBookmark"
                            class="flex items-center gap-1 px-3 py-1 rounded-full text-sm
                                {{ $currentQuestion['is_bookmarked'] ? 'bg-orange-100 text-orange-700' : 'bg-gray-100 text-gray-600' }}"
                        >
                            <svg class="w-4 h-4" fill="{{ $currentQuestion['is_bookmarked'] ? 'currentColor' : 'none' }}" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 5a2 2 0 012-2h10a2 2 0 012 2v16l-7-3.5L5 21V5z"></path>
                            </svg>
                            {{ $currentQuestion['is_bookmarked'] ? 'Ditandai' : 'Tandai' }}
                        </button>
                    </div>

                    {{-- Question Text --}}
                    <div class="bg-white rounded-xl shadow-sm p-6 mb-6">
                        <p class="text-gray-800 text-lg leading-relaxed">
                            {!! nl2br(e($currentQuestion['question_text'])) !!}
                        </p>
                        @if($currentQuestion['question_image'])
                            <img src="{{ asset('storage/' . $currentQuestion['question_image']) }}" 
                                alt="Question image" 
                                class="mt-4 max-w-full rounded-lg">
                        @endif
                    </div>

                    {{-- Options --}}
                    <div class="space-y-3" x-data="{ selected: {{ $currentQuestion['selected_option_id'] ?? 'null' }} }">
                        @foreach($currentQuestion['options'] as $option)
                            <button 
                                wire:click="selectAnswer({{ $option['id'] }})"
                                @click="selected = {{ $option['id'] }}"
                                wire:key="option-{{ $option['id'] }}"
                                class="w-full text-left p-4 rounded-xl border-2 transition-all duration-200"
                                :class="selected == {{ $option['id'] }} 
                                    ? 'border-blue-500 bg-blue-50' 
                                    : 'border-gray-200 hover:border-blue-300 bg-white'"
                            >
                                <div class="flex items-start gap-3">
                                    {{-- Answer Label --}}
                                    <div class="relative w-8 h-8 flex-shrink-0">
                                        <div class="w-full h-full rounded-full flex items-center justify-center font-medium transition-colors"
                                            :class="selected == {{ $option['id'] }} 
                                                ? 'bg-blue-500 text-white' 
                                                : 'bg-gray-200 text-gray-700'"
                                        >
                                            {{ $option['label'] }}
                                        </div>
                                    </div>
                                    
                                    <span class="text-gray-800 pt-1">{{ $option['text'] }}</span>
                                </div>
                            </button>
                        @endforeach
                    </div>

                    {{-- Navigation Buttons --}}
                    <div class="flex justify-between mt-8">
                        <button 
                            wire:click="previousQuestion"
                            wire:loading.attr="disabled"
                            wire:target="previousQuestion"
                            @if($currentQuestionIndex == 0) disabled @endif
                            class="px-6 py-3 bg-gray-200 text-gray-700 rounded-lg hover:bg-gray-300 disabled:opacity-50 disabled:cursor-not-allowed flex items-center gap-2 transition-colors"
                        >
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path>
                            </svg>
                            <span>Sebelumnya</span>
                        </button>

                        @if($currentQuestionIndex == $totalQuestions - 1)
                            <button 
                                @click="showSubmitModal = true"
                                class="px-6 py-3 bg-green-600 text-white rounded-lg hover:bg-green-700 flex items-center gap-2 transition-colors shadow-lg hover:shadow-xl"
                            >
                                <span>Selesai</span>
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                                </svg>
                            </button>
                        @else
                            <button 
                                wire:click="nextQuestion"
                                wire:target="nextQuestion"
                                class="px-6 py-3 bg-blue-600 text-white rounded-lg hover:bg-blue-700 flex items-center gap-2 transition-colors shadow-md hover:shadow-lg"
                            >
                                <span>Selanjutnya</span>
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                                </svg>
                            </button>
                        @endif
                    </div>
                </div>
            @endif
        </main>
    </div>

    {{-- Warning Modal --}}
    @if($showWarning)
        <div class="fixed inset-0 bg-black/50 flex items-center justify-center z-50">
            <div class="bg-white rounded-xl p-6 max-w-md mx-4">
                <div class="flex items-center gap-3 mb-4">
                    <svg class="w-8 h-8 text-yellow-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path>
                    </svg>
                    <h3 class="text-lg font-semibold">Peringatan</h3>
                </div>
                <p class="text-gray-600 mb-4">{{ $warningMessage }}</p>
                <button 
                    wire:click="dismissWarning"
                    class="w-full py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700"
                >
                    Mengerti
                </button>
            </div>
        </div>
    @endif

    {{-- Submit Confirmation Modal --}}
    <div x-show="showSubmitModal" x-cloak class="fixed inset-0 bg-black/50 flex items-center justify-center z-50">
        <div class="bg-white rounded-xl p-6 max-w-md mx-4">
            <h3 class="text-lg font-semibold mb-2">Konfirmasi Pengumpulan</h3>
            <p class="text-gray-600 mb-4">
                Anda yakin ingin mengumpulkan ujian? 
                <br><br>
                <strong>{{ $navigation['answered_count'] ?? 0 }}</strong> dari <strong>{{ $totalQuestions }}</strong> soal terjawab.
                @if(($navigation['bookmarked_count'] ?? 0) > 0)
                    <br><strong>{{ $navigation['bookmarked_count'] }}</strong> soal ditandai ragu.
                @endif
            </p>
            <div class="flex gap-3">
                <button 
                    @click="showSubmitModal = false"
                    class="flex-1 py-2 bg-gray-200 text-gray-700 rounded-lg hover:bg-gray-300"
                >
                    Batal
                </button>
                <button 
                    wire:click="submitTest"
                    class="flex-1 py-2 bg-green-600 text-white rounded-lg hover:bg-green-700"
                >
                    Ya, Kumpulkan
                </button>
            </div>
        </div>
    </div>

    {{-- Timer Script --}}
    <script>
        function timer(seconds) {
            return {
                remaining: seconds,
                display: '',
                interval: null,
                
                init() {
                    this.updateDisplay();
                    this.interval = setInterval(() => {
                        this.remaining--;
                        this.updateDisplay();
                        
                        if (this.remaining <= 0) {
                            clearInterval(this.interval);
                            Livewire.dispatch('timeExpired');
                        }
                    }, 1000);
                },
                
                get minutes() {
                    return Math.floor(this.remaining / 60);
                },
                
                updateDisplay() {
                    const mins = Math.floor(this.remaining / 60);
                    const secs = this.remaining % 60;
                    this.display = `${String(mins).padStart(2, '0')}:${String(secs).padStart(2, '0')}`;
                }
            }
        }
    </script>
</div>
