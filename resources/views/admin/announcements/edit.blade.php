<x-app-layout>

    <x-slot name="header">
        <div class="flex items-center justify-between">
            <div>
                <h2 class="font-serif text-3xl font-bold text-brand-navy leading-tight tracking-tight">
                    {{ __('Revise Announcement') }}
                </h2>
                <p class="text-xs text-neutral-body uppercase tracking-[0.2em] font-semibold mt-1">
                    System Ref: #{{ $announcement->id }} • Edit Mode
                </p>
            </div>
            
            {{-- Back to Archive Link --}}
            <a href="{{ route('admin.announcements.index') }}" class="text-[10px] font-bold text-neutral-body uppercase tracking-widest hover:text-brand-navy transition-colors flex items-center">
                <svg class="w-3 h-3 me-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/></svg>
                Return to Archive
            </a>
        </div>
    </x-slot>

    <div class="max-w-4xl mx-auto py-10 px-4 sm:px-6 lg:px-8">

        <div class="bg-white border border-neutral-divider shadow-sm rounded-none overflow-hidden">
            
            {{-- Form Header --}}
            <div class="bg-brand-navy px-8 py-5 flex items-center space-x-3">
                <svg class="w-5 h-5 text-white/70" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg>
                <h3 class="font-serif font-bold text-xl text-white tracking-wide">Bulletin Revision Form</h3>
            </div>

            {{-- Metadata Bar --}}
            <div class="bg-gray-50 border-b border-neutral-divider px-8 py-4 flex flex-wrap items-center gap-6 text-[10px] font-bold uppercase tracking-widest text-gray-500">
                <span class="flex items-center">
                    <svg class="w-3 h-3 me-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                    Original Post: {{ $announcement->created_at->format('M d, Y - h:i A') }}
                </span>
                
                @if($announcement->updated_at != $announcement->created_at)
                <span class="flex items-center text-brand-crimson/70">
                    <svg class="w-3 h-3 me-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                    Last Modified: {{ $announcement->updated_at->format('M d, Y - h:i A') }}
                </span>
                @endif
            </div>

            {{-- The Form --}}
            <form method="POST" action="{{ route('admin.announcements.update', $announcement->id) }}" class="p-8 space-y-6">
                @csrf
                @method('PUT')

                {{-- Title Input --}}
                <div>
                    <x-input-label for="title" :value="__('Headline')" class="text-[10px] font-bold uppercase tracking-widest text-neutral-heading mb-2" />
                    <x-text-input id="title" name="title" type="text" 
                        class="block w-full border-neutral-divider focus:ring-brand-navy focus:border-brand-navy rounded-none shadow-sm text-sm font-serif" 
                        value="{{ old('title', $announcement->title) }}" required autofocus />
                </div>

                {{-- Message Textarea --}}
                <div>
                    <x-input-label for="message" :value="__('Message Body')" class="text-[10px] font-bold uppercase tracking-widest text-neutral-heading mb-2" />
                    <textarea id="message" name="message" 
                        class="block w-full border-neutral-divider focus:ring-brand-navy focus:border-brand-navy rounded-none shadow-sm text-sm min-h-[240px] resize-y p-4 leading-relaxed text-neutral-body" 
                        required>{{ old('message', $announcement->message) }}</textarea>
                </div>

                {{-- Form Actions --}}
                <div class="pt-6 border-t border-neutral-divider flex items-center justify-end space-x-4">
                    <a href="{{ route('admin.announcements.index') }}" 
                        class="px-6 py-3 border border-neutral-divider text-[10px] font-bold text-neutral-heading uppercase tracking-[0.2em] hover:bg-gray-50 hover:border-gray-300 transition-colors">
                        Cancel Revision
                    </a>
                    
                    <button type="submit" 
                        class="bg-brand-navy hover:bg-opacity-90 text-white px-8 py-3 text-[10px] font-bold uppercase tracking-[0.2em] shadow-sm transition-all focus:outline-none focus:ring-2 focus:ring-brand-navy focus:ring-offset-2">
                        Update & Publish
                    </button>
                </div>
            </form>

        </div>
    </div>

</x-app-layout>