<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center space-x-4">
            <a href="{{ route('admin.announcements.index') }}" class="text-brand-navy hover:text-brand-crimson transition-colors">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/></svg>
            </a>
            <div>
                <h2 class="font-serif text-3xl font-bold text-brand-navy leading-tight tracking-tight">
                    {{ __('View Announcement') }}
                </h2>
                <p class="text-xs text-neutral-body uppercase tracking-[0.2em] font-semibold mt-1">
                    Official University Communication Details
                </p>
            </div>
        </div>
    </x-slot>

    <div class="max-w-4xl mx-auto py-10 px-6">
        <article class="bg-white border border-neutral-divider shadow-sm overflow-hidden">
            {{-- Header/Date --}}
            <div class="bg-gray-50 border-b border-neutral-divider px-8 py-6 flex justify-between items-center">
                <div class="flex items-center space-x-4">
                    <div class="text-center border-r border-neutral-divider pr-4">
                        <p class="text-2xl font-serif font-bold text-brand-navy">{{ $announcement->created_at->format('d') }}</p>
                        <p class="text-[10px] font-bold uppercase text-gray-400">{{ $announcement->created_at->format('M Y') }}</p>
                    </div>
                    <div>
                        <p class="text-[10px] font-bold uppercase tracking-widest text-brand-crimson">Published Headline</p>
                        <h1 class="text-2xl font-serif font-bold text-brand-navy leading-tight">{{ $announcement->title }}</h1>
                    </div>
                </div>
            </div>

            {{-- Message Body --}}
            <div class="p-8">
                <div class="prose max-w-none text-neutral-body leading-relaxed whitespace-pre-wrap">
                    {{ $announcement->message }}
                </div>
            </div>

            {{-- Footer Info --}}
            <div class="bg-gray-50 border-t border-neutral-divider px-8 py-4 flex justify-between items-center text-[10px] font-bold uppercase tracking-widest text-gray-400">
                <div class="flex items-center space-x-4">
                    <span>Posted: {{ $announcement->created_at->format('h:i A') }}</span>
                    @if($announcement->updated_at != $announcement->created_at)
                        <span class="text-brand-crimson/70">Last Edited: {{ $announcement->updated_at->diffForHumans() }}</span>
                    @endif
                </div>
                <div class="flex space-x-3">
                    <a href="{{ route('admin.announcements.edit', $announcement->id) }}" class="text-brand-navy hover:underline">Modify Content</a>
                </div>
            </div>
        </article>
    </div>
</x-app-layout>