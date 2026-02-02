<div class="flex flex-col min-h-screen" x-data="{ showSubmitModal: false }">
    {{-- Header --}}
    <header class="sticky top-0 z-50 bg-white border-b shadow-sm">
        <div class="flex items-center justify-between px-4 py-3 mx-auto max-w-7xl">
            {{-- Package Info --}}
            <div>
                <h1 class="text-lg font-semibold text-gray-800">{{ $package->name }}</h1>
                <p class="text-sm text-gray-500">{{ $navigation['answered_count'] ?? 0 }}/{{ $totalQuestions }} soal terjawab</p>
            </div>

            {{-- Timer --}}
            <div class="flex items-center gap-4">
                <div
                    class="flex items-center gap-2 px-4 py-2 font-mono text-lg rounded-lg"
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
                    class="flex items-center gap-2 px-4 py-2 font-medium text-white bg-green-600 rounded-lg hover:bg-green-700"
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
        <aside class="hidden w-64 p-4 overflow-y-auto bg-white border-r lg:block">
            @foreach($navigation['categories'] ?? [] as $category)
                <div class="mb-4">
                    <h3 class="mb-2 font-semibold text-gray-700">{{ $category['name'] }}</h3>
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

            <div class="pt-4 mt-4 text-sm text-gray-600 border-t">
                <div class="flex items-center gap-2 mb-2">
                    <span class="w-4 h-4 bg-green-500 rounded"></span>
                    <span>Sudah dijawab</span>
                </div>
                <div class="flex items-center gap-2 mb-2">
                    <span class="w-4 h-4 bg-gray-200 rounded"></span>
                    <span>Belum dijawab</span>
                </div>
                <div class="flex items-center gap-2">
                    <span class="w-4 h-4 bg-gray-200 border-2 border-orange-400 rounded"></span>
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
                            <span class="px-3 py-1 text-sm font-medium text-blue-700 bg-blue-100 rounded-full">
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
                    <div id="question-content" class="p-6 mb-6 bg-white shadow-sm select-none rounded-xl" oncopy="return false" oncut="return false" onpaste="return false" oncontextmenu="return false">
                        <p class="text-lg leading-relaxed text-gray-800">
                            {!! nl2br(e($currentQuestion['question_text'])) !!}
                        </p>
                        @if($currentQuestion['question_image'])
                            <img src="{{ asset('storage/' . $currentQuestion['question_image']) }}"
                                alt="Question image"
                                class="max-w-full mt-4 rounded-lg">
                        @endif
                    </div>

                    {{-- Options --}}
                    <div class="space-y-3" x-data="{ selected: {{ $currentQuestion['selected_option_id'] ?? 'null' }} }">
                        @foreach($currentQuestion['options'] as $option)
                            <button
                                wire:click="selectAnswer({{ $option['id'] }})"
                                @click="selected = {{ $option['id'] }}"
                                wire:key="option-{{ $option['id'] }}"
                                class="w-full p-4 text-left transition-all duration-200 border-2 rounded-xl"
                                :class="selected == {{ $option['id'] }}
                                    ? 'border-blue-500 bg-blue-50'
                                    : 'border-gray-200 hover:border-blue-300 bg-white'"
                            >
                                <div class="flex items-start gap-3">
                                    {{-- Answer Label --}}
                                    <div class="relative flex-shrink-0 w-8 h-8">
                                        <div class="flex items-center justify-center w-full h-full font-medium transition-colors rounded-full"
                                            :class="selected == {{ $option['id'] }}
                                                ? 'bg-blue-500 text-white'
                                                : 'bg-gray-200 text-gray-700'"
                                        >
                                            {{ $option['label'] }}
                                        </div>
                                    </div>

                                    <span class="pt-1 text-gray-800">{{ $option['text'] }}</span>
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
                            class="flex items-center gap-2 px-6 py-3 text-gray-700 transition-colors bg-gray-200 rounded-lg hover:bg-gray-300 disabled:opacity-50 disabled:cursor-not-allowed"
                        >
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path>
                            </svg>
                            <span>Sebelumnya</span>
                        </button>

                        @if($currentQuestionIndex == $totalQuestions - 1)
                            <button
                                @click="showSubmitModal = true"
                                class="flex items-center gap-2 px-6 py-3 text-white transition-colors bg-green-600 rounded-lg shadow-lg hover:bg-green-700 hover:shadow-xl"
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
                                class="flex items-center gap-2 px-6 py-3 text-white transition-colors bg-blue-600 rounded-lg shadow-md hover:bg-blue-700 hover:shadow-lg"
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

    <div id="exam-block-overlay" style="display:none" class="fixed inset-0 z-50 flex items-center justify-center p-6 text-center bg-white">
        <div class="max-w-lg p-6 bg-white rounded-lg shadow-lg">
            <h3 class="mb-2 text-lg font-semibold">Perhatian — Mode Ujian</h3>
            <p class="mb-4 text-gray-700">Tampilan ujian harus dalam mode layar penuh dan aktif. Jika Anda keluar dari ujian, soal akan disembunyikan.</p>
            <div class="flex justify-center gap-2">
                <button id="enter-fullscreen-btn" class="px-4 py-2 text-white bg-blue-500 rounded-lg bg-s">Masuk Fullscreen</button>
                <button id="request-return-btn" class="px-4 py-2 bg-gray-200 rounded-lg ">Saya Kembali</button>
            </div>
            <p class="mt-4 text-xs text-gray-500">Jika Anda sering berpindah aplikasi, pengawas akan diberitahu dan test dapat diblokir.</p>
        </div>
    </div>

    {{-- Warning Modal --}}
    @if($showWarning)
        <div class="fixed inset-0 z-50 flex items-center justify-center bg-black/50">
            <div class="max-w-md p-6 mx-4 bg-white rounded-xl">
                <div class="flex items-center gap-3 mb-4">
                    <svg class="w-8 h-8 text-yellow-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path>
                    </svg>
                    <h3 class="text-lg font-semibold">Peringatan</h3>
                </div>
                <p class="mb-4 text-gray-600">{{ $warningMessage }}</p>
                <button
                    wire:click="dismissWarning"
                    class="w-full py-2 text-white bg-blue-600 rounded-lg hover:bg-blue-700"
                >
                    Mengerti
                </button>
            </div>
        </div>
    @endif

    {{-- Submit Confirmation Modal --}}
    <div x-show="showSubmitModal" x-cloak class="fixed inset-0 z-50 flex items-center justify-center bg-black/50">
        <div class="max-w-md p-6 mx-4 bg-white rounded-xl">
            <h3 class="mb-2 text-lg font-semibold">Konfirmasi Pengumpulan</h3>
            <p class="mb-4 text-gray-600">
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
                    class="flex-1 py-2 text-gray-700 bg-gray-200 rounded-lg hover:bg-gray-300"
                >
                    Batal
                </button>
                <button
                    wire:click="submitTest"
                    class="flex-1 py-2 text-white bg-green-600 rounded-lg hover:bg-green-700"
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

    <script>
        (function () {
            const overlay = document.getElementById('exam-block-overlay');
            const enterBtn = document.getElementById('enter-fullscreen-btn');
            const returnBtn = document.getElementById('request-return-btn');
            const questionContent = document.getElementById('question-content');

            function blockExam(reason) {
                overlay.style.display = 'flex';
                document.documentElement.requestFullscreen?.();
                document.addEventListener('copy', preventCopy);
                document.addEventListener('cut', preventCopy);
                document.addEventListener('contextmenu', preventContext);
                if (questionContent) questionContent.classList.add('opacity-0');
                if (typeof Livewire !== 'undefined' && Livewire.emit) {
                    Livewire.emit('recordTabSwitch');
                }
            }

            function unblockExam() {
                overlay.style.display = 'none';
                document.removeEventListener('copy', preventCopy);
                document.removeEventListener('cut', preventCopy);
                document.removeEventListener('contextmenu', preventContext);
                if (questionContent) questionContent.classList.remove('opacity-0');
            }

            function preventCopy(e) { e.preventDefault(); }
            function preventContext(e) { e.preventDefault(); }

            function checkCompliance() {
                const isFullscreen = !!(document.fullscreenElement || document.webkitFullscreenElement || document.mozFullScreenElement);
                const tooSmall = window.innerWidth < 1024 || window.innerHeight < 600;
                if (!isFullscreen || tooSmall) {
                    blockExam('not-compliant');
                } else {
                    unblockExam();
                }
            }

            document.addEventListener('visibilitychange', function () {
                if (document.hidden) blockExam('hidden');
            });

            window.addEventListener('blur', function () {
                blockExam('blur');
            });

            window.addEventListener('focus', function () {
                checkCompliance();
            });

            document.addEventListener('fullscreenchange', checkCompliance);
            window.addEventListener('resize', checkCompliance);

            enterBtn?.addEventListener('click', function () {
                (document.documentElement.requestFullscreen || document.documentElement.webkitRequestFullscreen || document.documentElement.mozRequestFullScreen)?.call(document.documentElement).then(() => {
                    setTimeout(checkCompliance, 300);
                }).catch(() => {
                    checkCompliance();
                });
            });

            returnBtn?.addEventListener('click', function () {
                checkCompliance();
            });

            document.addEventListener('livewire:load', function () {
                checkCompliance();
            });

            document.addEventListener('selectstart', function (e) { e.preventDefault(); });
            document.addEventListener('dragstart', function (e) { e.preventDefault(); });

        })();
    </script>
</div>
