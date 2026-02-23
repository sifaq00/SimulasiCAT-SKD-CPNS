<div class="flex flex-col min-h-screen" x-data="{ showSubmitModal: false, showMobileMenu: false }">
    {{-- Header --}}
    <header class="sticky top-0 z-50 bg-white border-b shadow-sm">
        <div class="flex flex-col sm:flex-row items-start sm:items-center justify-between px-3 sm:px-4 py-3 mx-auto max-w-7xl gap-3">
            {{-- Package Info & Mobile Toggle --}}
            <div class="flex items-center gap-3 min-w-0">
                <button
                    @click="showMobileMenu = true"
                    class="p-2 -ml-2 text-gray-600 rounded-lg lg:hidden hover:bg-gray-100"
                >
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path>
                    </svg>
                </button>
                <div class="min-w-0">
                    <h1 class="text-base sm:text-lg font-semibold text-gray-800 truncate">{{ $package->name }} <span class="text-xs font-normal text-blue-500 ml-2 px-2 py-0.5 bg-blue-50 rounded-full border border-blue-100 italic">Gratis</span></h1>
                    <p class="text-xs sm:text-sm text-gray-500">{{ $navigation['answered_count'] ?? 0 }}/{{ $totalQuestions }} soal terjawab</p>
                </div>
            </div>

            {{-- Timer --}}
            <div class="flex flex-row items-center gap-2 w-full sm:w-auto">
                <div
                    class="flex items-center justify-center gap-2 px-3 sm:px-4 py-2 font-mono text-base sm:text-lg rounded-lg"
                    x-data="timer({{ $remainingTime }})"
                    :class="minutes < 10 ? 'bg-red-100 text-red-700' : 'bg-blue-100 text-blue-700'"
                >
                    <svg class="w-4 h-4 sm:w-5 sm:h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                    <span x-text="display"></span>
                </div>

                <button
                    @click="showSubmitModal = true"
                    class="flex items-center justify-center gap-2 px-3 sm:px-4 py-2 font-medium text-sm sm:text-base text-white bg-green-600 rounded-lg hover:bg-green-700"
                >
                    <svg class="w-4 h-4 sm:w-5 sm:h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                    </svg>
                    Selesai
                </button>
            </div>
        </div>
    </header>


    {{-- Mobile Navigation Drawer --}}
    <div
        x-show="showMobileMenu"
        class="fixed inset-0 z-40 lg:hidden"
        style="z-index: 40;"
        role="dialog"
        aria-modal="true"
    >
        {{-- Backdrop --}}
        <div
            x-show="showMobileMenu"
            x-transition:enter="transition-opacity ease-linear duration-300"
            x-transition:enter-start="opacity-0"
            x-transition:enter-end="opacity-100"
            x-transition:leave="transition-opacity ease-linear duration-300"
            x-transition:leave-start="opacity-100"
            x-transition:leave-end="opacity-0"
            class="fixed inset-0 bg-black/50 backdrop-blur-sm"
            @click="showMobileMenu = false"
        ></div>

        {{-- Drawer Panel --}}
        <div
            x-show="showMobileMenu"
            x-transition:enter="transition ease-in-out duration-300 transform"
            x-transition:enter-start="-translate-x-full"
            x-transition:enter-end="translate-x-0"
            x-transition:leave="transition ease-in-out duration-300 transform"
            x-transition:leave-start="translate-x-0"
            x-transition:leave-end="-translate-x-full"
            class="relative flex flex-col w-full max-w-xs h-full bg-white shadow-xl"
        >
            {{-- Drawer Header --}}
            <div class="flex items-center justify-between px-4 py-3 border-b">
                <h2 class="text-lg font-semibold text-gray-800">Daftar Soal</h2>
                <button @click="showMobileMenu = false" class="p-2 -mr-2 text-gray-600 rounded-lg hover:bg-gray-100">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                    </svg>
                </button>
            </div>

            {{-- Drawer Content (Copied from Sidebar) --}}
            <div class="flex-1 px-4 py-4 overflow-y-auto">
                @foreach($navigation['categories'] ?? [] as $category)
                    <div class="mb-6" wire:key="mobile-category-{{ Str::slug($category['name']) }}">
                        <h3 class="mb-3 font-semibold text-gray-700 border-b pb-1">{{ $category['name'] }}</h3>
                        <div class="grid grid-cols-5 gap-2">
                            @foreach($category['questions'] as $q)
                                <button
                                    wire:click="goToQuestion({{ $q['number'] - 1 }}); showMobileMenu = false;"
                                    wire:key="mobile-nav-btn-{{ $q['question_id'] }}"
                                    class="h-10 rounded-lg text-sm font-bold flex items-center justify-center transition-colors shadow-sm
                                        {{ $currentQuestionIndex == ($q['number'] - 1) ? 'ring-2 ring-blue-500 ring-offset-1' : '' }}
                                        {{ $q['is_answered'] ? 'bg-green-500 text-white shadow-green-200' : 'bg-gray-100 text-gray-700 hover:bg-gray-200' }}
                                        {{ $q['is_bookmarked'] ? 'border-2 border-orange-400' : '' }}"
                                >
                                    {{ $q['number'] }}
                                </button>
                            @endforeach
                        </div>
                    </div>
                @endforeach
                
                <div class="pt-4 mt-6 text-sm text-gray-600 border-t">
                    <div class="grid grid-cols-2 gap-3">
                        <div class="flex items-center gap-2">
                            <span class="w-4 h-4 bg-green-500 rounded"></span>
                            <span>Sudah dijawab</span>
                        </div>
                        <div class="flex items-center gap-2">
                            <span class="w-4 h-4 bg-gray-200 rounded"></span>
                            <span>Belum dijawab</span>
                        </div>
                        <div class="flex items-center gap-2">
                            <span class="w-4 h-4 bg-gray-200 border-2 border-orange-400 rounded"></span>
                            <span>Ragu-ragu</span>
                        </div>
                        <div class="flex items-center gap-2">
                            <span class="w-4 h-4 bg-transparent border-2 border-blue-500 rounded"></span>
                            <span>Posisi Sekarang</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

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
                                class="w-8 h-8 rounded text-sm font-medium transition-all
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
                            <span class="text-gray-500">Soal {{ $currentQuestionIndex + 1 }} dari {{ $totalQuestions }}</span>
                        </div>
                        <button
                            wire:click="toggleBookmark"
                            class="flex items-center gap-1 px-3 py-1 rounded-full text-sm transition-colors
                                {{ $currentQuestion['is_bookmarked'] ? 'bg-orange-100 text-orange-700' : 'bg-gray-100 text-gray-600' }}"
                        >
                            <svg class="w-4 h-4" fill="{{ $currentQuestion['is_bookmarked'] ? 'currentColor' : 'none' }}" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 5a2 2 0 012-2h10a2 2 0 012 2v16l-7-3.5L5 21V5z"></path>
                            </svg>
                            {{ $currentQuestion['is_bookmarked'] ? 'Ditandai' : 'Tandai' }}
                        </button>
                    </div>

                    {{-- Question Text --}}
                    <div id="question-content" class="p-6 mb-6 bg-white shadow-sm select-none rounded-xl">
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
                    <div class="space-y-3" 
                         x-data="{ selected: {{ $currentQuestion['selected_option_id'] ?? 'null' }} }"
                         wire:ignore.self>
                        @foreach($currentQuestion['options'] as $option)
                            <button
                                wire:click="selectAnswer({{ $option['id'] }})"
                                @click="selected = {{ $option['id'] }}"
                                wire:key="option-{{ $option['id'] }}"
                                class="w-full p-4 text-left transition-all duration-200 border-2 rounded-xl group"
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
                                                : 'bg-gray-200 text-gray-700 group-hover:bg-blue-100 group-hover:text-blue-600'"
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

    {{-- Submit Confirmation Modal --}}
    <div x-show="showSubmitModal" x-cloak class="fixed inset-0 z-[9999] flex items-center justify-center bg-black/50 backdrop-blur-sm" style="z-index: 9999;">
        <div class="max-w-md p-6 mx-4 bg-white rounded-2xl shadow-2xl relative z-[10000]" style="z-index: 10000;">
            <h3 class="mb-2 text-xl font-bold text-gray-900 line-clamp-1">Konfirmasi Selesai Latihan</h3>
            <p class="mb-6 text-gray-600 leading-relaxed">
                Apakah Anda sudah yakin ingin menyelesaikan pengerjaan soal latihan gratis ini? <br><br>
                Progress: <span class="font-bold text-blue-600">{{ $navigation['answered_count'] ?? 0 }}</span> dari {{ $totalQuestions }} soal sudah dijawab.
            </p>
            <div class="flex gap-3">
                <button
                    @click="showSubmitModal = false"
                    class="flex-1 py-3 font-semibold text-gray-700 transition-colors bg-gray-100 rounded-xl hover:bg-gray-200"
                >
                    Nanti Dulu
                </button>
                <button
                    wire:click="submitTest"
                    class="flex-1 py-3 font-semibold text-white transition-colors bg-green-600 rounded-xl hover:bg-green-700 shadow-lg shadow-green-200"
                >
                    Ya, Selesai
                </button>
            </div>
        </div>
    </div>

    <style>
        [x-cloak] { display: none !important; }
    </style>
</div>

