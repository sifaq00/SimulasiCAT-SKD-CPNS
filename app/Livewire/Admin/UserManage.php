<?php

namespace App\Livewire\Admin;

use App\Models\User;
use Livewire\Component;
use Livewire\Attributes\Layout;
use Livewire\WithPagination;

#[Layout('layouts.admin')]
class UserManage extends Component
{
    use WithPagination;

    public $search = '';
    public $roleFilter = '';

    public function updatedSearch()
    {
        $this->resetPage();
    }

    public function updatedRoleFilter()
    {
        $this->resetPage();
    }

    public function toggleRole($userId)
    {
        $user = User::findOrFail($userId);
        
        if ($user->id === auth()->id()) {
            session()->flash('error', 'Tidak bisa mengubah role diri sendiri!');
            return;
        }

        $user->update([
            'role' => $user->role === 'admin' ? 'user' : 'admin'
        ]);

        session()->flash('success', 'Role user berhasil diubah!');
    }

    public function deleteUser($userId)
    {
        $user = User::findOrFail($userId);
        
        if ($user->id === auth()->id()) {
            session()->flash('error', 'Tidak bisa menghapus diri sendiri!');
            return;
        }

        if ($user->role === 'admin') {
            session()->flash('error', 'Tidak bisa menghapus admin!');
            return;
        }

        $user->delete();
        session()->flash('success', 'User berhasil dihapus!');
    }

    public function getUsersProperty()
    {
        return User::query()
            ->when($this->search, fn($q) => $q->where('name', 'like', "%{$this->search}%")
                ->orWhere('email', 'like', "%{$this->search}%"))
            ->when($this->roleFilter, fn($q) => $q->where('role', $this->roleFilter))
            ->orderByDesc('created_at')
            ->paginate(10);
    }

    public function render()
    {
        return view('livewire.admin.user-manage', [
            'users' => $this->users,
        ]);
    }
}
