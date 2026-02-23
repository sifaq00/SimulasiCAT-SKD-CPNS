<?php

use App\Livewire\Forms\LoginForm;
use Illuminate\Support\Facades\Session;
use Livewire\Attributes\Layout;
use Livewire\Volt\Component;
use Illuminate\Support\Facades\Auth;

new #[Layout('layouts.guest')] class extends Component
{
    public LoginForm $form;

    /**
     * Handle an incoming authentication request.
     */
    public function login(): void
    {
        $this->validate();

        $this->form->authenticate();

        Session::regenerate();

        // Single session enforcement:
        // If not admin, invalidate other sessions
        if (!auth()->user()->isAdmin()) {
            Auth::logoutOtherDevices($this->form->password);
        }

        // Redirect based on role
        if (auth()->user()->isAdmin()) {
            $this->redirectIntended(default: route('admin.dashboard', absolute: false), navigate: true);
        } else {
            $this->redirectIntended(default: route('dashboard', absolute: false), navigate: true);
        }
    }
}; ?>

<section class="relative flex items-center justify-center w-full min-h-screen overflow-hidden bg-slate-900 py-8 px-4">
    <!-- Background Effects -->
    <div class="absolute -top-24 -left-24 w-80 h-80 bg-blue-600/30 blur-[80px] rounded-full"></div>
    <div class="absolute top-1/2 -right-16 w-72 h-72 bg-purple-600/30 blur-[80px] rounded-full"></div>
    <div class="absolute bottom-16 left-1/3 w-64 h-64 bg-cyan-500/20 blur-[90px] rounded-full"></div>

    <!-- Form Card - Centered -->
    <div class="relative z-10 w-full max-w-md">
        <div class="w-full p-6 sm:p-8 lg:p-10 bg-slate-800/60 backdrop-blur-xl border border-slate-700/60 rounded-3xl shadow-2xl">
            <div class="mb-6 text-center">
                <h2 class="text-2xl font-bold text-white">Masuk Akun</h2>
                <p class="mt-2 text-slate-400">Masukkan email dan password untuk akses paket latihan.</p>
            </div>

            <!-- Session Status -->
            @if (session('status') === 'verification-link-sent')
                <div class="p-3 mb-4 text-sm font-medium text-white border bg-green-500/10 border-green-500/20 rounded-xl">
                    Link verifikasi telah dikirim. Cek email Anda.
                </div>
            @elseif (session('status') === 'verified')
                <div class="p-3 mb-4 text-sm font-medium text-white border bg-green-500/10 border-green-500/20 rounded-xl">
                    Email Anda telah diverifikasi. Anda dapat masuk sekarang.
                </div>
            @endif

            <form wire:submit="login" class="space-y-5">
                <!-- Email -->
                <div>
                    <label for="email" class="block text-sm font-medium text-white">Email</label>
                    <input wire:model="form.email" id="email" type="email" 
                        class="block w-full mt-2 px-4 py-3 text-white bg-slate-800 rounded-xl border border-slate-600 placeholder:text-slate-400 focus:ring-2 focus:ring-blue-500/40 focus:border-blue-500 focus:outline-none" 
                        placeholder="nama@email.com" required autofocus autocomplete="username" />
                    @error('form.email')
                        <p class="mt-2 text-sm text-rose-400">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Password -->
                <div>
                    <label for="password" class="block text-sm font-medium text-white">Password</label>
                    <input wire:model="form.password" id="password" type="password" 
                        class="block w-full mt-2 px-4 py-3 text-white bg-slate-800 rounded-xl border border-slate-600 placeholder:text-slate-400 focus:ring-2 focus:ring-blue-500/40 focus:border-blue-500 focus:outline-none" 
                        placeholder="Masukkan password" required autocomplete="current-password" />
                    @error('form.password')
                        <p class="mt-2 text-sm text-rose-400">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Remember Me & Forgot Password -->
                <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3">
                    <label for="remember" class="inline-flex items-center gap-2 cursor-pointer text-slate-300">
                        <input wire:model="form.remember" id="remember" type="checkbox" class="text-blue-600 rounded border-slate-600 bg-slate-700" name="remember">
                        <span class="text-sm">Ingat saya</span>
                    </label>
                    @if (Route::has('password.request'))
                        <a class="text-sm font-medium text-blue-400 hover:text-blue-300 transition-colors" href="{{ route('password.request') }}" wire:navigate>
                            Lupa password?
                        </a>
                    @endif
                </div>

                <!-- Submit Button -->
                <div class="pt-2">
                    <button type="submit" 
                        class="inline-flex items-center justify-center w-full gap-2 px-6 py-3 text-sm font-semibold text-white bg-gradient-to-r from-blue-600 to-purple-600 rounded-xl hover:opacity-90 transition-opacity disabled:opacity-50"
                        wire:loading.attr="disabled" wire:target="login">
                        <span wire:loading.remove wire:target="login">Masuk</span>
                        <svg wire:loading wire:target="login" class="w-5 h-5 animate-spin" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                            <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                            <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8v4a4 4 0 00-4 4H4z"></path>
                        </svg>
                        <span wire:loading wire:target="login">Memproses...</span>
                    </button>
                </div>

                <!-- Link ke Register -->
                <div class="text-sm text-center text-slate-400">
                    Belum punya akun?
                    <a class="font-medium text-blue-400 hover:text-blue-300 transition-colors" href="{{ route('register') }}" wire:navigate>
                        Daftar di sini
                    </a>
                </div>
            </form>
        </div>
    </div>
</section>
