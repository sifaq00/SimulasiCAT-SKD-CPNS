<div>
    @section('title', 'Manage Soal')

    {{-- Filters --}}
    <div class="bg-white rounded-xl shadow-sm p-4 mb-6">
        <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Paket</label>
                <select wire:model.live="selectedPackage" class="w-full rounded-lg border-gray-300">
                    <option value="">Semua Paket</option>
                    @foreach($packages as $pkg)
                        <option value="{{ $pkg['id'] }}">{{ $pkg['name'] }}</option>
                    @endforeach
                </select>
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Kategori</label>
                <select wire:model.live="selectedCategory" class="w-full rounded-lg border-gray-300">
                    <option value="">Semua Kategori</option>
                    @foreach($categories as $cat)
                        <option value="{{ $cat['id'] }}">{{ $cat['name'] }} ({{ $cat['code'] }})</option>
                    @endforeach
                </select>
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Cari</label>
                <input type="text" wire:model.live.debounce.300ms="search" 
                    placeholder="Cari soal..." 
                    class="w-full rounded-lg border-gray-300">
            </div>
            <div class="flex items-end">
                <button wire:click="openCreateForm" 
                    class="w-full py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 font-medium flex items-center justify-center gap-2">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                    </svg>
                    Tambah Soal
                </button>
            </div>
        </div>

        {{-- Question Count per Category --}}
        @if($selectedPackage && count($questionCounts) > 0)
            <div class="flex gap-4 mt-4 pt-4 border-t text-sm">
                @foreach($questionCounts as $code => $count)
                    @php
                        $target = $code === 'TWK' ? 30 : ($code === 'TIU' ? 35 : 45);
                        $isComplete = $count >= $target;
                    @endphp
                    <span class="px-3 py-1 rounded-full {{ $isComplete ? 'bg-green-100 text-green-700' : 'bg-yellow-100 text-yellow-700' }}">
                        {{ $code }}: {{ $count }}/{{ $target }}
                    </span>
                @endforeach
            </div>
        @endif
    </div>

    {{-- Questions Table --}}
    <div class="bg-white rounded-xl shadow-sm overflow-hidden">
        <table class="w-full">
            <thead class="bg-gray-50 border-b">
                <tr>
                    <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">No</th>
                    <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Paket</th>
                    <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Kategori</th>
                    <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Soal</th>
                    <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Opsi</th>
                    <th class="px-4 py-3 text-right text-xs font-medium text-gray-500 uppercase">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y">
                @forelse($questions as $question)
                    <tr class="hover:bg-gray-50">
                        <td class="px-4 py-3 text-sm">{{ $question->order_number }}</td>
                        <td class="px-4 py-3 text-sm">{{ $question->package->name }}</td>
                        <td class="px-4 py-3">
                            <span class="px-2 py-1 text-xs rounded-full bg-blue-100 text-blue-700">
                                {{ $question->category->code }}
                            </span>
                        </td>
                        <td class="px-4 py-3 text-sm max-w-md truncate">
                            {{ Str::limit($question->question_text, 80) }}
                        </td>
                        <td class="px-4 py-3 text-sm text-gray-500">
                            {{ $question->options->count() }} opsi
                        </td>
                        <td class="px-4 py-3 text-right">
                            <button wire:click="editQuestion({{ $question->id }})" 
                                class="text-blue-600 hover:underline text-sm mr-2">Edit</button>
                            <button wire:click="deleteQuestion({{ $question->id }})" 
                                wire:confirm="Yakin ingin menghapus soal ini?"
                                class="text-red-600 hover:underline text-sm">Hapus</button>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" class="px-4 py-8 text-center text-gray-500">
                            Belum ada soal. Klik "Tambah Soal" untuk mulai.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>

        {{-- Pagination --}}
        <div class="p-4 border-t">
            {{ $questions->links() }}
        </div>
    </div>

    {{-- Form Modal --}}
    @if($showForm)
        <div class="fixed inset-0 bg-black/50 flex items-start justify-center z-50 overflow-y-auto py-8">
            <div class="bg-white rounded-xl max-w-3xl w-full mx-4 my-8">
                <div class="p-6 border-b flex items-center justify-between">
                    <h3 class="text-lg font-semibold">{{ $editingId ? 'Edit Soal' : 'Tambah Soal Baru' }}</h3>
                    <button wire:click="closeForm" class="text-gray-400 hover:text-gray-600">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                        </svg>
                    </button>
                </div>

                <div class="p-6 space-y-4 max-h-[70vh] overflow-y-auto">
                    {{-- Package & Category --}}
                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Paket *</label>
                            <select wire:model="formData.package_id" class="w-full rounded-lg border-gray-300">
                                <option value="">Pilih Paket</option>
                                @foreach($packages as $pkg)
                                    <option value="{{ $pkg['id'] }}">{{ $pkg['name'] }}</option>
                                @endforeach
                            </select>
                            @error('formData.package_id') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Kategori *</label>
                            <select wire:model="formData.category_id" class="w-full rounded-lg border-gray-300">
                                <option value="">Pilih Kategori</option>
                                @foreach($categories as $cat)
                                    <option value="{{ $cat['id'] }}">{{ $cat['name'] }} ({{ $cat['code'] }})</option>
                                @endforeach
                            </select>
                            @error('formData.category_id') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                        </div>
                    </div>

                    {{-- Order Number --}}
                    <div class="w-32">
                        <label class="block text-sm font-medium text-gray-700 mb-1">Nomor Urut</label>
                        <input type="number" wire:model="formData.order_number" min="1" 
                            class="w-full rounded-lg border-gray-300">
                    </div>

                    {{-- Question Text --}}
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Teks Soal *</label>
                        <textarea wire:model="formData.question_text" rows="4" 
                            class="w-full rounded-lg border-gray-300"
                            placeholder="Tuliskan soal di sini..."></textarea>
                        @error('formData.question_text') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                    </div>

                    {{-- Options --}}
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Pilihan Jawaban *</label>
                        <div class="space-y-3">
                            @foreach($options as $i => $opt)
                                <div class="flex items-start gap-3 p-3 bg-gray-50 rounded-lg">
                                    <span class="w-8 h-8 flex items-center justify-center rounded-full bg-gray-200 font-bold text-sm">
                                        {{ $opt['label'] }}
                                    </span>
                                    <div class="flex-1">
                                        <input type="text" wire:model="options.{{ $i }}.text" 
                                            class="w-full rounded-lg border-gray-300 text-sm"
                                            placeholder="Teks jawaban {{ $opt['label'] }}">
                                        @error("options.{$i}.text") <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                                    </div>
                                    
                                    @php
                                        $selectedCat = collect($categories)->firstWhere('id', $formData['category_id']);
                                        $isTKP = $selectedCat && $selectedCat['code'] === 'TKP';
                                    @endphp
                                    
                                    @if($isTKP)
                                        <div class="w-20">
                                            <input type="number" wire:model="options.{{ $i }}.points" 
                                                min="1" max="5"
                                                class="w-full rounded-lg border-gray-300 text-sm text-center"
                                                placeholder="Poin">
                                        </div>
                                    @else
                                        <button type="button" wire:click="setCorrectOption({{ $i }})"
                                            class="px-3 py-2 rounded-lg text-sm {{ $opt['is_correct'] ? 'bg-green-500 text-white' : 'bg-gray-200 text-gray-600' }}">
                                            {{ $opt['is_correct'] ? '✓ Benar' : 'Set Benar' }}
                                        </button>
                                    @endif
                                </div>
                            @endforeach
                        </div>
                        @if($isTKP ?? false)
                            <p class="text-xs text-gray-500 mt-2">TKP: Setiap opsi punya poin 1-5 (5 = paling tepat)</p>
                        @else
                            <p class="text-xs text-gray-500 mt-2">TWK/TIU: Klik "Set Benar" untuk menandai jawaban yang benar</p>
                        @endif
                    </div>

                    {{-- Explanation --}}
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Pembahasan (Opsional)</label>
                        <textarea wire:model="formData.explanation" rows="3" 
                            class="w-full rounded-lg border-gray-300"
                            placeholder="Penjelasan jawaban yang benar..."></textarea>
                    </div>
                </div>

                <div class="p-6 border-t flex justify-end gap-3">
                    <button wire:click="closeForm" 
                        class="px-4 py-2 bg-gray-200 text-gray-700 rounded-lg hover:bg-gray-300">
                        Batal
                    </button>
                    <button wire:click="saveQuestion" 
                        class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700">
                        {{ $editingId ? 'Update Soal' : 'Simpan Soal' }}
                    </button>
                </div>
            </div>
        </div>
    @endif
</div>
