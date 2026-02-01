<div>
    @section('title', 'Manage Paket')

    <div class="flex justify-end mb-4 gap-2">
        <button wire:click="openCreateForm" 
            class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 font-medium flex items-center gap-2">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
            </svg>
            Tambah Paket
        </button>
        <button wire:click="openCreateBundleForm" 
            class="px-4 py-2 bg-purple-600 text-white rounded-lg hover:bg-purple-700 font-medium flex items-center gap-2">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
            </svg>
            Tambah Bundle
        </button>
    </div>

    <div class="bg-white rounded-xl shadow-sm overflow-hidden">
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
                        </td>
                        <td class="px-4 py-3 text-right">
                            <button wire:click="toggleActive({{ $pkg['id'] }})" 
                                class="text-gray-600 hover:underline text-sm mr-2">
                                {{ $pkg['is_active'] ? 'Nonaktifkan' : 'Aktifkan' }}
                            </button>
                            <button wire:click="editPackage({{ $pkg['id'] }})" 
                                class="text-blue-600 hover:underline text-sm mr-2">Edit</button>
                            <button wire:click="deletePackage({{ $pkg['id'] }})" 
                                wire:confirm="Yakin ingin menghapus paket ini?"
                                class="text-red-600 hover:underline text-sm">Hapus</button>
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

    {{-- Bundle Section --}}
    <div class="mt-8">
        <h3 class="text-lg font-semibold mb-4">Daftar Bundle</h3>
        <div class="bg-white rounded-xl shadow-sm overflow-hidden">
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
                                <button wire:click="toggleBundleActive({{ $bundle['id'] }})" 
                                    class="text-gray-600 hover:underline text-sm mr-2">
                                    {{ $bundle['is_active'] ? 'Nonaktifkan' : 'Aktifkan' }}
                                </button>
                                <button wire:click="editBundle({{ $bundle['id'] }})" 
                                    class="text-blue-600 hover:underline text-sm mr-2">Edit</button>
                                <button wire:click="deleteBundle({{ $bundle['id'] }})" 
                                    wire:confirm="Yakin ingin menghapus bundle ini?"
                                    class="text-red-600 hover:underline text-sm">Hapus</button>
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

                    <div class="flex items-center gap-2">
                        <input type="checkbox" wire:model="formData.is_active" id="is_active" class="rounded border-gray-300">
                        <label for="is_active" class="text-sm text-gray-700">Aktif</label>
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
