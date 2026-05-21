<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <div>
                <h2 class="font-serif text-3xl font-bold text-brand-navy leading-tight tracking-tight">
                    {{ __('Revise Program Details') }}
                </h2>
                <p class="text-xs text-neutral-body uppercase tracking-[0.2em] font-semibold mt-1">
                    Registry Update • Program Ref: SCH-{{ str_pad($scholarship->id, 4, '0', STR_PAD_LEFT) }}
                </p>
            </div>
            
            <a href="{{ route('admin.scholarships.index') }}" class="text-[10px] font-bold text-neutral-body uppercase tracking-widest hover:text-brand-navy transition-colors flex items-center">
                <svg class="w-3 h-3 me-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/></svg>
                Back to Registry
            </a>
        </div>
    </x-slot>

    <div class="max-w-4xl mx-auto py-10 px-4 sm:px-6 lg:px-8">

        {{-- SUCCESS NOTIFICATION --}}
        @if(session('success'))
        <div class="bg-white border border-green-200 p-4 shadow-sm flex items-center space-x-3 mb-8">
            <div class="bg-green-100 p-2 text-green-600">
                <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/></svg>
            </div>
            <div>
                <p class="font-bold text-[10px] uppercase tracking-widest text-green-800">System Success</p>
                <p class="text-sm text-green-700">{{ session('success') }}</p>
            </div>
        </div>
        @endif

        {{-- ERROR HANDLING --}}
        @if($errors->any())
        <div class="bg-white border border-brand-crimson/20 p-4 shadow-sm flex items-start space-x-3 mb-8">
            <div class="bg-brand-crimson/10 p-2 text-brand-crimson">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/></svg>
            </div>
            <div>
                <p class="font-bold text-[10px] uppercase tracking-widest text-brand-crimson">Correct Information Required</p>
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
                    <svg class="w-5 h-5 text-white/70" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg>
                    <h3 class="font-serif font-bold text-xl text-white tracking-wide">Scholarship Amendment Form</h3>
                </div>
                <span class="text-[9px] font-bold text-white/40 uppercase tracking-[0.3em]">Institutional Use Only</span>
            </div>

            <form action="{{ route('admin.scholarships.update', $scholarship->id) }}" method="POST" class="p-8 space-y-8">
                @csrf
                @method('PUT')

                {{-- Program Name --}}
                <div class="space-y-2">
                    <div class="flex items-center justify-between">
                        <label for="name" class="text-[10px] font-bold uppercase tracking-widest text-neutral-heading">
                            Official Program Name <span class="text-brand-crimson">*</span>
                        </label>
                    </div>
                    <input type="text" name="name" id="name"
                        value="{{ old('name', $scholarship->name) }}"
                        class="w-full border-neutral-divider rounded-none shadow-sm focus:ring-brand-navy focus:border-brand-navy text-sm font-serif p-3"
                        required>
                </div>

                <hr class="border-neutral-divider">

                {{-- Program Description --}}
                <div class="space-y-2">
                    <label for="description" class="text-[10px] font-bold uppercase tracking-widest text-neutral-heading">
                        Program Description & Criteria
                    </label>
                    <textarea name="description" id="description" rows="6"
                        class="w-full border-neutral-divider rounded-none shadow-sm focus:ring-brand-navy focus:border-brand-navy text-sm leading-relaxed p-4"
                        placeholder="Detail the scope and eligibility of this scholarship...">{{ old('description', $scholarship->description) }}</textarea>
                </div>

                {{-- Submission Footer --}}
                <div class="pt-6 border-t border-neutral-divider flex items-center justify-between">
                    <p class="text-[9px] text-gray-400 font-bold uppercase tracking-widest">
                        Last modified: {{ $scholarship->updated_at->format('F d, Y - h:i A') }} ({{ $scholarship->updated_at->diffForHumans() }}) 
                    </p>

                    <div class="flex items-center space-x-4">
                        <a href="{{ route('admin.scholarships.index') }}"
                            class="px-6 py-3 text-[10px] font-bold text-neutral-heading uppercase tracking-[0.2em] hover:text-brand-navy transition-colors">
                            Discard Changes
                        </a>

                        <button type="submit"
                            class="bg-brand-navy hover:bg-opacity-90 text-white px-8 py-3 text-[10px] font-bold uppercase tracking-[0.2em] shadow-sm transition-all focus:outline-none focus:ring-2 focus:ring-brand-navy focus:ring-offset-2">
                            Commit Update
                        </button>
                    </div>
                </div>

            </form>
        </div>
        
        <p class="mt-6 text-center text-[9px] text-gray-400 uppercase tracking-[0.3em]">
            This action will be logged in the administrative audit trail.
        </p>

    </div>
</x-app-layout>