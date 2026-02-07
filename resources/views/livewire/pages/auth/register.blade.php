<?php

use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;
use Illuminate\Validation\Rules;
use Livewire\Attributes\Layout;
use Livewire\Volt\Component;

new #[Layout('layouts.guest')] class extends Component
{
    public string $name = '';
    public string $email = '';
    public string $password = '';
    public string $password_confirmation = '';

    /**
     * Handle an incoming registration request.
     */
    public function register()
    {
        $validated = $this->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:'.User::class],
            'password' => ['required', 'string', 'confirmed', Rules\Password::defaults()],
        ]);

        $validated['password'] = Hash::make($validated['password']);

        event(new Registered($user = User::create($validated)));

        $user->sendEmailVerificationNotification();

        return redirect()->route('login')->with('status', 'verification-link-sent');
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
                <h2 class="text-2xl font-bold text-white">Daftar Akun</h2>
                <p class="mt-2 text-slate-400">Isi data berikut untuk membuat akun baru.</p>
            </div>

            <form wire:submit="register" class="space-y-5">
                <!-- Nama Lengkap -->
                <div>
                    <label for="name" class="block text-sm font-medium text-white">Nama Lengkap</label>
                    <input wire:model="name" id="name" type="text" 
                        class="block w-full mt-2 px-4 py-3 text-white bg-slate-800 rounded-xl border border-slate-600 placeholder:text-slate-400 focus:ring-2 focus:ring-blue-500/40 focus:border-blue-500 focus:outline-none" 
                        placeholder="John Doe" required autofocus autocomplete="name" />
                    @error('name')
                        <p class="mt-2 text-sm text-rose-400">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Email -->
                <div>
                    <label for="email" class="block text-sm font-medium text-white">Email</label>
                    <input wire:model="email" id="email" type="email" 
                        class="block w-full mt-2 px-4 py-3 text-white bg-slate-800 rounded-xl border border-slate-600 placeholder:text-slate-400 focus:ring-2 focus:ring-blue-500/40 focus:border-blue-500 focus:outline-none" 
                        placeholder="nama@email.com" required autocomplete="username" />
                    @error('email')
                        <p class="mt-2 text-sm text-rose-400">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Password -->
                <div>
                    <label for="password" class="block text-sm font-medium text-white">Password</label>
                    <input wire:model="password" id="password" type="password" 
                        class="block w-full mt-2 px-4 py-3 text-white bg-slate-800 rounded-xl border border-slate-600 placeholder:text-slate-400 focus:ring-2 focus:ring-blue-500/40 focus:border-blue-500 focus:outline-none" 
                        placeholder="Minimal 8 karakter" required autocomplete="new-password" />
                    <p class="mt-2 text-xs text-slate-500">Gunakan minimal 8 karakter dengan kombinasi angka & huruf.</p>
                    @error('password')
                        <p class="mt-2 text-sm text-rose-400">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Konfirmasi Password -->
                <div>
                    <label for="password_confirmation" class="block text-sm font-medium text-white">Konfirmasi Password</label>
                    <input wire:model="password_confirmation" id="password_confirmation" type="password" 
                        class="block w-full mt-2 px-4 py-3 text-white bg-slate-800 rounded-xl border border-slate-600 placeholder:text-slate-400 focus:ring-2 focus:ring-blue-500/40 focus:border-blue-500 focus:outline-none" 
                        placeholder="Ketik ulang password" required autocomplete="new-password" />
                    @error('password_confirmation')
                        <p class="mt-2 text-sm text-rose-400">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Submit Button -->
                <div class="pt-2">
                    <button type="submit" 
                        class="inline-flex items-center justify-center w-full gap-2 px-6 py-3 text-sm font-semibold text-white bg-gradient-to-r from-blue-600 to-purple-600 rounded-xl hover:opacity-90 transition-opacity disabled:opacity-50"
                        wire:loading.attr="disabled" wire:target="register">
                        <span wire:loading.remove wire:target="register">Daftar</span>
                        <svg wire:loading wire:target="register" class="w-5 h-5 animate-spin" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                            <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                            <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8v4a4 4 0 00-4 4H4z"></path>
                        </svg>
                        <span wire:loading wire:target="register">Mendaftar...</span>
                    </button>
                </div>

                <!-- Link ke Login -->
                <div class="text-sm text-center text-slate-400">
                    Sudah punya akun?
                    <a class="font-medium text-blue-400 hover:text-blue-300 transition-colors" href="{{ route('login') }}" wire:navigate>
                        Masuk di sini
                    </a>
                </div>
            </form>
        </div>
    </div>
</section>
