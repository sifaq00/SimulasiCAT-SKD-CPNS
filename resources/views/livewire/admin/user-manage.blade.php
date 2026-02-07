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

    {{-- Mobile Card View --}}
    <div class="grid grid-cols-1 gap-4 md:hidden">
        @forelse($users as $user)
            <div class="bg-white p-4 rounded-xl shadow-sm border border-gray-100 space-y-3">
                <div class="flex justify-between items-start">
                    <div>
                        <h3 class="font-bold text-gray-900">{{ $user->name }}</h3>
                        <p class="text-xs text-gray-500">{{ $user->email }}</p>
                    </div>
                    <span class="px-2 py-1 text-xs rounded-full 
                        {{ $user->role === 'admin' ? 'bg-purple-100 text-purple-700' : 'bg-gray-100 text-gray-700' }}">
                        {{ strtoupper($user->role) }}
                    </span>
                </div>

                <div class="flex justify-between items-center text-sm">
                    <div>
                        @if($user->hasVerifiedEmail())
                            <span class="text-green-600 text-xs font-medium">✓ Verified</span>
                        @else
                            <span class="text-gray-400 text-xs">Not verified</span>
                        @endif
                    </div>
                    <span class="text-gray-500 text-xs">Joined {{ $user->created_at->format('d M Y') }}</span>
                </div>

                <div class="flex justify-end gap-2 pt-3 border-t">
                    @if($user->id !== auth()->id())
                        <button wire:click="toggleRole({{ $user->id }})" 
                            wire:confirm="Yakin ingin mengubah role user ini?"
                            class="px-3 py-1.5 rounded-lg text-[10px] font-bold uppercase tracking-wider transition-all {{ $user->role === 'admin' ? 'bg-orange-50 text-orange-600 hover:bg-orange-100 border border-orange-100' : 'bg-blue-50 text-blue-600 hover:bg-blue-100 border border-blue-100' }}">
                            {{ $user->role === 'admin' ? 'Degrade to User' : 'Promote to Admin' }}
                        </button>
                        @if($user->role !== 'admin')
                            <button wire:click="deleteUser({{ $user->id }})" 
                                wire:confirm="Yakin ingin menghapus user ini?"
                                class="p-1.5 text-red-600 bg-red-50 hover:bg-red-600 hover:text-white rounded-lg transition-all border border-red-100" title="Hapus User">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                            </button>
                        @endif
                    @else
                        <span class="px-3 py-1.5 bg-gray-50 text-gray-400 text-[10px] font-bold uppercase rounded-lg border border-gray-100">You (Me)</span>
                    @endif
                </div>
            </div>
        @empty
            <div class="text-center p-8 text-gray-500 bg-white rounded-xl">
                Tidak ada user ditemukan.
            </div>
        @endforelse
    </div>

    {{-- Desktop Table View --}}
    <div class="hidden md:block bg-white rounded-xl shadow-sm overflow-hidden">
        <div class="overflow-x-auto">
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
                                <div class="flex items-center justify-end gap-2">
                                    @if($user->id !== auth()->id())
                                        <button wire:click="toggleRole({{ $user->id }})" 
                                            wire:confirm="Yakin ingin mengubah role user ini?"
                                            class="px-3 py-1 rounded-lg text-[10px] font-bold uppercase tracking-wider transition-all {{ $user->role === 'admin' ? 'bg-orange-50 text-orange-600 hover:bg-orange-100 border border-orange-100' : 'bg-blue-50 text-blue-600 hover:bg-blue-100 border border-blue-100' }}"
                                            title="{{ $user->role === 'admin' ? 'Jadikan User Biasa' : 'Jadikan Admin' }}">
                                            {{ $user->role === 'admin' ? 'User' : 'Admin' }}
                                        </button>
                                        @if($user->role !== 'admin')
                                            <button wire:click="deleteUser({{ $user->id }})" 
                                                wire:confirm="Yakin ingin menghapus user ini?"
                                                class="p-1.5 text-red-600 bg-red-50 hover:bg-red-600 hover:text-white rounded-lg transition-all border border-red-100" title="Hapus User">
                                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                                            </button>
                                        @endif
                                    @else
                                        <span class="px-3 py-1 bg-gray-50 text-gray-400 text-[10px] font-bold uppercase rounded-lg border border-gray-100">You</span>
                                    @endif
                                </div>
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
        </div>

        <div class="p-4 border-t">
            {{ $users->links() }}
        </div>
    </div>
</div>
