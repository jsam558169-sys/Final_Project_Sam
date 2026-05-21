<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <div>
                <h2 class="font-serif text-3xl font-bold text-brand-navy leading-tight tracking-tight">
                    {{ __('Enroll New Program') }}
                </h2>
                <p class="text-xs text-neutral-body uppercase tracking-[0.2em] font-semibold mt-1">
                    Scholarship Registry • Provisioning Mode
                </p>
            </div>
            
            <a href="{{ route('admin.scholarships.index') }}" class="text-[10px] font-bold text-neutral-body uppercase tracking-widest hover:text-brand-navy transition-colors flex items-center">
                <svg class="w-3 h-3 me-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/></svg>
                Cancel & Return
            </a>
        </div>
    </x-slot>

    <div class="max-w-4xl mx-auto py-10 px-4 sm:px-6 lg:px-8">

        {{-- ERROR HANDLING --}}
        @if($errors->any())
        <div class="bg-white border border-brand-crimson/20 p-4 shadow-sm flex items-start space-x-3 mb-8">
            <div class="bg-brand-crimson/10 p-2 text-brand-crimson">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/></svg>
            </div>
            <div>
                <p class="font-bold text-[10px] uppercase tracking-widest text-brand-crimson">Required Fields Missing</p>
                <ul class="mt-1 text-sm text-brand-crimson/80 list-disc list-inside">
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        </div>
        @endif

        {{-- FORM MODULE --}}
        <div class="bg-white border border-neutral-divider shadow-sm rounded-none overflow-hidden">
            
            {{-- Form Branding Header --}}
            <div class="bg-brand-navy px-8 py-5 flex items-center justify-between">
                <div class="flex items-center space-x-3">
                    <svg class="w-5 h-5 text-white/70" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
                    <h3 class="font-serif font-bold text-xl text-white tracking-wide">Program Entry Form</h3>
                </div>
                <span class="text-[9px] font-bold text-white/40 uppercase tracking-[0.3em]">New Registry Record</span>
            </div>

            <form method="POST" action="{{ route('admin.scholarships.store') }}" class="p-8 space-y-8">
                @csrf

                {{-- Program Name --}}
                <div class="space-y-2">
                    <label for="name" class="text-[10px] font-bold uppercase tracking-widest text-neutral-heading">
                        Official Program Title <span class="text-brand-crimson">*</span>
                    </label>
                    <input type="text" name="name" id="name"
                        value="{{ old('name') }}"
                        placeholder="e.g., Academic Excellence Grant 2026"
                        class="w-full border-neutral-divider rounded-none shadow-sm focus:ring-brand-navy focus:border-brand-navy text-sm font-serif p-3"
                        required autofocus>
                </div>

                <hr class="border-neutral-divider">

                {{-- Program Description --}}
                <div class="space-y-2">
                    <label for="description" class="text-[10px] font-bold uppercase tracking-widest text-neutral-heading">
                        Description & Eligibility Brief <span class="text-brand-crimson">*</span>
                    </label>
                    <textarea name="description" id="description" rows="6"
                        class="w-full border-neutral-divider rounded-none shadow-sm focus:ring-brand-navy focus:border-brand-navy text-sm leading-relaxed p-4"
                        placeholder="Provide detailed criteria and benefit information for applicants..." required autofocus>{{ old('description') }}</textarea>
                </div>

                {{-- Submission Footer --}}
                <div class="pt-6 border-t border-neutral-divider flex items-center justify-end space-x-4">
                    <a href="{{ route('admin.scholarships.index') }}"
                        class="px-6 py-3 text-[10px] font-bold text-neutral-heading uppercase tracking-[0.2em] hover:text-brand-navy transition-colors">
                        Discard Record
                    </a>

                    <button type="submit"
                        class="bg-brand-navy hover:bg-opacity-90 text-white px-8 py-3 text-[10px] font-bold uppercase tracking-[0.2em] shadow-sm transition-all focus:outline-none focus:ring-2 focus:ring-brand-navy focus:ring-offset-2">
                        Register Program
                    </button>
                </div>

            </form>
        </div>
        
        <p class="mt-6 text-center text-[9px] text-gray-400 uppercase tracking-[0.3em]">
            Authorized personnel only. New programs will be immediately visible to students.
        </p>

    </div>
</x-app-layout>