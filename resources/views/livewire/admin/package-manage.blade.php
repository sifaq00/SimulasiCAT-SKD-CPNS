<div>
    @section('title', 'Manage Paket')

    <div class="flex flex-col sm:flex-row justify-end mb-6 gap-3">
        <button wire:click="openCreateForm" 
            class="px-6 py-2.5 bg-gradient-to-r from-blue-600 to-indigo-600 text-white rounded-xl hover:from-blue-700 hover:to-indigo-700 font-bold flex items-center justify-center gap-2 shadow-lg shadow-blue-500/30 transform hover:-translate-y-0.5 transition-all">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
            </svg>
            Tambah Paket
        </button>
        <button wire:click="openCreateBundleForm" 
            class="px-6 py-2.5 bg-white text-purple-600 border-2 border-purple-100 rounded-xl hover:bg-purple-50 hover:border-purple-200 font-bold flex items-center justify-center gap-2 transition-all">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
            </svg>
            Tambah Bundle
        </button>
    </div>

    {{-- Mobile Card View --}}
    <div class="grid grid-cols-1 gap-4 md:hidden">
        @forelse($packages as $pkg)
            <div class="bg-white p-4 rounded-xl shadow-sm border border-gray-100 space-y-3">
                <div class="flex justify-between items-start">
                    <div>
                        <h3 class="font-bold text-gray-900">{{ $pkg['name'] }}</h3>
                        <p class="text-xs text-gray-500">{{ $pkg['slug'] }}</p>
                    </div>
                    <span class="px-2 py-1 text-xs rounded-full {{ $pkg['is_active'] ? 'bg-green-100 text-green-700' : 'bg-gray-100 text-gray-700' }}">
                        {{ $pkg['is_active'] ? 'Aktif' : 'Nonaktif' }}
                    </span>
                </div>
                
                <div class="grid grid-cols-2 gap-2 text-sm">
                    <div>
                        <span class="text-gray-500 text-xs block">Tahun</span>
                        <span class="font-medium">{{ $pkg['year'] }}</span>
                    </div>
                    <div>
                        <span class="text-gray-500 text-xs block">Soal</span>
                        <span class="font-medium">{{ $pkg['questions_count'] ?? 0 }}/{{ $pkg['total_questions'] }}</span>
                    </div>
                    <div class="col-span-2">
                        <span class="text-gray-500 text-xs block">Harga</span>
                        <span class="font-medium text-blue-600">Rp {{ number_format($pkg['price'], 0, ',', '.') }}</span>
                    </div>
                </div>

                @if($pkg['is_free'])
                    <span class="px-2 py-1 text-xs rounded-full bg-blue-100 text-blue-700 inline-block">Free Tryout</span>
                @endif

                <div class="flex justify-end gap-2 pt-3 border-t">
                    <button wire:click="toggleActive({{ $pkg['id'] }})" class="px-3 py-1.5 rounded-lg text-xs font-bold uppercase tracking-wider transition-all {{ $pkg['is_active'] ? 'bg-orange-50 text-orange-600 hover:bg-orange-100 border border-orange-100' : 'bg-green-50 text-green-600 hover:bg-green-100 border border-green-100' }}">
                        {{ $pkg['is_active'] ? 'Nonaktifkan' : 'Aktifkan' }}
                    </button>
                    <button wire:click="editPackage({{ $pkg['id'] }})" class="p-1.5 text-blue-600 bg-blue-50 hover:bg-blue-600 hover:text-white rounded-lg transition-all border border-blue-100" title="Edit">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path></svg>
                    </button>
                    <button wire:click="deletePackage({{ $pkg['id'] }})" 
                        wire:confirm="Yakin ingin menghapus paket ini?"
                        class="p-1.5 text-red-600 bg-red-50 hover:bg-red-600 hover:text-white rounded-lg transition-all border border-red-100" title="Hapus">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                    </button>
                </div>
            </div>
        @empty
            <div class="text-center p-8 text-gray-500 bg-white rounded-xl">
                Belum ada paket.
            </div>
        @endforelse
    </div>

    {{-- Desktop Table View --}}
    <div class="hidden md:block bg-white rounded-xl shadow-sm overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full">
                <thead class="bg-gray-50 border-b">
                    <tr>
                        <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Nama</th>
                        <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Tahun</th>
                        <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Harga</th>
                        <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Soal</th>
                        <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Status</th>
                        <th class="px-4 py-3 text-right text-xs font-medium text-gray-500 uppercase">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y">
                    @forelse($packages as $pkg)
                        <tr class="hover:bg-gray-50">
                            <td class="px-4 py-3">
                                <p class="font-medium text-gray-900">{{ $pkg['name'] }}</p>
                                <p class="text-sm text-gray-500">{{ $pkg['slug'] }}</p>
                            </td>
                            <td class="px-4 py-3 text-sm">{{ $pkg['year'] }}</td>
                            <td class="px-4 py-3 text-sm">Rp {{ number_format($pkg['price'], 0, ',', '.') }}</td>
                            <td class="px-4 py-3 text-sm">{{ $pkg['questions_count'] ?? 0 }}/{{ $pkg['total_questions'] }}</td>
                            <td class="px-4 py-3">
                                <span class="px-2 py-1 text-xs rounded-full {{ $pkg['is_active'] ? 'bg-green-100 text-green-700' : 'bg-gray-100 text-gray-700' }}">
                                    {{ $pkg['is_active'] ? 'Aktif' : 'Nonaktif' }}
                                </span>
                                @if($pkg['is_free'])
                                    <span class="px-2 py-1 text-xs rounded-full bg-blue-100 text-blue-700">Free</span>
                                @endif
                            </td>
                            <td class="px-4 py-3 text-right">
                                <div class="flex items-center justify-end gap-2">
                                    <button wire:click="toggleActive({{ $pkg['id'] }})" 
                                        class="px-3 py-1 rounded-lg text-[10px] font-bold uppercase tracking-wider transition-all {{ $pkg['is_active'] ? 'bg-orange-50 text-orange-600 hover:bg-orange-100 border border-orange-100' : 'bg-green-50 text-green-600 hover:bg-green-100 border border-green-100' }}">
                                        {{ $pkg['is_active'] ? 'OFF' : 'ON' }}
                                    </button>
                                    <button wire:click="editPackage({{ $pkg['id'] }})" 
                                        class="p-1.5 text-blue-600 bg-blue-50 hover:bg-blue-600 hover:text-white rounded-lg transition-all border border-blue-100" title="Edit">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path></svg>
                                    </button>
                                    <button wire:click="deletePackage({{ $pkg['id'] }})" 
                                        wire:confirm="Yakin ingin menghapus paket ini?"
                                        class="p-1.5 text-red-600 bg-red-50 hover:bg-red-600 hover:text-white rounded-lg transition-all border border-red-100" title="Hapus">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                                    </button>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="px-4 py-8 text-center text-gray-500">
                                Belum ada paket. Klik "Tambah Paket" untuk mulai.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    {{-- Bundle Section --}}
    <div class="mt-8">
        <h3 class="text-lg font-semibold mb-4">Daftar Bundle</h3>
        {{-- Mobile Bundle Cards --}}
        <div class="grid grid-cols-1 gap-4 md:hidden">
            @forelse($bundles as $bundle)
                <div class="bg-white p-4 rounded-xl shadow-sm border border-gray-100 space-y-3">
                    <div class="flex justify-between items-start">
                        <div>
                            <h3 class="font-bold text-gray-900">{{ $bundle['name'] }}</h3>
                            <p class="text-xs text-gray-500">{{ $bundle['slug'] }}</p>
                        </div>
                        <span class="px-2 py-1 text-xs rounded-full {{ $bundle['is_active'] ? 'bg-green-100 text-green-700' : 'bg-gray-100 text-gray-700' }}">
                            {{ $bundle['is_active'] ? 'Aktif' : 'Nonaktif' }}
                        </span>
                    </div>

                    <div class="grid grid-cols-2 gap-2 text-sm">
                         <div>
                            <span class="text-gray-500 text-xs block">Harga Normal</span>
                            <span class="text-gray-500 line-through">Rp {{ number_format($bundle['original_price'], 0, ',', '.') }}</span>
                        </div>
                        <div>
                            <span class="text-gray-500 text-xs block">Harga Diskon</span>
                            <span class="font-bold text-blue-600">Rp {{ number_format($bundle['discount_price'], 0, ',', '.') }}</span>
                        </div>
                        <div class="col-span-2">
                            <span class="text-gray-500 text-xs block">Isi</span>
                            <span class="font-medium">{{ $bundle['packages_count'] ?? 0 }} Paket</span>
                        </div>
                    </div>

                    <div class="flex justify-end gap-2 pt-3 border-t">
                        <button wire:click="toggleBundleActive({{ $bundle['id'] }})" class="px-3 py-1.5 rounded-lg text-xs font-bold uppercase tracking-wider transition-all {{ $bundle['is_active'] ? 'bg-orange-50 text-orange-600 hover:bg-orange-100 border border-orange-100' : 'bg-green-50 text-green-600 hover:bg-green-100 border border-green-100' }}">
                            {{ $bundle['is_active'] ? 'Nonaktifkan' : 'Aktifkan' }}
                        </button>
                        <button wire:click="editBundle({{ $bundle['id'] }})" class="p-1.5 text-blue-600 bg-blue-50 hover:bg-blue-600 hover:text-white rounded-lg transition-all border border-blue-100" title="Edit">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path></svg>
                        </button>
                        <button wire:click="deleteBundle({{ $bundle['id'] }})" 
                            wire:confirm="Yakin ingin menghapus bundle ini?"
                            class="p-1.5 text-red-600 bg-red-50 hover:bg-red-600 hover:text-white rounded-lg transition-all border border-red-100" title="Hapus">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                        </button>
                    </div>
                </div>
            @empty
                <div class="text-center p-8 text-gray-500 bg-white rounded-xl">
                    Belum ada bundle.
                </div>
            @endforelse
        </div>

        {{-- Desktop Bundle Table --}}
        <div class="hidden md:block bg-white rounded-xl shadow-sm overflow-hidden">
            <div class="overflow-x-auto">
                <table class="w-full">
                    <thead class="bg-gray-50 border-b">
                        <tr>
                            <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Nama Bundle</th>
                            <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Harga Normal</th>
                            <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Harga Diskon</th>
                            <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Isi Paket</th>
                            <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Status</th>
                            <th class="px-4 py-3 text-right text-xs font-medium text-gray-500 uppercase">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y">
                        @forelse($bundles as $bundle)
                            <tr class="hover:bg-gray-50">
                                <td class="px-4 py-3">
                                    <p class="font-medium text-gray-900">{{ $bundle['name'] }}</p>
                                    <p class="text-sm text-gray-500">{{ $bundle['slug'] }}</p>
                                </td>
                                <td class="px-4 py-3 text-sm text-gray-500 line-through">
                                    Rp {{ number_format($bundle['original_price'], 0, ',', '.') }}
                                </td>
                                <td class="px-4 py-3 text-sm font-semibold text-blue-600">
                                    Rp {{ number_format($bundle['discount_price'], 0, ',', '.') }}
                                </td>
                                <td class="px-4 py-3 text-sm">
                                    {{ $bundle['packages_count'] ?? 0 }} Paket
                                </td>
                                <td class="px-4 py-3">
                                    <span class="px-2 py-1 text-xs rounded-full {{ $bundle['is_active'] ? 'bg-green-100 text-green-700' : 'bg-gray-100 text-gray-700' }}">
                                        {{ $bundle['is_active'] ? 'Aktif' : 'Nonaktif' }}
                                    </span>
                                </td>
                                <td class="px-4 py-3 text-right">
                                    <div class="flex items-center justify-end gap-2">
                                        <button wire:click="toggleBundleActive({{ $bundle['id'] }})" 
                                            class="px-3 py-1 rounded-lg text-[10px] font-bold uppercase tracking-wider transition-all {{ $bundle['is_active'] ? 'bg-orange-50 text-orange-600 hover:bg-orange-100 border border-orange-100' : 'bg-green-50 text-green-600 hover:bg-green-100 border border-green-100' }}">
                                            {{ $bundle['is_active'] ? 'OFF' : 'ON' }}
                                        </button>
                                        <button wire:click="editBundle({{ $bundle['id'] }})" 
                                            class="p-1.5 text-blue-600 bg-blue-50 hover:bg-blue-600 hover:text-white rounded-lg transition-all border border-blue-100" title="Edit">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path></svg>
                                        </button>
                                        <button wire:click="deleteBundle({{ $bundle['id'] }})" 
                                            wire:confirm="Yakin ingin menghapus bundle ini?"
                                            class="p-1.5 text-red-600 bg-red-50 hover:bg-red-600 hover:text-white rounded-lg transition-all border border-red-100" title="Hapus">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                                        </button>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="px-4 py-8 text-center text-gray-500">
                                    Belum ada bundle tersedia.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    {{-- Package Form Modal --}}
    @if($showForm)
        <div class="fixed inset-0 bg-black/50 flex items-center justify-center z-50">
            <div class="bg-white rounded-xl max-w-lg w-full mx-4">
                <div class="p-6 border-b flex items-center justify-between">
                    <h3 class="text-lg font-semibold">{{ $editingId ? 'Edit Paket' : 'Tambah Paket Baru' }}</h3>
                    <button wire:click="closeForm" class="text-gray-400 hover:text-gray-600">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                        </svg>
                    </button>
                </div>

                <div class="p-6 space-y-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Nama Paket *</label>
                        <input type="text" wire:model.live="formData.name" class="w-full rounded-lg border-gray-300">
                        @error('formData.name') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Slug *</label>
                        <input type="text" wire:model="formData.slug" class="w-full rounded-lg border-gray-300">
                        @error('formData.slug') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                    </div>

                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Tahun *</label>
                            <input type="number" wire:model="formData.year" class="w-full rounded-lg border-gray-300">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Harga (Rp) *</label>
                            <input type="number" wire:model="formData.price" class="w-full rounded-lg border-gray-300">
                        </div>
                    </div>

                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Jumlah Soal</label>
                            <input type="number" wire:model="formData.total_questions" class="w-full rounded-lg border-gray-300">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Durasi (menit)</label>
                            <input type="number" wire:model="formData.duration_minutes" class="w-full rounded-lg border-gray-300">
                        </div>
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Deskripsi</label>
                        <textarea wire:model="formData.description" rows="2" class="w-full rounded-lg border-gray-300"></textarea>
                    </div>

                    <div class="flex items-center gap-4">
                        <div class="flex items-center gap-2">
                            <input type="checkbox" wire:model="formData.is_active" id="is_active" class="rounded border-gray-300">
                            <label for="is_active" class="text-sm text-gray-700">Aktif</label>
                        </div>
                        <div class="flex items-center gap-2">
                            <input type="checkbox" wire:model="formData.is_free" id="is_free" class="rounded border-gray-300">
                            <label for="is_free" class="text-sm text-gray-700">Gratis (Free Tryout)</label>
                        </div>
                    </div>
                </div>

                <div class="p-6 border-t flex justify-end gap-3">
                    <button wire:click="closeForm" class="px-4 py-2 bg-gray-200 text-gray-700 rounded-lg hover:bg-gray-300">Batal</button>
                    <button wire:click="savePackage" class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700">
                        {{ $editingId ? 'Update' : 'Simpan' }}
                    </button>
                </div>
            </div>
        </div>
    @endif

    {{-- Bundle Form Modal --}}
    @if($showBundleForm)
        <div class="fixed inset-0 bg-black/50 flex items-center justify-center z-50">
            <div class="bg-white rounded-xl max-w-lg w-full mx-4 max-h-[90vh] overflow-y-auto">
                <div class="p-6 border-b flex items-center justify-between">
                    <h3 class="text-lg font-semibold">{{ $editingBundleId ? 'Edit Bundle' : 'Tambah Bundle Baru' }}</h3>
                    <button wire:click="closeBundleForm" class="text-gray-400 hover:text-gray-600">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                        </svg>
                    </button>
                </div>

                <div class="p-6 space-y-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Nama Bundle *</label>
                        <input type="text" wire:model="bundleFormData.name" class="w-full rounded-lg border-gray-300">
                        @error('bundleFormData.name') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Slug *</label>
                        <input type="text" wire:model="bundleFormData.slug" class="w-full rounded-lg border-gray-300">
                        @error('bundleFormData.slug') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                    </div>

                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Harga Normal *</label>
                            <input type="number" wire:model="bundleFormData.original_price" class="w-full rounded-lg border-gray-300">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Harga Diskon *</label>
                            <input type="number" wire:model="bundleFormData.discount_price" class="w-full rounded-lg border-gray-300">
                        </div>
                    </div>
                    
                    @error('bundleFormData.original_price') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                    @error('bundleFormData.discount_price') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Deskripsi</label>
                        <textarea wire:model="bundleFormData.description" rows="2" class="w-full rounded-lg border-gray-300"></textarea>
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Pilih Paket dalam Bundle *</label>
                        <div class="space-y-2 max-h-40 overflow-y-auto border rounded p-2">
                            @foreach($packages as $pkg)
                                <div class="flex items-center gap-2">
                                    <input type="checkbox" wire:model="bundleFormData.selected_packages" value="{{ $pkg['id'] }}" id="pkg_{{ $pkg['id'] }}" class="rounded border-gray-300">
                                    <label for="pkg_{{ $pkg['id'] }}" class="text-sm text-gray-700">{{ $pkg['name'] }}</label>
                                </div>
                            @endforeach
                        </div>
                        @error('bundleFormData.selected_packages') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                    </div>

                    <div class="flex items-center gap-2">
                        <input type="checkbox" wire:model="bundleFormData.is_active" id="bundle_active" class="rounded border-gray-300">
                        <label for="bundle_active" class="text-sm text-gray-700">Aktif</label>
                    </div>
                </div>

                <div class="p-6 border-t flex justify-end gap-3">
                    <button wire:click="closeBundleForm" class="px-4 py-2 bg-gray-200 text-gray-700 rounded-lg hover:bg-gray-300">Batal</button>
                    <button wire:click="saveBundle" class="px-4 py-2 bg-purple-600 text-white rounded-lg hover:bg-purple-700">
                        {{ $editingBundleId ? 'Update' : 'Simpan Bundle' }}
                    </button>
                </div>
            </div>
        </div>
    @endif
</div>
