<?php

use App\Livewire\Forms\LoginForm;
use Illuminate\Support\Facades\Session;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;
use Livewire\Volt\Component;

new #[Layout('layouts.guest')] #[Title('Masuk | Hisan Makmur')] class extends Component
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

        $this->redirectIntended(default: route('dashboard', absolute: false), navigate: true);
    }
}; ?>

<div class="w-full text-gray-600">
    <div class="text-center pb-8">
        <img src="../../logo.png" class="w-[200px] mx-auto" alt="logo">
        <div class="mt-5">
            <h3 class="text-gray-800 text-2xl font-bold sm:text-3xl">Log in to your account</h3>
        </div>
    </div>

    <x-auth-session-status class="mb-4" :status="session('status')" />

    <form wire:submit="login" class="space-y-5">
        <div>
            <label class="font-medium">Email</label>
            <input wire:model="form.email" type="email" required class="w-full mt-2 px-3 py-2 text-gray-500 bg-transparent outline-none border focus:border-indigo-600 shadow-sm rounded-lg" placeholder="Enter your email" />
            <x-input-error :messages="$errors->get('form.email')" class="mt-2" />
        </div>
        <div>
            <label class="font-medium">Password</label>
            <input wire:model="form.password" type="password" required class="w-full mt-2 px-3 py-2 text-gray-500 bg-transparent outline-none border focus:border-indigo-600 shadow-sm rounded-lg" placeholder="Enter your password" />
            <x-input-error :messages="$errors->get('form.password')" class="mt-2" />
        </div>

        <div class="flex items-center justify-between text-sm">
            <div class="flex items-center gap-x-2">
                <input wire:model="form.remember" type="checkbox" id="remember-me-checkbox" class="hidden peer" />
                <label for="remember-me-checkbox" class="relative flex w-5 h-5 bg-white peer-checked:bg-indigo-600 rounded-md border ring-offset-2 ring-indigo-600 duration-150 peer-active:ring cursor-pointer after:absolute after:inset-x-0 after:top-[3px] after:m-auto after:w-1.5 after:h-2.5 after:border-r-2 after:border-b-2 after:border-white after:rotate-45"></label>
                <span>Remember me</span>
            </div>
            @if (Route::has('password.request'))
                <a href="{{ route('password.request') }}" class="text-indigo-600 hover:text-indigo-500 font-medium">Forgot password?</a>
            @endif
        </div>

        <button type="submit" class="w-full px-4 py-2 text-white font-medium bg-indigo-600 hover:bg-indigo-500 active:bg-indigo-600 rounded-lg duration-150 shadow-md">
            Sign in
        </button>
    </form>

    <p class="text-center text-sm mt-8">
        Don't have an account? 
        <a href="{{ route('register') }}" wire:navigate class="font-medium text-indigo-600 hover:text-indigo-500">Sign up</a>
    </p>
</div>
