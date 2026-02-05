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

<section class="relative flex items-center w-full min-h-screen overflow-hidden bg-slate-900 pt-16">
    <div class="absolute -top-24 -left-24 w-80 h-80 bg-blue-600/30 blur-[80px] rounded-full"></div>
    <div class="absolute top-1/2 -right-16 w-72 h-72 bg-purple-600/30 blur-[80px] rounded-full"></div>
    <div class="absolute bottom-16 left-1/3 w-64 h-64 bg-cyan-500/20 blur-[90px] rounded-full"></div>

    <div class="relative z-10 w-full px-4 py-10 sm:px-6 lg:px-16 lg:py-0">


            <div class="w-full lg:w-2/3">
                <div class="w-full max-w-md p-6 mx-auto border shadow-2xl sm:p-8 bg-slate-800/60 backdrop-blur-xl border-slate-700/60 rounded-3xl lg:p-10">
                    <div class="mb-6">
                        <h2 class="text-2xl font-bold text-white">Masuk Akun</h2>
                        <p class="mt-1 text-slate-400">Masukkan email dan password untuk akses paket latihan.</p>
                    </div>

                    <!-- Session Status -->
                    @if (session('status') === 'verification-link-sent')
                        <div class="p-3 mb-4 text-sm font-medium text-white border bg-green-500/10 border-green-500/20 rounded-xl">
                            {{ __('Link verifikasi telah dikirim. Cek email Anda.') }}
                        </div>
                    @elseif (session('status') === 'verified')
                        <div class="p-3 mb-4 text-sm font-medium text-white border bg-green-500/10 border-green-500/20 rounded-xl">
                            {{ __('Email Anda telah diverifikasi. Anda dapat masuk sekarang.') }}
                        </div>
                    @endif

                    <form wire:submit="login" class="space-y-5">
                        <div>
                            <x-input-label for="email" :value="__('Email')" class="text-white" />
                            <x-text-input wire:model="form.email" id="email" class="block w-full mt-2 text-black rounded-xl bg-slate-900/60 border-slate-700 placeholder:text-slate-500 focus:ring-blue-500/40 focus:border-blue-500" type="email" name="email" required autofocus autocomplete="username" />
                            <x-input-error :messages="$errors->get('form.email')" class="mt-2 text-rose-400" />
                        </div>

                        <div>
                            <x-input-label for="password" :value="__('Password')" class="text-white" />
                            <x-text-input wire:model="form.password" id="password" class="block w-full mt-2 text-black rounded-xl bg-slate-900/60 border-slate-700 placeholder:text-slate-500 focus:ring-blue-500/40 focus:border-blue-500"
                                            type="password"
                                            name="password"
                                            required autocomplete="current-password" />
                            <x-input-error :messages="$errors->get('form.password')" class="mt-2 text-rose-400" />
                        </div>

                        <div class="flex items-center justify-between">
                            <label for="remember" class="inline-flex items-center gap-2 cursor-pointer text-slate-300">
                                <input wire:model="form.remember" id="remember" type="checkbox" class="text-blue-600 rounded border-slate-600 bg-slate-700" name="remember">
                                <span class="text-sm">{{ __('Ingat saya') }}</span>
                            </label>
                            @if (Route::has('password.request'))
                                <a class="text-sm font-medium text-blue-400 hover:text-blue-300 transition" href="{{ route('password.request') }}" wire:navigate>
                                    {{ __('Lupa password?') }}
                                </a>
                            @endif
                        </div>

                        <div class="pt-2">
                            <x-primary-button class="inline-flex items-center justify-center w-full gap-2 bg-gradient-to-r from-blue-600 to-purple-600 hover:opacity-90" wire:loading.attr="disabled" wire:target="login">
                                <span wire:loading.remove wire:target="login">{{ __('Masuk') }}</span>
                                <svg wire:loading.delay wire:target="login" class="flex-shrink-0 w-5 h-5 text-white animate-spin" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                                    <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                    <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8v4a4 4 0 00-4 4H4z"></path>
                                </svg>
                                <span wire:loading.delay wire:target="login">{{ __('Memproses...') }}</span>
                            </x-primary-button>
                        </div>

                        <div class="text-sm text-center text-slate-400">
                            {{ __('Belum punya akun?') }}
                            <a class="font-medium text-blue-300 hover:text-blue-200" href="{{ route('register') }}" wire:navigate>
                                {{ __('Daftar di sini') }}
                            </a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</section>
