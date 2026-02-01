<div>
    @section('title', 'Manage User')

    <div class="bg-white rounded-xl shadow-sm p-4 mb-6">
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Cari User</label>
                <input type="text" wire:model.live.debounce.300ms="search" 
                    placeholder="Cari nama atau email..." 
                    class="w-full rounded-lg border-gray-300">
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Role</label>
                <select wire:model.live="roleFilter" class="w-full rounded-lg border-gray-300">
                    <option value="">Semua Role</option>
                    <option value="user">User</option>
                    <option value="admin">Admin</option>
                </select>
            </div>
        </div>
    </div>

    <div class="bg-white rounded-xl shadow-sm overflow-hidden">
        <table class="w-full">
            <thead class="bg-gray-50 border-b">
                <tr>
                    <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">User</th>
                    <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Role</th>
                    <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Email Verified</th>
                    <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Bergabung</th>
                    <th class="px-4 py-3 text-right text-xs font-medium text-gray-500 uppercase">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y">
                @forelse($users as $user)
                    <tr class="hover:bg-gray-50">
                        <td class="px-4 py-3">
                            <p class="font-medium text-gray-900">{{ $user->name }}</p>
                            <p class="text-sm text-gray-500">{{ $user->email }}</p>
                        </td>
                        <td class="px-4 py-3">
                            <span class="px-2 py-1 text-xs rounded-full 
                                {{ $user->role === 'admin' ? 'bg-purple-100 text-purple-700' : 'bg-gray-100 text-gray-700' }}">
                                {{ strtoupper($user->role) }}
                            </span>
                        </td>
                        <td class="px-4 py-3">
                            @if($user->hasVerifiedEmail())
                                <span class="text-green-600">✓ Verified</span>
                            @else
                                <span class="text-gray-400">Not verified</span>
                            @endif
                        </td>
                        <td class="px-4 py-3 text-sm text-gray-500">{{ $user->created_at->format('d M Y') }}</td>
                        <td class="px-4 py-3 text-right">
                            @if($user->id !== auth()->id())
                                <button wire:click="toggleRole({{ $user->id }})" 
                                    wire:confirm="Yakin ingin mengubah role user ini?"
                                    class="text-blue-600 hover:underline text-sm mr-2">
                                    {{ $user->role === 'admin' ? 'Jadikan User' : 'Jadikan Admin' }}
                                </button>
                                @if($user->role !== 'admin')
                                    <button wire:click="deleteUser({{ $user->id }})" 
                                        wire:confirm="Yakin ingin menghapus user ini?"
                                        class="text-red-600 hover:underline text-sm">
                                        Hapus
                                    </button>
                                @endif
                            @else
                                <span class="text-gray-400 text-sm">Anda</span>
                            @endif
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" class="px-4 py-8 text-center text-gray-500">
                            Tidak ada user ditemukan.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>

        <div class="p-4 border-t">
            {{ $users->links() }}
        </div>
    </div>
</div>
