<x-app-layout>
    <x-slot name="header">
        <h2 class="font-serif text-3xl text-brand-navy font-bold leading-tight tracking-tight">
            {{ __('Available Scholarships') }}
        </h2>
        <p class="text-xs text-neutral-body uppercase tracking-[0.2em] font-semibold mt-1">
            Browse and apply available scholarships
        </p>
    </x-slot>

    <div class="max-w-7xl mx-auto py-10 px-4 sm:px-6 lg:px-8">

        {{-- Search and Sort Bar --}}
        <div class="mb-6 flex flex-col md:flex-row md:items-center md:justify-between gap-4">
            <form action="{{ route('student.scholarships.index') }}" method="GET" class="relative flex-1 max-w-md">
                <input type="text" name="search" value="{{ request('search') }}"
                    placeholder="Search programs..."
                    class="w-full pl-10 pr-4 py-2 border border-neutral-divider focus:ring-brand-navy focus:border-brand-navy text-sm">
                <div class="absolute left-3 top-2.5 text-gray-400">
                    <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                    </svg>
                </div>
            </form>

            <div class="flex items-center gap-2">
                <span class="text-[10px] font-bold uppercase tracking-widest text-neutral-body">Sort By:</span>
                <a href="{{ route('student.scholarships.index', ['sort' => 'name', 'direction' => request('direction') == 'asc' ? 'desc' : 'asc', 'search' => request('search')]) }}"
                    class="px-3 py-1 border border-neutral-divider text-[10px] font-bold uppercase hover:bg-gray-50 transition">
                    Name {{ request('sort') == 'name' ? (request('direction') == 'asc' ? '↑' : '↓') : '' }}
                </a>
                <a href="{{ route('student.scholarships.index', ['sort' => 'updated_at', 'direction' => request('direction') == 'asc' ? 'desc' : 'asc', 'search' => request('search')]) }}"
                    class="px-3 py-1 border border-neutral-divider text-[10px] font-bold uppercase hover:bg-gray-50 transition">
                    Date {{ request('sort') == 'updated_at' || !request('sort') ? (request('direction') == 'asc' ? '↑' : '↓') : '' }}
                </a>
            </div>
        </div>

        {{-- Formal Table Card --}}
        <div class="bg-white border border-neutral-divider shadow-sm rounded-none overflow-hidden">
            <div class="p-6 border-b border-neutral-divider bg-gray-50/50">
                <h3 class="text-sm font-bold text-brand-navy uppercase tracking-widest">
                    Academic Opportunities
                </h3>
            </div>

            <table class="w-full text-sm text-left">
                <thead>
                    <tr class="bg-brand-navy text-white uppercase text-[10px] tracking-[0.15em]">
                        <th class="px-8 py-4 font-bold">Scholarship Program</th>
                        <th class="px-8 py-4 font-bold">Details & Eligibility</th>
                        <th class="px-8 py-4 font-bold text-right">Status / Action</th>
                    </tr>
                </thead>

                <tbody class="divide-y divide-neutral-divider">
                    @forelse($scholarships as $s)
                    @php
                    $alreadyApplied = in_array($s->id, $appliedScholarships);
                    @endphp

                    <tr class="hover:bg-gray-50 transition-colors duration-200">
                        <td class="px-8 py-6 align-top">
                            <div class="flex flex-col">
                                <span class="text-base font-serif font-bold text-neutral-heading">
                                    {{ $s->name }}
                                </span>
                                @if($alreadyApplied)
                                <span class="mt-2 inline-flex items-center text-[10px] font-bold text-green-700 uppercase tracking-wider">
                                    <svg class="w-3 h-3 me-1" fill="currentColor" viewBox="0 0 20 20">
                                        <path d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" />
                                    </svg>
                                    Applied
                                </span>
                                @endif
                            </div>
                        </td>

                        <td class="px-8 py-6 align-top">
                            <p class="text-neutral-body leading-relaxed max-w-md">
                                {{ $s->description }}
                            </p>
                        </td>

                        <td class="px-8 py-6 text-right align-top">
                            @if($hasPending)
                            <span class="inline-block border border-brand-navy/20 px-4 py-2 text-[10px] font-bold text-brand-navy uppercase tracking-widest bg-gray-50">
                                Application Under Review
                            </span>
                            @elseif($alreadyApplied)
                            <span class="inline-block border border-neutral-divider px-4 py-2 text-[10px] font-bold text-neutral-body uppercase tracking-widest">
                                Grant Applied
                            </span>
                            @else
                            <a href="{{ route('student.applications.create', ['scholarship_id' => $s->id]) }}"
                                class="inline-block bg-brand-crimson hover:bg-[#8B1426] text-white px-6 py-2.5 rounded-none text-[10px] font-bold uppercase tracking-[0.2em] shadow-sm transition-all duration-200 active:scale-95">
                                Apply Now
                            </a>
                            @endif
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="3" class="px-8 py-20 text-center">
                            <h3 class="text-lg font-serif font-bold text-neutral-heading">No Results Found</h3>
                            <p class="text-sm text-neutral-body uppercase tracking-widest mt-1">Try adjusting your search or filters.</p>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</x-app-layout>