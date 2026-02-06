<?php

use App\Livewire\Actions\Logout;
use Livewire\Volt\Component;

new class extends Component
{
    /**
     * Log the current user out of the application.
     */
    public function logout(Logout $logout): void
    {
        $logout();

        $this->redirect('/', navigate: true);
    }
}; ?>

<nav x-data="{ open: false }" class="fixed top-0 left-0 right-0 z-50 bg-white/80 backdrop-blur-xl border-b border-slate-200 shadow-sm">
    <!-- Primary Navigation Menu -->
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between h-20">
            <div class="flex items-center gap-10">
                <!-- Logo -->
                <div class="shrink-0 flex items-center">
                    <a href="{{ auth()->check() ? route('dashboard') : url('/') }}" class="flex items-center gap-3 group transition-all hover:opacity-80">
                         <div class="w-10 h-10 bg-gradient-to-br from-blue-600 to-indigo-700 rounded-xl flex items-center justify-center shadow-lg shadow-blue-500/20">
                            <span class="text-white font-bold text-lg font-outfit">S</span>
                        </div>
                        <span class="text-slate-900 font-extrabold text-xl hidden sm:block font-outfit tracking-tight">Simulasi CPNS</span>
                    </a>
                </div>

                <!-- Navigation Links -->
                <div class="hidden space-x-1 sm:flex h-20">
                    @auth
                        <a href="{{ route('dashboard') }}" 
                           class="inline-flex items-center px-4 h-full border-b-2 {{ request()->routeIs('dashboard') ? 'border-blue-600 text-blue-600' : 'border-transparent text-slate-500 hover:text-slate-900 hover:bg-slate-50' }} text-sm font-semibold transition duration-200 ease-in-out font-outfit"
                           wire:navigate>
                            Dashboard
                        </a>
                        <a href="{{ route('packages') }}" 
                           class="inline-flex items-center px-4 h-full border-b-2 {{ request()->routeIs('packages') ? 'border-blue-600 text-blue-600' : 'border-transparent text-slate-500 hover:text-slate-900 hover:bg-slate-50' }} text-sm font-semibold transition duration-200 ease-in-out font-outfit"
                           wire:navigate>
                            Beli Paket
                        </a>
                    @else
                        <a href="{{ url('/') }}" 
                           class="inline-flex items-center px-4 h-full border-b-2 {{ request()->is('/') ? 'border-blue-600 text-blue-600' : 'border-transparent text-slate-500 hover:text-slate-900 hover:bg-slate-50' }} text-sm font-semibold transition duration-200 ease-in-out font-outfit"
                           wire:navigate>
                            Beranda
                        </a>
                    @endauth
                </div>
            </div>

            <!-- Settings Dropdown -->
            <div class="hidden sm:flex sm:items-center sm:ms-6">
                @auth
                    <div class="ms-3 relative">
                        <x-dropdown align="right" width="56">
                            <x-slot name="trigger">
                                <button class="flex items-center gap-3 px-3 py-1.5 rounded-2xl bg-slate-50 border border-slate-200 text-slate-600 hover:text-slate-900 hover:bg-slate-100 transition-all focus:outline-none group">
                                    <div class="w-8 h-8 rounded-xl bg-blue-600 text-white flex items-center justify-center font-bold text-xs font-outfit">
                                        {{ strtoupper(substr(auth()->user()->name, 0, 1)) }}
                                    </div>
                                    <div class="text-sm font-semibold font-outfit" x-data="{{ json_encode(['name' => auth()->user()->name]) }}" x-text="name" x-on:profile-updated.window="name = $event.detail.name"></div>
                                    <svg class="w-4 h-4 text-slate-400 group-hover:text-slate-600 transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                                    </svg>
                                </button>
                            </x-slot>

                            <x-slot name="content">
                                <div class="px-5 py-4 border-b border-slate-100 bg-slate-50/50">
                                    <p class="text-[10px] font-bold text-slate-500 uppercase tracking-widest mb-1">Akun Saya</p>
                                    <p class="text-sm font-bold text-slate-900 truncate mb-0.5">{{ auth()->user()->name }}</p>
                                    <p class="text-xs font-medium text-slate-500 truncate">{{ auth()->user()->email }}</p>
                                </div>
                                <div class="p-2">
                                    <x-dropdown-link :href="route('profile')" 
                                        class="rounded-xl px-4 py-2.5 text-slate-600 hover:text-slate-900 hover:bg-slate-50 font-semibold font-outfit text-sm"
                                        wire:navigate>
                                        <div class="flex items-center gap-3">
                                            <svg class="w-4 h-4 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" /></svg>
                                            Profil Saya
                                        </div>
                                    </x-dropdown-link>
                                    
                                    @if(auth()->user()->isAdmin())
                                        <x-dropdown-link :href="route('admin.dashboard')" 
                                            class="rounded-xl px-4 py-2.5 text-slate-600 hover:text-blue-600 hover:bg-blue-50 font-semibold font-outfit text-sm"
                                            wire:navigate>
                                            <div class="flex items-center gap-3">
                                                <svg class="w-4 h-4 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z" /></svg>
                                                Admin Panel
                                            </div>
                                        </x-dropdown-link>
                                    @endif

                                    <div class="border-t border-slate-100 my-2"></div>

                                    <button wire:click="logout" class="w-full text-start">
                                        <x-dropdown-link class="rounded-xl px-4 py-2.5 text-red-600 hover:text-red-700 hover:bg-red-50 font-semibold font-outfit text-sm">
                                            <div class="flex items-center gap-3">
                                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1" /></svg>
                                                Keluar
                                            </div>
                                        </x-dropdown-link>
                                    </button>
                                </div>
                            </x-slot>
                        </x-dropdown>
                    </div>
                @else
                    <div class="flex items-center gap-6">
                        <a href="{{ route('login') }}" class="text-sm text-slate-600 hover:text-slate-900 font-semibold font-outfit">Masuk</a>
                        @if (Route::has('register'))
                            <a href="{{ route('register') }}" class="px-6 py-2.5 bg-blue-600 text-white rounded-2xl text-sm font-bold hover:bg-blue-700 shadow-xl shadow-blue-600/20 transition-all font-outfit">Daftar Sekarang</a>
                        @endif
                    </div>
                @endauth
            </div>

            <!-- Hamburger -->
            <div class="-me-2 flex items-center sm:hidden">
                <button @click="open = ! open" class="inline-flex items-center justify-center p-2 rounded-xl text-slate-500 hover:text-slate-900 hover:bg-slate-100 transition duration-150 ease-in-out">
                    <svg class="h-6 w-6" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                        <path :class="{'hidden': open, 'inline-flex': ! open }" class="inline-flex" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                        <path :class="{'hidden': ! open, 'inline-flex': open }" class="hidden" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
        </div>
    </div>

    <!-- Responsive Navigation Menu -->
    <div :class="{'block': open, 'hidden': ! open}" class="hidden sm:hidden bg-white border-t border-slate-100">
        <div class="pt-2 pb-3 space-y-1">
            @auth
                <x-responsive-nav-link :href="route('dashboard')" :active="request()->routeIs('dashboard')" wire:navigate class="text-slate-700 font-semibold font-outfit">
                    Dashboard
                </x-responsive-nav-link>
                <a href="{{ route('packages') }}" class="block w-full ps-3 pe-4 py-3 border-l-4 border-transparent text-start text-base font-semibold text-slate-600 hover:text-slate-900 hover:bg-slate-50 font-outfit" wire:navigate>
                    Beli Paket
                </a>
            @else
                <x-responsive-nav-link :href="url('/')" :active="request()->is('/')" wire:navigate class="text-slate-700 font-semibold font-outfit">
                    Beranda
                </x-responsive-nav-link>
            @endauth
        </div>

        <!-- Responsive Settings Options -->
        <div class="pt-4 pb-1 border-t border-slate-100">
            @auth
                <div class="px-4 flex items-center gap-4 py-3 bg-slate-50">
                    <div class="w-10 h-10 rounded-xl bg-blue-600 flex items-center justify-center text-white font-bold font-outfit">
                        {{ strtoupper(substr(auth()->user()->name, 0, 1)) }}
                    </div>
                    <div>
                        <div class="font-bold text-base text-slate-900 font-outfit" x-data="{{ json_encode(['name' => auth()->user()->name]) }}" x-text="name" x-on:profile-updated.window="name = $event.detail.name"></div>
                        <div class="font-medium text-xs text-slate-500">{{ auth()->user()->email }}</div>
                    </div>
                </div>

                <div class="mt-3 space-y-1 pb-4">
                    <x-responsive-nav-link :href="route('profile')" wire:navigate class="text-slate-600 font-semibold font-outfit">
                        Profil Saya
                    </x-responsive-nav-link>

                    @if(auth()->user()->isAdmin())
                        <x-responsive-nav-link :href="route('admin.dashboard')" wire:navigate class="text-slate-600 font-semibold font-outfit">
                            Admin Panel
                        </x-responsive-nav-link>
                    @endif

                    <button wire:click="logout" class="w-full text-start">
                        <x-responsive-nav-link class="text-red-600 font-semibold font-outfit">
                            Keluar
                        </x-responsive-nav-link>
                    </button>
                </div>
            @else
                <div class="px-4 py-6 space-y-3">
                    <a href="{{ route('login') }}" class="block w-full px-4 py-3 text-center rounded-2xl bg-slate-100 text-slate-700 font-bold font-outfit hover:bg-slate-200 transition">Masuk</a>
                    @if (Route::has('register'))
                        <a href="{{ route('register') }}" class="block w-full px-4 py-3 text-center rounded-2xl bg-blue-600 text-white font-bold font-outfit hover:bg-blue-700 transition">Daftar Sekarang</a>
                    @endif
                </div>
            @endauth
        </div>
    </div>
</nav>
