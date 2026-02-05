<?php

use Illuminate\Support\Facades\Password;
use Livewire\Attributes\Layout;
use Livewire\Volt\Component;

new #[Layout('layouts.guest')] class extends Component
{
    public string $email = '';

    /**
     * Send a password reset link to the provided email address.
     */
    public function sendPasswordResetLink(): void
    {
        $this->validate([
            'email' => ['required', 'string', 'email'],
        ]);

        $status = Password::sendResetLink(
            $this->only('email')
        );

        if ($status != Password::RESET_LINK_SENT) {
            $this->addError('email', __($status));
            return;
        }

        $this->reset('email');
        session()->flash('status', __($status));
    }
}; ?>

<section class="relative flex items-center w-full min-h-screen pt-16 overflow-hidden bg-slate-900">
    <div class="absolute -top-24 -left-24 w-80 h-80 bg-blue-600/30 blur-[80px] rounded-full"></div>
    <div class="absolute top-1/2 -right-16 w-72 h-72 bg-purple-600/30 blur-[80px] rounded-full"></div>
    <div class="absolute bottom-16 left-1/3 w-64 h-64 bg-cyan-500/20 blur-[90px] rounded-full"></div>

    <div class="relative z-10 w-full px-4 py-10 sm:px-6 lg:px-16 lg:py-0">


            <div class="w-full lg:w-2/3">
                <div class="w-full max-w-md p-6 mx-auto border shadow-2xl sm:p-8 bg-slate-800/60 backdrop-blur-xl border-slate-700/60 rounded-3xl lg:p-10">
                <div class="mb-6">
                    <h2 class="text-2xl font-bold text-white">Lupa Password?</h2>
                    <p class="mt-1 text-slate-400">Kami akan mengirimkan link reset password ke email Anda.</p>
                </div>

                <!-- Session Status -->
                @if (session('status'))
                    <div class="p-4 mb-4 text-sm font-medium text-white border bg-green-500/10 border-green-500/20 rounded-xl">
                        {{ session('status') }}
                    </div>
                @endif

                <form wire:submit="sendPasswordResetLink" class="space-y-5">
                    <div>
                        <x-input-label for="email" :value="__('Email')" class="text-white" />
                        <x-text-input wire:model="email" id="email" class="block w-full mt-2 text-black rounded-xl bg-slate-900/60 border-slate-700 placeholder:text-slate-500 focus:ring-blue-500/40 focus:border-blue-500" type="email" name="email" required autofocus autocomplete="email" />
                        <x-input-error :messages="$errors->get('email')" class="mt-2 text-rose-400" />
                    </div>

                    <div class="pt-2">
                        <x-primary-button class="inline-flex items-center justify-center w-full gap-2 bg-gradient-to-r from-blue-600 to-purple-600 hover:opacity-90" wire:loading.attr="disabled" wire:target="sendPasswordResetLink">
                            <span wire:loading.remove wire:target="sendPasswordResetLink">{{ __('Kirim Link Reset') }}</span>
                            <svg wire:loading.delay wire:target="sendPasswordResetLink" class="flex-shrink-0 w-5 h-5 text-white animate-spin" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8v4a4 4 0 00-4 4H4z"></path>
                            </svg>
                            <span wire:loading.delay wire:target="sendPasswordResetLink">{{ __('Mengirim...') }}</span>
                        </x-primary-button>
                    </div>

                    <div class="text-sm text-center text-slate-400">
                        {{ __('Ingat password Anda?') }}
                        <a class="font-medium text-blue-300 hover:text-blue-200" href="{{ route('login') }}" wire:navigate>
                            {{ __('Masuk di sini') }}
                        </a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</section>
