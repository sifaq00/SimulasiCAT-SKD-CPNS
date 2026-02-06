<div>
    @section('title', 'Bank Soal 2.0')

    @if(!$selectedPackage)
        {{-- STEP 1: Package Selection Dashboard --}}
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            @foreach($packages as $pkg)
                <div wire:click="selectPackage({{ $pkg['id'] }})" 
                    class="bg-white rounded-2xl shadow-sm p-6 border border-gray-100 hover:border-blue-500 hover:shadow-md transition-all cursor-pointer group">
                    <div class="flex justify-between items-start mb-4">
                        <div class="p-3 bg-blue-50 text-blue-600 rounded-xl group-hover:bg-blue-600 group-hover:text-white transition-colors">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"></path>
                            </svg>
                        </div>
                        <span class="px-3 py-1 bg-gray-100 text-gray-600 text-xs font-bold rounded-full">{{ $pkg['year'] }}</span>
                    </div>
                    <h3 class="text-xl font-bold text-gray-900 mb-2">{{ $pkg['name'] }}</h3>
                    <p class="text-gray-500 text-sm mb-6 line-clamp-2">{{ $pkg['description'] }}</p>
                    
                    <div class="space-y-3">
                        @php
                            $p = collect($packages)->firstWhere('id', $pkg['id']);
                            $count = $p['questions_count'] ?? 0;
                            $target = $p['total_questions'] ?? 110;
                            $percent = min(100, ($count / $target) * 100);
                        @endphp
                        <div class="flex justify-between text-xs font-semibold">
                            <span class="text-gray-500">Progress Soal</span>
                            <span class="{{ $percent >= 100 ? 'text-green-600' : 'text-blue-600' }}">{{ $count }} / {{ $target }}</span>
                        </div>
                        <div class="w-full bg-gray-100 rounded-full h-2">
                            <div class="h-2 rounded-full {{ $percent >= 100 ? 'bg-green-500' : 'bg-blue-500' }}" style="width: {{ $percent }}%"></div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    @else
        {{-- STEP 2: Main Bank Soal Interface (Side-by-Side) --}}
        <div class="flex flex-col h-[calc(100vh-140px)]">
            {{-- Toolbar --}}
            <div class="flex items-center justify-between bg-white p-4 rounded-t-2xl border-b shadow-sm shrink-0">
                <div class="flex items-center gap-4">
                    <button wire:click="backToPackages" class="p-2 hover:bg-gray-100 rounded-full text-gray-500">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                        </svg>
                    </button>
                    <div>
                        <h2 class="text-lg font-bold text-gray-900 leading-none mb-1">
                            {{ collect($packages)->firstWhere('id', $selectedPackage)['name'] }}
                        </h2>
                        <div class="flex gap-4 text-xs">
                            @foreach($questionCounts as $code => $count)
                                @php $tgt = $code === 'TWK' ? 30 : ($code === 'TIU' ? 35 : 45); @endphp
                                <span class="{{ $count >= $tgt ? 'text-green-600' : 'text-orange-500' }} font-bold">
                                    {{ $code }}: {{ $count }}/{{ $tgt }}
                                </span>
                            @endforeach
                        </div>
                    </div>
                </div>

                <div class="flex gap-3">
                    <div class="relative">
                        <input type="text" wire:model.live.debounce.300ms="search" placeholder="Cari soal..." 
                            class="pl-10 pr-4 py-2 bg-gray-50 border-gray-200 rounded-xl text-sm w-64 focus:bg-white focus:ring-blue-500 transition-all">
                        <svg class="w-4 h-4 text-gray-400 absolute left-3 top-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                        </svg>
                    </div>
                    <div class="flex items-center gap-2 px-3 py-1 bg-blue-50 border border-blue-100 rounded-xl">
                        <input type="file" wire:model="csvFile" id="csvImport" class="hidden">
                        <label for="csvImport" class="cursor-pointer text-[10px] font-black text-blue-600 hover:text-blue-700 uppercase tracking-tighter transition-all">
                            {{ $csvFile ? $csvFile->getClientOriginalName() : 'Pilih CSV' }}
                        </label>
                        <a href="/templates/bank_soal_template.csv" download class="p-1 hover:bg-white rounded transition-colors text-blue-400" title="Unduh Template CSV">
                            <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"></path>
                            </svg>
                        </a>
                        @if($csvFile)
                            <button wire:click="importQuestions" class="p-1.5 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition-all shadow-sm">
                                <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7"></path>
                                </svg>
                            </button>
                        @endif
                    </div>

                    <button wire:click="openCreateForm" class="px-6 py-2 bg-blue-600 text-white rounded-xl hover:bg-blue-700 font-bold flex items-center gap-2 shadow-lg shadow-blue-600/20">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                        </svg>
                        Tambah Manual
                    </button>
                </div>
            </div>

            {{-- Main Grid --}}
            <div class="flex-1 flex overflow-hidden bg-gray-50 border-x">
                {{-- Left: Question List --}}
                <div class="w-2/5 flex flex-col border-r h-full bg-white">
                    <div class="flex-1 overflow-y-auto p-4 space-y-3 custom-scrollbar">
                        @forelse($questions as $q)
                            <div wire:click="editQuestion({{ $q->id }})" 
                                class="p-4 rounded-xl border-2 transition-all cursor-pointer group {{ $editingId == $q->id ? 'border-blue-500 bg-blue-50 shadow-sm' : 'border-transparent bg-gray-50 hover:bg-white hover:border-gray-200' }}">
                                <div class="flex items-center gap-3 mb-2">
                                    <span class="w-8 h-8 flex items-center justify-center rounded-lg {{ $editingId == $q->id ? 'bg-blue-600 text-white' : 'bg-white text-gray-500 border' }} font-bold text-xs ring-4 ring-transparent group-hover:ring-blue-50">
                                        {{ $q->order_number }}
                                    </span>
                                    <span class="px-2 py-0.5 rounded-md bg-white border border-gray-100 text-[10px] font-black uppercase text-blue-600">
                                        {{ $q->category->code }}
                                    </span>
                                    <div class="ml-auto text-gray-400 opacity-0 group-hover:opacity-100 transition-opacity">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                                        </svg>
                                    </div>
                                </div>
                                <p class="text-sm text-gray-700 font-medium line-clamp-2 leading-relaxed">
                                    {{ $q->question_text }}
                                </p>
                            </div>
                        @empty
                            <div class="text-center py-20 text-gray-400">
                                <div class="w-20 h-20 bg-gray-50 rounded-full flex items-center justify-center mx-auto mb-4 border border-dashed border-gray-200">
                                    <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path>
                                    </svg>
                                </div>
                                <p class="font-bold">Hening...</p>
                                <p class="text-xs">Mulai tambahkan soal sekarang.</p>
                            </div>
                        @endforelse
                    </div>
                </div>

                {{-- Right: Question Editor --}}
                <div class="flex-1 overflow-y-auto p-8 custom-scrollbar bg-white">
                    @if($showForm)
                        <div class="max-w-3xl">
                            <div class="flex items-center justify-between mb-8">
                                <h3 class="text-2xl font-black text-gray-900">
                                    {{ $editingId ? 'Edit Soal' : 'Soal Baru' }}
                                    <span class="text-blue-600">#{{ $formData['order_number'] }}</span>
                                </h3>
                                @if($editingId)
                                    <button wire:click="deleteQuestion({{ $editingId }})" 
                                        wire:confirm="Hapus soal ini selamanya?"
                                        class="p-2 text-red-400 hover:text-red-600 hover:bg-red-50 rounded-lg transition-colors">
                                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                                        </svg>
                                    </button>
                                @endif
                            </div>

                            <div class="space-y-8">
                                <div class="grid grid-cols-2 gap-6">
                                    <div>
                                        <label class="block text-[10px] font-black text-gray-400 uppercase tracking-widest mb-1.5">Kategori Materi</label>
                                        <select wire:model.live="formData.category_id" class="w-full rounded-xl border-gray-200 focus:border-blue-500 focus:ring-4 focus:ring-blue-50 font-bold text-gray-700">
                                            <option value="">Pilih Kategori</option>
                                            @foreach($categories as $cat)
                                                <option value="{{ $cat['id'] }}">{{ $cat['name'] }} ({{ $cat['code'] }})</option>
                                            @endforeach
                                        </select>
                                        @error('formData.category_id') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                                    </div>
                                    <div>
                                        <label class="block text-[10px] font-black text-gray-400 uppercase tracking-widest mb-1.5">Urutan Soal</label>
                                        <input type="number" wire:model="formData.order_number" min="1" 
                                            class="w-full rounded-xl border-gray-200 focus:border-blue-500 focus:ring-4 focus:ring-blue-50 font-bold">
                                    </div>
                                </div>

                                {{-- Question Text & Image --}}
                                <div class="space-y-4">
                                    <div>
                                        <label class="block text-[10px] font-black text-gray-400 uppercase tracking-widest mb-1.5">Isi Pertanyaan</label>
                                        <textarea wire:model="formData.question_text" rows="5" 
                                            class="w-full rounded-2xl border-gray-200 focus:border-blue-500 focus:ring-4 focus:ring-blue-50 p-4"
                                            placeholder="Tuliskan soal di sini..."></textarea>
                                        @error('formData.question_text') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                                    </div>

                                    <div class="flex items-center gap-6 p-6 bg-gray-50 rounded-2xl border border-dashed border-gray-200">
                                        <div class="shrink-0">
                                            @if ($imageFile)
                                                <img src="{{ $imageFile->temporaryUrl() }}" class="w-32 h-32 object-cover rounded-xl shadow-lg ring-4 ring-white">
                                            @elseif ($existingImage)
                                                <img src="{{ Storage::url($existingImage) }}" class="w-32 h-32 object-cover rounded-xl shadow-lg ring-4 ring-white">
                                            @else
                                                <div class="w-32 h-32 bg-white rounded-xl flex items-center justify-center text-gray-300 border border-gray-100">
                                                    <svg class="w-10 h-10" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                                    </svg>
                                                </div>
                                            @endif
                                        </div>
                                        <div class="flex-1">
                                            <p class="text-xs font-bold text-gray-500 mb-2">Unggah Gambar (Opsional)</p>
                                            <input type="file" wire:model="imageFile" class="text-xs file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-xs file:font-black file:bg-blue-50 file:text-blue-700 hover:file:bg-blue-100 italic transition-all">
                                            <p class="text-[10px] text-gray-400 mt-2">Maksimal 2MB (JPG/PNG). Gunakan untuk soal grafik/spasial.</p>
                                            @if($imageFile || $existingImage)
                                                <button wire:click="removeImage" class="mt-3 px-3 py-1 bg-red-50 text-red-600 text-[10px] font-black rounded-lg border border-red-100 hover:bg-red-600 hover:text-white transition-all uppercase">
                                                    Hapus Gambar
                                                </button>
                                            @endif
                                        </div>
                                    </div>
                                </div>

                                {{-- Options --}}
                                <div>
                                    <label class="block text-[10px] font-black text-gray-400 uppercase tracking-widest mb-4">Pilihan Jawaban & Poin</label>
                                    <div class="space-y-4">
                                        @php
                                            $selectedCat = collect($categories)->firstWhere('id', $formData['category_id']);
                                            $isTKP = $selectedCat && $selectedCat['code'] === 'TKP';
                                        @endphp
                                        
                                        @foreach($options as $i => $opt)
                                            <div class="flex items-start gap-4 p-4 rounded-xl border border-gray-100 hover:border-gray-300 hover:bg-gray-50 transition-all group/opt">
                                                <span class="w-10 h-10 flex items-center justify-center rounded-xl bg-white border border-gray-100 font-black text-blue-600 shadow-sm transition-all group-hover/opt:scale-110">
                                                    {{ $opt['label'] }}
                                                </span>
                                                <div class="flex-1">
                                                    <input type="text" wire:model="options.{{ $i }}.text" 
                                                        class="w-full rounded-xl border-gray-200 focus:border-blue-500 focus:ring-4 focus:ring-blue-50 text-sm py-2.5 font-medium"
                                                        placeholder="Tulis jawaban...">
                                                    @error("options.{$i}.text") <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                                                </div>
                                                
                                                @if($isTKP)
                                                    <div class="w-20">
                                                        <input type="number" wire:model="options.{{ $i }}.points" 
                                                            min="0" max="5"
                                                            class="w-full rounded-xl border-gray-200 text-sm text-center font-black text-blue-600 focus:ring-blue-50"
                                                            placeholder="Poin">
                                                    </div>
                                                @else
                                                    <button type="button" wire:click="setCorrectOption({{ $i }})"
                                                        class="px-4 py-2.5 rounded-xl text-[10px] font-black uppercase tracking-widest transition-all {{ $opt['is_correct'] ? 'bg-green-500 text-white shadow-lg shadow-green-500/30' : 'bg-white border border-gray-200 text-gray-400 hover:border-green-300 hover:text-green-600' }}">
                                                        {{ $opt['is_correct'] ? 'KUNCI' : 'PILIH' }}
                                                    </button>
                                                @endif
                                            </div>
                                        @endforeach
                                    </div>
                                </div>

                                {{-- Explanation --}}
                                <div>
                                    <label class="block text-[10px] font-black text-gray-400 uppercase tracking-widest mb-1.5">Pembahasan & Penjelasan</label>
                                    <textarea wire:model="formData.explanation" rows="4" 
                                        class="w-full rounded-2xl border-gray-200 focus:border-blue-500 focus:ring-4 focus:ring-blue-50 p-4 text-sm"
                                        placeholder="Jelaskan alasan jawaban tersebut benar..."></textarea>
                                </div>

                                {{-- Action Buttons --}}
                                <div class="flex items-center gap-4 pt-4 sticky bottom-0 bg-white py-6 border-t font-figtree">
                                    <button wire:click="closeForm" class="flex-1 py-4 bg-gray-100 text-gray-600 rounded-2xl font-black uppercase tracking-widest text-xs hover:bg-gray-200 transition-all">
                                        Batal
                                    </button>
                                    <button wire:click="saveQuestion(true)" class="flex-1 py-4 bg-slate-900 text-white rounded-2xl font-black uppercase tracking-widest text-xs hover:bg-slate-800 transition-all shadow-xl shadow-slate-900/20">
                                        Simpan & Lanjut
                                    </button>
                                    <button wire:click="saveQuestion(false)" class="flex-1 py-4 bg-blue-600 text-white rounded-2xl font-black uppercase tracking-widest text-xs hover:bg-blue-700 transition-all shadow-xl shadow-blue-500/20">
                                        Update Soal
                                    </button>
                                </div>
                            </div>
                        </div>
                    @else
                        <div class="h-full flex flex-col items-center justify-center text-center p-12 opacity-50">
                            <div class="w-32 h-32 bg-gray-50 rounded-[2.5rem] flex items-center justify-center mb-6">
                                <svg class="w-16 h-16 text-gray-200" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"></path>
                                </svg>
                            </div>
                            <h3 class="text-xl font-black text-gray-900 mb-2">Editor Bank Soal 2.0</h3>
                            <p class="text-sm text-gray-500 max-w-xs mx-auto">Klik salah satu soal di sebelah kiri atau klik 'Tambah Manual' untuk mulai mengisikan konten.</p>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    @endif
</div>
