<x-guest-layout>
    <div class="text-center mb-10">
        <div class="flex justify-center mb-6">
            <a href="/">
                <x-application-logo class="h-32 w-auto" />
            </a>
        </div>

        <h2 class="text-4xl font-serif font-bold text-brand-navy tracking-tight">
            Scholarship Portal
        </h2>
        <div class="h-1 w-20 bg-brand-crimson mx-auto mt-4"></div>
        <p class="mt-4 text-sm text-neutral-body uppercase tracking-widest font-semibold">
            University Management System
        </p>
    </div>
    <x-auth-session-status class="mb-4" :status="session('status')" />

    <form method="POST" action="{{ route('login') }}" class="space-y-6">
        @csrf

        <div>
            <x-input-label for="email" :value="__('Email Address')" class="text-neutral-heading font-bold mb-1" />
            <div class="relative group">
                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none text-gray-400 group-focus-within:text-brand-navy transition-colors">
                    <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 12a4 4 0 10-8 0 4 4 0 008 0zm0 0v1.5a2.5 2.5 0 005 0V12a9 9 0 10-9 9m4.5-1.206a8.959 8.959 0 01-4.5 1.206" /></svg>
                </div>
                <x-text-input id="email" class="block pl-10 w-full border-neutral-divider focus:ring-brand-navy focus:border-brand-navy rounded-none shadow-sm" type="email" name="email" :value="old('email')" required autofocus placeholder="university.email@edu.ph" />
            </div>
            <x-input-error :messages="$errors->get('email')" class="mt-2 text-brand-crimson" />
        </div>

        <div>
            <div class="flex justify-between items-center mb-1">
                <x-input-label for="password" :value="__('Password')" class="text-neutral-heading font-bold" />
                @if (Route::has('password.request'))
                    <a class="text-xs font-semibold text-brand-navy hover:text-brand-crimson transition duration-200 uppercase tracking-tighter" href="{{ route('password.request') }}">
                        {{ __('Forgot?') }}
                    </a>
                @endif
            </div>
            <div class="relative group">
                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none text-gray-400 group-focus-within:text-brand-navy transition-colors">
                    <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" /></svg>
                </div>
                <x-text-input id="password" class="block pl-10 w-full border-neutral-divider focus:ring-brand-navy focus:border-brand-navy rounded-none shadow-sm" type="password" name="password" required placeholder="••••••••" />
            </div>
            <x-input-error :messages="$errors->get('password')" class="mt-2 text-brand-crimson" />
        </div>

        <div class="flex items-center">
            <label for="remember_me" class="inline-flex items-center cursor-pointer">
                <input id="remember_me" type="checkbox" class="rounded-none border-neutral-divider text-brand-navy focus:ring-brand-navy" name="remember">
                <span class="ms-2 text-xs text-neutral-body font-bold uppercase tracking-wide">{{ __('Keep me signed in') }}</span>
            </label>
        </div>

        <div class="pt-2 space-y-4">
            <button type="submit" class="w-full flex justify-center py-4 px-4 bg-brand-navy border border-transparent rounded-none shadow-md text-xs font-bold text-white uppercase tracking-[0.2em] hover:bg-opacity-90 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-brand-navy transition-all">
                {{ __('Secure Sign In') }}
            </button>

            <div class="text-center text-xs text-neutral-body uppercase tracking-wider font-semibold">
                {{ __("New Student?") }} 
                <a href="{{ route('register') }}" class="text-brand-crimson hover:underline decoration-2 underline-offset-4">
                    {{ __('Apply for Account') }}
                </a>
            </div>
        </div>
    </form>
</x-guest-layout>