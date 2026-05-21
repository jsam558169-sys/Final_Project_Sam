<x-guest-layout>
    <div class="text-center mb-10">
        <div class="flex justify-center mb-6">
            <a href="/">
                <x-application-logo class="h-32 w-auto" />
            </a>
        </div>

        <h2 class="text-3xl font-serif font-bold text-brand-navy tracking-tight uppercase">
            {{ __('Student Admission') }}
        </h2>
        <div class="h-1 w-16 bg-brand-crimson mx-auto mt-4"></div>
        <p class="mt-4 text-xs text-neutral-body uppercase tracking-[0.15em] font-semibold">
            {{ __('Scholarship Portal Account Creation') }}
        </p>
    </div>

    <form method="POST" action="{{ route('register') }}" class="space-y-5">
        @csrf

        <div>
            <x-input-label for="name" :value="__('Full Name')" class="text-neutral-heading font-bold mb-1 uppercase text-[10px] tracking-widest" />
            <div class="relative group">
                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none text-gray-400 group-focus-within:text-brand-navy transition-colors">
                    <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" /></svg>
                </div>
                <x-text-input id="name" class="block pl-10 w-full border-neutral-divider focus:ring-brand-navy focus:border-brand-navy rounded-none shadow-sm text-sm" type="text" name="name" :value="old('name')" required autofocus placeholder="Johny D. Bravo" />
            </div>
            <x-input-error :messages="$errors->get('name')" class="mt-1 text-[11px] text-brand-crimson font-medium" />
        </div>

        <div>
            <x-input-label for="email" :value="__('Institutional Email')" class="text-neutral-heading font-bold mb-1 uppercase text-[10px] tracking-widest" />
            <div class="relative group">
                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none text-gray-400 group-focus-within:text-brand-navy transition-colors">
                    <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" /></svg>
                </div>
                <x-text-input id="email" class="block pl-10 w-full border-neutral-divider focus:ring-brand-navy focus:border-brand-navy rounded-none shadow-sm text-sm" type="email" name="email" :value="old('email')" required placeholder="student.id@university.edu.ph" />
            </div>
            <x-input-error :messages="$errors->get('email')" class="mt-1 text-[11px] text-brand-crimson font-medium" />
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            <div>
                <x-input-label for="password" :value="__('Password')" class="text-neutral-heading font-bold mb-1 uppercase text-[10px] tracking-widest" />
                <div class="relative group">
                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none text-gray-400 group-focus-within:text-brand-navy transition-colors">
                        <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" /></svg>
                    </div>
                    <x-text-input id="password" class="block pl-10 w-full border-neutral-divider focus:ring-brand-navy focus:border-brand-navy rounded-none shadow-sm text-sm" type="password" name="password" required placeholder="••••••••" />
                </div>
            </div>

            <div>
                <x-input-label for="password_confirmation" :value="__('Confirm')" class="text-neutral-heading font-bold mb-1 uppercase text-[10px] tracking-widest" />
                <div class="relative group">
                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none text-gray-400 group-focus-within:text-brand-navy transition-colors">
                        <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z" /></svg>
                    </div>
                    <x-text-input id="password_confirmation" class="block pl-10 w-full border-neutral-divider focus:ring-brand-navy focus:border-brand-navy rounded-none shadow-sm text-sm" type="password" name="password_confirmation" required placeholder="••••••••" />
                </div>
            </div>
        </div>
        <x-input-error :messages="$errors->get('password')" class="mt-1 text-[11px] text-brand-crimson font-medium" />
        <x-input-error :messages="$errors->get('password_confirmation')" class="mt-1 text-[11px] text-brand-crimson font-medium" />

        <div class="pt-4 space-y-4">
            <button type="submit" class="w-full flex justify-center py-4 px-4 bg-brand-navy border border-transparent rounded-none shadow-md text-xs font-bold text-white uppercase tracking-[0.2em] hover:bg-opacity-90 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-brand-navy transition-all">
                {{ __('Create Account') }}
            </button>

            <div class="text-center text-[10px] text-neutral-body uppercase tracking-widest font-bold">
                {{ __('Already have an account?') }} 
                <a href="{{ route('login') }}" class="ms-1 text-brand-crimson hover:underline decoration-2 underline-offset-4">
                    {{ __('Sign In Here') }}
                </a>
            </div>
        </div>
    </form>
</x-guest-layout>