<x-app-layout>

    <x-slot name="header">
        <h2 class="font-serif text-3xl font-bold text-brand-navy leading-tight tracking-tight">
            {{ __('Announcement Management') }}
        </h2>
        <p class="text-xs text-neutral-body uppercase tracking-[0.2em] font-semibold mt-1">
            Publish & Manage Official University Announcement
        </p>
    </x-slot>

    <div class="max-w-7xl mx-auto py-10 px-4 sm:px-6 lg:px-8 space-y-10">

        {{-- SUCCESS NOTIFICATION --}}
        @if(session('success'))
        <div class="bg-white border border-green-200 p-4 shadow-sm flex items-center space-x-3 mb-8" role="alert">
            <div class="bg-green-100 p-2 text-green-600">
                <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/></svg>
            </div>
            <div>
                <p class="font-bold text-[10px] uppercase tracking-widest text-green-800">System Notification</p>
                <p class="text-sm text-green-700">{{ session('success') }}</p>
            </div>
        </div>
        @endif

        {{-- CREATE FORM MODULE --}}
        <section class="bg-white border border-neutral-divider shadow-sm rounded-none overflow-hidden">
            <div class="bg-brand-navy px-8 py-5 flex items-center space-x-3">
                <svg class="w-5 h-5 text-white/70" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg>
                <h3 class="font-serif font-bold text-xl text-white tracking-wide">Compose Official Announcement</h3>
            </div>

            <form method="POST" action="{{ route('admin.announcements.store') }}" class="p-8 space-y-6">
                @csrf

                {{-- Title Input --}}
                <div>
                    <x-input-label for="title" :value="__('Headline')" class="text-[10px] font-bold uppercase tracking-widest text-neutral-heading mb-2" />
                    <x-text-input id="title" name="title" type="text" class="block w-full border-neutral-divider focus:ring-brand-navy focus:border-brand-navy rounded-none shadow-sm text-sm" placeholder="Enter the official headline..." required autofocus />
                </div>

                {{-- Message Textarea --}}
                <div>
                    <x-input-label for="message" :value="__('Message Body')" class="text-[10px] font-bold uppercase tracking-widest text-neutral-heading mb-2" />
                    <textarea id="message" name="message" class="block w-full border-neutral-divider focus:ring-brand-navy focus:border-brand-navy rounded-none shadow-sm text-sm min-h-[160px] resize-y p-3" placeholder="Draft the communication here..." required></textarea>
                </div>

                {{-- Submit Action --}}
                <div class="pt-2 border-t border-neutral-divider flex justify-end">
                    <button type="submit" class="bg-brand-navy hover:bg-opacity-90 text-white px-8 py-3 text-[10px] font-bold uppercase tracking-[0.2em] shadow-sm transition-all focus:outline-none focus:ring-2 focus:ring-brand-navy focus:ring-offset-2">
                        Publish
                    </button>
                </div>
            </form>
        </section>

        {{-- ARCHIVE / LIST SECTION --}}
        <section>
            <div class="flex items-end justify-between mb-6 mt-12">
                <div>
                    <h3 class="font-serif text-2xl font-bold text-brand-navy tracking-tight">Published Archive</h3>
                    <div class="h-1 w-12 bg-brand-crimson mt-2"></div>
                </div>
            </div>

            <div class="space-y-4">
                @forelse($announcements as $a)
                    <article class="bg-white border border-neutral-divider shadow-sm group hover:border-brand-navy/30 transition-colors duration-300 flex flex-col md:flex-row">
                        
                        {{-- Date Sidebar --}}
                        <div class="md:w-32 bg-gray-50/50 p-6 border-b md:border-b-0 md:border-r border-neutral-divider flex flex-col justify-center items-center text-center shrink-0">
                            <span class="text-[10px] uppercase tracking-[0.2em] font-bold text-brand-navy/60 mb-1">Posted</span>
                            <span class="text-xl font-serif font-bold text-brand-navy leading-none">{{ $a->created_at->format('M d') }}</span>
                            <span class="text-xs font-sans text-neutral-body mt-1">{{ $a->created_at->format('Y') }}</span>
                        </div>

                        {{-- Content Area --}}
                        <div class="flex-1 p-6 flex flex-col justify-center">
                            <h4 class="font-serif text-xl font-bold text-neutral-heading mb-2 group-hover:text-brand-navy transition-colors">
                                {{ $a->title }}
                            </h4>
                            <p class="text-sm text-neutral-body leading-relaxed mb-4 line-clamp-2">
                                {{ $a->message }}
                            </p>
                            
                            {{-- Metadata --}}
                            <div class="flex items-center space-x-4 text-[10px] font-bold uppercase tracking-widest text-gray-400">
                                <span class="flex items-center">
                                    <svg class="w-3 h-3 me-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" stroke-width="2" stroke-linecap="round"/></svg>
                                    {{ $a->created_at->format('h:i A') }} ({{ $a->updated_at->diffForHumans() }})
                                </span>
                                @if($a->updated_at && $a->updated_at != $a->created_at)
                                <span class="flex items-center text-brand-crimson/70">
                                    <svg class="w-3 h-3 me-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" stroke-width="2" stroke-linecap="round"/></svg>
                                    Updated
                                    {{ $a->created_at->format('h:i A') }} ({{ $a->updated_at->diffForHumans() }})
                                </span>
                                @endif
                            </div>
                        </div>

{{-- Admin Actions --}}
<div class="md:w-40 bg-white p-6 border-t md:border-t-0 md:border-l border-neutral-divider flex flex-row md:flex-col justify-center gap-2 shrink-0">
    
    {{-- View Button --}}
    <a href="{{ route('admin.announcements.view', $a->id) }}"
        class="flex-1 md:flex-none text-center bg-brand-navy px-4 py-2 text-[10px] font-bold text-white uppercase tracking-widest hover:bg-opacity-90 transition-colors">
        View
    </a>

    {{-- Edit Button --}}
    <a href="{{ route('admin.announcements.edit', $a->id) }}"
        class="flex-1 md:flex-none text-center border border-neutral-divider px-4 py-2 text-[10px] font-bold text-neutral-heading uppercase tracking-widest hover:border-brand-navy hover:text-brand-navy transition-colors">
        Edit
    </a>

    {{-- Delete/Revoke Button --}}
    <form method="POST" action="{{ route('admin.announcements.destroy', $a->id) }}" class="flex-1 md:flex-none flex">
        @csrf
        @method('DELETE')
        <button type="submit"
            onclick="return confirm('Are you sure you want to permanently delete this announcement?')"
            class="w-full text-center border border-brand-crimson/30 px-4 py-2 text-[10px] font-bold text-brand-crimson uppercase tracking-widest hover:bg-brand-crimson hover:text-white transition-colors">
            Revoke
        </button>
    </form>
</div>
                    </article>
                @empty
                    <div class="bg-white border border-neutral-divider py-16 text-center">
                        <svg class="mx-auto h-12 w-12 text-neutral-divider mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M9 13h6m-3-3v6m5 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" stroke-width="1.5"/></svg>
                        <h3 class="text-lg font-serif font-bold text-neutral-heading">Archive Empty</h3>
                        <p class="text-[10px] text-neutral-body uppercase tracking-widest mt-1">No announcements have been published yet.</p>
                    </div>
                @endforelse
            </div>
        </section>

    </div>

</x-app-layout>