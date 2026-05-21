<x-app-layout>
    <x-slot name="header">
        <h2 class="font-serif text-3xl text-brand-navy font-bold leading-tight tracking-tight">
            {{ __('Announcements') }}
        </h2>
        <p class="text-xs text-neutral-body uppercase tracking-[0.2em] font-semibold mt-1">
            View announcements from the Univevrsity
        </p>
    </x-slot>

    <div class="max-w-5xl mx-auto py-10 px-4 sm:px-6 lg:px-8 space-y-8">

        {{-- Search and Sort Header --}}
        <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4 bg-white p-4 border border-neutral-divider shadow-sm">
            {{-- Search Form --}}
            <form action="{{ route('student.announcements.index') }}" method="GET" class="relative flex-1 max-w-md">
                <input type="text" name="search" value="{{ request('search') }}"
                    placeholder="Search announcements..."
                    class="w-full pl-10 pr-4 py-2 border border-neutral-divider focus:ring-brand-navy focus:border-brand-navy text-sm">
                <div class="absolute left-3 top-2.5 text-gray-400">
                    <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                    </svg>
                </div>
            </form>

            {{-- Sort Toggles --}}
            <div class="flex items-center gap-2">
                <span class="text-[10px] font-bold uppercase tracking-widest text-neutral-body">Sort By:</span>

                {{-- Sort by Date --}}
                <a href="{{ route('student.announcements.index', ['sort' => 'updated_at', 'direction' => request('direction') == 'asc' ? 'desc' : 'asc', 'search' => request('search')]) }}"
                    class="px-3 py-1 border {{ request('sort', 'updated_at') == 'updated_at' ? 'border-brand-navy bg-brand-navy text-white' : 'border-neutral-divider text-neutral-body' }} text-[10px] font-bold uppercase hover:opacity-80 transition">
                    Latest {{ request('sort', 'updated_at') == 'updated_at' ? (request('direction') == 'asc' ? '↑' : '↓') : '' }}
                </a>

                {{-- Sort Alphabetically --}}
                <a href="{{ route('student.announcements.index', ['sort' => 'title', 'direction' => request('direction') == 'asc' ? 'desc' : 'asc', 'search' => request('search')]) }}"
                    class="px-3 py-1 border {{ request('sort') == 'title' ? 'border-brand-navy bg-brand-navy text-white' : 'border-neutral-divider text-neutral-body' }} text-[10px] font-bold uppercase hover:opacity-80 transition">
                    Title {{ request('sort') == 'title' ? (request('direction') == 'asc' ? '↑' : '↓') : '' }}
                </a>
            </div>
        </div>

        @forelse($announcements as $a)
        <article class="bg-white border border-neutral-divider shadow-sm group hover:border-brand-navy/30 transition-colors duration-300">
            <div class="flex flex-col md:flex-row">

                {{-- Date Sidebar --}}
                <div class="md:w-48 bg-gray-50 p-6 border-b md:border-b-0 md:border-r border-neutral-divider flex flex-col justify-center items-center text-center">
                    <span class="text-[10px] uppercase tracking-[0.2em] font-bold text-brand-navy/60 mb-1">Posted On</span>
                    <span class="text-xl font-serif font-bold text-brand-navy leading-none">
                        {{ $a->created_at->format('M d') }}
                    </span>
                    <span class="text-sm font-sans text-neutral-body mt-1">
                        {{ $a->created_at->format('Y') }}
                    </span>
                    <div class="h-px w-8 bg-brand-crimson mt-3"></div>
                </div>

                {{-- Content Area --}}
                <div class="flex-1 p-8">
                    <div class="flex justify-between items-start mb-4">
                        <h3 class="font-serif text-2xl text-neutral-heading font-bold leading-snug group-hover:text-brand-navy transition-colors">
                            {{ $a->title }}
                        </h3>

                        {{-- Importance Indicator --}}
                        <span class="flex items-center text-[10px] font-bold uppercase tracking-widest text-brand-navy/40">
                            <span class="h-2 w-2 bg-brand-navy rounded-full me-2"></span>
                            Official
                        </span>
                    </div>

                    <div class="prose prose-sm max-w-none text-neutral-body leading-relaxed font-sans">
                        {{ $a->message }}
                    </div>

                    {{-- Footer Info --}}
                    <div class="mt-8 pt-4 border-t border-gray-100 flex flex-wrap items-center justify-between gap-4">
                        <div class="flex space-x-4 text-[10px] font-bold uppercase tracking-widest text-gray-400">
                            <span class="flex items-center">
                                <svg class="w-3 h-3 me-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" stroke-width="2" stroke-linecap="round" />
                                </svg>
                                {{ $a->created_at->format('h:i A') }}
                            </span>

                            @if($a->updated_at && $a->updated_at != $a->created_at)
                            <span class="flex items-center text-brand-crimson/70">
                                <svg class="w-3 h-3 me-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" stroke-width="2" stroke-linecap="round" />
                                </svg>
                                Updated {{ $a->updated_at->diffForHumans() }}
                            </span>
                            @endif
                        </div>

                        <span class="text-[10px] font-bold text-neutral-body/60 uppercase tracking-tighter italic">
                            &mdash; Scholarship Office Administration
                        </span>
                    </div>
                </div>
            </div>
        </article>
        @empty
        <div class="bg-white border border-neutral-divider py-20 text-center">
            <h3 class="text-xl font-serif font-bold text-neutral-heading">No Matching Announcements</h3>
            <p class="text-xs text-neutral-body uppercase tracking-[0.2em] mt-2">Try adjusting your search criteria.</p>
        </div>
        @endforelse

    </div>

</x-app-layout>