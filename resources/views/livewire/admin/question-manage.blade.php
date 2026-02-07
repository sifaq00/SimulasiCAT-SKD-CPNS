<div>
    @section('title', 'Bank Soal 2.0')
    
    <style>
        .custom-scrollbar-hide::-webkit-scrollbar { display: none; }
        .custom-scrollbar-hide { -ms-overflow-style: none; scrollbar-width: none; }
    </style>

    @if(!$selectedPackage)
        {{-- STEP 1: Package Selection Dashboard --}}
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            @foreach($packages as $pkg)
                <div wire:click="selectPackage({{ $pkg['id'] }})" wire:key="pkg-{{ $pkg['id'] }}"
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
        <div class="flex flex-col min-h-0 min-w-0">
            {{-- Toolbar --}}
            {{-- Toolbar --}}
            <div class="flex flex-col md:flex-row items-start md:items-center justify-between bg-white p-4 rounded-t-2xl border-b shadow-sm shrink-0 gap-4">
                <div class="flex items-center justify-between w-full md:w-auto gap-4">
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
                </div>

                {{-- Right Group: Dropdown, Search, Buttons --}}
                <div class="flex flex-col md:flex-row items-center gap-3 w-full md:w-auto">
                    <div class="flex items-center gap-2 w-full md:w-auto">
                        {{-- Category Dropdown --}}
                        <div class="relative flex-1 md:flex-none">
                            <select wire:model.live="selectedCategory" 
                                class="w-full md:w-36 pl-8 pr-8 py-2 bg-gray-50 border-gray-100 rounded-xl text-[10px] font-black uppercase tracking-widest focus:bg-white focus:ring-4 focus:ring-blue-500/10 focus:border-blue-500 transition-all appearance-none cursor-pointer">
                                <option value="">SEMUA</option>
                                @foreach($categories as $cat)
                                    <option value="{{ $cat['id'] }}">{{ $cat['code'] }}</option>
                                @endforeach
                            </select>
                            <div class="absolute left-2.5 top-2 pointer-events-none text-blue-500">
                                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2.586a1 1 0 01-.293.707l-6.414 6.414a1 1 0 00-.293.707V17l-4 4v-6.586a1 1 0 00-.293-.707L3.293 7.293A1 1 0 013 6.586V4z"></path></svg>
                            </div>
                        </div>

                        {{-- Search --}}
                        <div class="relative flex-1 md:flex-none">
                            <input type="text" wire:model.live.debounce.300ms="search" placeholder="CARI..." 
                                class="pl-8 pr-4 py-2 bg-gray-50 border-gray-100 rounded-xl text-[10px] font-black uppercase tracking-widest w-full md:w-40 focus:bg-white focus:ring-4 focus:ring-blue-500/10 focus:border-blue-500 transition-all">
                            <svg class="w-3.5 h-3.5 text-gray-400 absolute left-2.5 top-2.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
                        </div>
                    </div>

                    <div class="flex items-center gap-2 w-full md:w-auto">
                        <div class="flex items-center gap-2 bg-gray-50 border border-gray-100 rounded-xl px-2 py-1.5 shadow-sm shrink-0">
                            <input type="file" wire:model="csvFile" id="csvImport" class="hidden">
                            <label for="csvImport" class="cursor-pointer text-[9px] font-black text-blue-600 hover:text-blue-800 uppercase tracking-tighter px-1">
                                {{ $csvFile ? $csvFile->getClientOriginalName() : 'CSV' }}
                            </label>
                            <a href="/templates/bank_soal_template.csv" download class="p-1 hover:bg-white rounded transition-colors text-blue-400" title="Template">
                                <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"></path></svg>
                            </a>
                            @if($csvFile)
                                <button wire:click="importQuestions" class="p-1.5 bg-blue-600 text-white rounded-lg hover:bg-blue-700 shadow-sm transition-all shadow-blue-500/20">
                                    <svg class="w-2.5 h-2.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7"></path></svg>
                                </button>
                            @endif
                        </div>

                        <button wire:click="openCreateForm" class="flex-1 md:flex-none px-4 py-2 bg-gradient-to-r from-blue-600 to-indigo-600 text-white rounded-xl hover:from-blue-700 hover:to-indigo-700 font-black text-[10px] uppercase tracking-widest flex items-center justify-center gap-2 shadow-lg shadow-blue-500/20 active:scale-95 transition-all">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path></svg>
                            TAMBAH
                        </button>
                    </div>
                </div>
            </div>

            {{-- Main Content: Question Grid --}}
            <div class="flex-1 overflow-y-auto p-6 bg-gray-50/50 custom-scrollbar">
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-2 gap-4 max-w-6xl mx-auto">
                    @forelse($questions as $q)
                        <div wire:click="editQuestion({{ $q->id }})" 
                            class="p-5 rounded-2xl bg-white border border-gray-100 shadow-sm hover:border-blue-500 hover:shadow-md transition-all cursor-pointer group relative overflow-hidden">
                            <div class="absolute top-0 right-0 w-24 h-24 -mt-8 -mr-8 bg-blue-500/5 rounded-full group-hover:scale-150 transition-transform duration-500"></div>
                            
                            <div class="flex items-center gap-3 mb-4 relative">
                                <span class="w-10 h-10 flex items-center justify-center rounded-xl {{ $editingId == $q->id ? 'bg-blue-600 text-white' : 'bg-blue-50 text-blue-600' }} font-bold text-sm shadow-sm">
                                    {{ $q->order_number }}
                                </span>
                                <span class="px-3 py-1 rounded-lg bg-gray-50 border border-gray-100 text-[10px] font-black uppercase text-gray-500 group-hover:text-blue-600 group-hover:border-blue-100 transition-colors">
                                    {{ $q->category->code }}
                                </span>
                                <div class="ml-auto opacity-0 group-hover:opacity-100 transition-opacity">
                                    <span class="text-xs font-bold text-blue-600 flex items-center gap-1">
                                        Edit <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path></svg>
                                    </span>
                                </div>
                            </div>
                            <p class="text-sm text-gray-700 font-medium line-clamp-3 leading-relaxed relative">
                                {{ $q->question_text }}
                            </p>
                        </div>
                    @empty
                        <div class="col-span-full text-center py-20 text-gray-400">
                            <div class="w-20 h-20 bg-white rounded-3xl shadow-sm flex items-center justify-center mx-auto mb-4 border border-gray-100">
                                <svg class="w-8 h-8 text-gray-200" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path>
                                </svg>
                            </div>
                            <p class="font-bold text-gray-500">Belum ada soal terdaftar</p>
                            <p class="text-xs">Klik 'Tambah Manual' atau import CSV untuk mulai melengkapi paket ini.</p>
                        </div>
                    @endforelse
                </div>
            </div>

            {{-- STEP 3: Question Modal Editor --}}
            @if($showForm)
            <div class="fixed inset-0 z-[60] overflow-y-auto" aria-labelledby="modal-title" role="dialog" aria-modal="true">
                <div class="flex items-end justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
                    <!-- Backdrop -->
                    <div class="fixed inset-0 bg-gray-900/40 backdrop-blur-md transition-opacity" aria-hidden="true" wire:click="cancelEdit"></div>

                    <!-- Modal Center -->
                    <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>

                    <div class="inline-block align-bottom bg-white rounded-[2.5rem] text-left overflow-hidden shadow-2xl transform transition-all sm:my-8 sm:align-middle sm:max-w-4xl sm:w-full border border-gray-100">
                        <div class="p-6 md:p-10">
                            <div class="flex flex-col md:flex-row md:items-center justify-between gap-6 mb-10">
                                <div>
                                    <h3 class="text-3xl font-black text-gray-900 flex items-center gap-3">
                                        {{ $editingId ? 'Edit Pertanyaan' : 'Buat Soal Baru' }}
                                        <span class="px-3 py-1 bg-blue-100 text-blue-700 rounded-xl text-base font-bold">#{{ $formData['order_number'] }}</span>
                                    </h3>
                                    <p class="text-gray-500 text-sm mt-1">Lengkapi informasi dan detail soal di bawah ini.</p>
                                </div>
                                <div class="flex items-center gap-3">
                                    @if($editingId)
                                        <button wire:click="deleteQuestion({{ $editingId }})" 
                                            wire:confirm="Hapus soal ini selamanya?"
                                            class="p-3 bg-red-50 text-red-600 rounded-2xl hover:bg-red-600 hover:text-white transition-all shadow-sm group" title="Hapus Soal">
                                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                                            </svg>
                                        </button>
                                    @endif
                                    <button wire:click="cancelEdit" class="p-3 bg-gray-100 text-gray-500 rounded-2xl hover:bg-gray-200 transition-all">
                                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                                    </button>
                                </div>
                            </div>

                            <div class="space-y-10">
                                <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                                    <div>
                                        <label class="block text-xs font-black text-gray-400 uppercase tracking-widest mb-2 px-1">Kategori Materi</label>
                                        <select wire:model.live="formData.category_id" class="w-full h-14 rounded-2xl border-gray-100 bg-gray-50 focus:bg-white focus:border-blue-500 focus:ring-4 focus:ring-blue-50 font-bold text-gray-700 transition-all">
                                            <option value="">Pilih Kategori</option>
                                            @foreach($categories as $cat)
                                                <option value="{{ $cat['id'] }}">{{ $cat['name'] }} ({{ $cat['code'] }})</option>
                                            @endforeach
                                        </select>
                                        @error('formData.category_id') <p class="text-red-500 text-xs mt-2 px-1">{{ $message }}</p> @enderror
                                    </div>
                                    <div>
                                        <label class="block text-xs font-black text-gray-400 uppercase tracking-widest mb-2 px-1">Urutan Soal</label>
                                        <input type="number" wire:model="formData.order_number" min="1" 
                                            class="w-full h-14 rounded-2xl border-gray-100 bg-gray-50 focus:bg-white focus:border-blue-500 focus:ring-4 focus:ring-blue-50 font-black text-lg transition-all">
                                    </div>
                                </div>

                                <div class="space-y-6">
                                    <div>
                                        <label class="block text-xs font-black text-gray-400 uppercase tracking-widest mb-2 px-1">Isi Pertanyaan</label>
                                        <textarea wire:model="formData.question_text" rows="6" 
                                            class="w-full rounded-[2.5rem] border-gray-100 bg-gray-50 focus:bg-white focus:border-blue-500 focus:ring-4 focus:ring-blue-50 p-6 text-base font-medium transition-all"
                                            placeholder="Tuliskan soal di sini..."></textarea>
                                        @error('formData.question_text') <p class="text-red-500 text-xs mt-2 px-1">{{ $message }}</p> @enderror
                                    </div>

                                    <div class="flex flex-col md:flex-row items-center gap-8 p-8 bg-blue-50/50 rounded-[2.5rem] border-2 border-dashed border-blue-100 shadow-inner">
                                        <div class="shrink-0">
                                            @if ($imageFile)
                                                <img src="{{ $imageFile->temporaryUrl() }}" class="w-40 h-40 object-cover rounded-[2rem] shadow-xl ring-8 ring-white">
                                            @elseif ($existingImage)
                                                <img src="{{ Storage::url($existingImage) }}" class="w-40 h-40 object-cover rounded-[2rem] shadow-xl ring-8 ring-white">
                                            @else
                                                <div class="w-40 h-40 bg-white rounded-[2rem] flex flex-col items-center justify-center text-blue-200 border border-blue-50 shadow-sm">
                                                    <svg class="w-12 h-12 mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                                    </svg>
                                                    <span class="text-[10px] font-black uppercase tracking-widest">No Image</span>
                                                </div>
                                            @endif
                                        </div>
                                        <div class="flex-1 text-center md:text-left">
                                            <h4 class="font-black text-blue-900 mb-1">Ilustrasi Soal</h4>
                                            <p class="text-xs text-blue-600/70 mb-4 max-w-xs">Pilih gambar jika pertanyaan membutuhkan grafik, peta, atau gambar spasial.</p>
                                            <div class="flex flex-wrap items-center gap-3 justify-center md:justify-start">
                                                <input type="file" wire:model="imageFile" class="hidden" id="modalImageBtn">
                                                <label for="modalImageBtn" class="px-5 py-2.5 bg-blue-600 text-white rounded-xl text-xs font-black uppercase tracking-widest hover:bg-blue-700 transition-all cursor-pointer shadow-md shadow-blue-600/20">
                                                    Unggah Gambar
                                                </label>
                                                @if($imageFile || $existingImage)
                                                    <button wire:click="removeImage" class="px-5 py-2.5 bg-white text-red-600 rounded-xl text-xs font-black uppercase tracking-widest border border-red-100 hover:bg-red-50 transition-all">
                                                        Hapus
                                                    </button>
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                {{-- Options --}}
                                <div>
                                    <label class="block text-xs font-black text-gray-400 uppercase tracking-widest mb-6 px-1">Pilihan Jawaban & Poin</label>
                                    <div class="grid grid-cols-1 gap-4">
                                        @php
                                            $selectedCat = collect($categories)->firstWhere('id', $formData['category_id']);
                                            $isTKP = $selectedCat && $selectedCat['code'] === 'TKP';
                                        @endphp
                                        
                                        @foreach($options as $i => $opt)
                                            <div class="flex items-center gap-4 p-4 md:p-5 rounded-2xl border border-gray-100 hover:border-blue-200 bg-gray-50/30 transition-all group/opt">
                                                <span class="w-12 h-12 flex items-center justify-center rounded-2xl bg-white border border-gray-100 font-black text-blue-600 shadow-sm transition-all group-hover/opt:scale-110 group-hover/opt:shadow-md">
                                                    {{ $opt['label'] }}
                                                </span>
                                                <div class="flex-1">
                                                    <input type="text" wire:model="options.{{ $i }}.text" 
                                                        class="w-full h-12 bg-transparent border-0 focus:ring-0 text-gray-700 font-bold placeholder-gray-300"
                                                        placeholder="Ketik pilihan jawaban...">
                                                    @error("options.{$i}.text") <p class="text-red-500 text-[10px] mt-1">{{ $message }}</p> @enderror
                                                </div>
                                                
                                                @if($isTKP)
                                                    <div class="w-20">
                                                        <select wire:model="options.{{ $i }}.points" class="w-full bg-white rounded-xl border-gray-100 text-sm font-black text-blue-600 focus:ring-4 focus:ring-blue-50 py-2.5">
                                                            @foreach(range(1, 5) as $pt) <option value="{{ $pt }}">{{ $pt }}</option> @endforeach
                                                        </select>
                                                    </div>
                                                @else
                                                    <button type="button" wire:click="setCorrectOption({{ $i }})"
                                                        class="px-5 py-2.5 rounded-xl text-[10px] font-black uppercase tracking-widest transition-all shadow-sm {{ $opt['is_correct'] ? 'bg-green-500 text-white shadow-green-500/30' : 'bg-white border border-gray-200 text-gray-400 hover:border-green-300 hover:text-green-600' }}">
                                                        {{ $opt['is_correct'] ? 'BENAR' : 'SET' }}
                                                    </button>
                                                @endif
                                            </div>
                                        @endforeach
                                    </div>
                                </div>

                                {{-- Explanation --}}
                                <div>
                                    <label class="block text-xs font-black text-gray-400 uppercase tracking-widest mb-2 px-1">Pembahasan & Penjelasan</label>
                                    <textarea wire:model="formData.explanation" rows="4" 
                                        class="w-full rounded-2xl border-gray-100 bg-gray-50 focus:bg-white focus:border-blue-500 focus:ring-4 focus:ring-blue-50 p-6 text-sm font-medium transition-all"
                                        placeholder="Jelaskan mengapa jawaban tersebut benar..."></textarea>
                                </div>

                                {{-- Action Buttons --}}
                                <div class="flex flex-col-reverse md:flex-row items-center justify-end gap-4 pt-10 mt-10 border-t border-gray-50">
                                    <button wire:click="cancelEdit" 
                                        class="w-full md:w-auto px-10 py-4 rounded-2xl border-2 border-gray-100 text-gray-400 font-black uppercase tracking-widest hover:bg-gray-50 hover:text-gray-600 transition-all text-sm">
                                        Batal
                                    </button>
                                    <button wire:click="saveQuestion" 
                                        class="w-full md:w-auto px-12 py-4 rounded-2xl bg-gradient-to-r from-blue-600 to-indigo-600 text-white font-black uppercase tracking-widest hover:from-blue-700 hover:to-indigo-700 shadow-xl shadow-blue-500/30 transform hover:-translate-y-1 transition-all text-sm">
                                        {{ $editingId ? 'Simpan Update' : 'Publish Soal' }}
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            @endif
        </div>
    @endif
</div>
