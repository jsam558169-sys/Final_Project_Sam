<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4">
            <div>
                <h2 class="font-serif text-3xl font-bold text-brand-navy leading-tight tracking-tight">
                    {{ __('Scholarship Program Catalog') }}
                </h2>
                <p class="text-xs text-neutral-body uppercase tracking-[0.2em] font-semibold mt-1">
                    Manage Active Grants and Financial Assistance Programs
                </p>
            </div>

            <a href="{{ route('admin.scholarships.create') }}"
                class="inline-flex items-center justify-center bg-brand-navy hover:bg-opacity-90 text-white px-6 py-3 text-[10px] font-bold uppercase tracking-[0.2em] shadow-sm transition-all focus:outline-none focus:ring-2 focus:ring-brand-navy focus:ring-offset-2">
                <svg class="w-4 h-4 me-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                </svg>
                Add New Program
            </a>
        </div>
    </x-slot>

    <div class="max-w-7xl mx-auto py-10 px-4 sm:px-6 lg:px-8">

        {{-- SUCCESS NOTIFICATION --}}
        @if(session('success'))
        <div class="bg-white border border-green-200 p-4 shadow-sm flex items-center space-x-3 mb-8" role="alert">
            <div class="bg-green-100 p-2 text-green-600">
                <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />
                </svg>
            </div>
            <div>
                <p class="font-bold text-[10px] uppercase tracking-widest text-green-800">Catalog Updated</p>
                <p class="text-sm text-green-700">{{ session('success') }}</p>
            </div>
        </div>
        @endif

        {{-- SEARCH AND SORT CONTROLS --}}
        <div class="mb-6 flex flex-col md:flex-row md:items-center justify-between gap-4">
            <form action="{{ route('admin.scholarships.index') }}" method="GET" class="flex w-full md:w-1/2">
                <input type="text" name="search" value="{{ request('search') }}"
                    placeholder="Search programs..."
                    class="w-full border-neutral-divider rounded-none focus:ring-brand-navy focus:border-brand-navy text-sm p-2">

                <button type="submit" class="bg-brand-navy text-white px-4 py-2 text-[10px] font-bold uppercase tracking-widest hover:bg-opacity-90 transition-colors">
                    Search
                </button>

                {{-- ALWAYS VISIBLE CLEAR BUTTON --}}
                @php
                $hasFilters = request('search') || request('sort');
                @endphp

                <a
                    @if($hasFilters) href="{{ route('admin.scholarships.index') }}" @endif
                    class="px-4 py-2 text-[10px] font-bold uppercase tracking-widest flex items-center transition-all border
    {{ $hasFilters 
        ? 'bg-white text-brand-navy border-brand-navy hover:bg-gray-50 cursor-pointer shadow-sm' 
        : 'bg-gray-50 text-gray-300 border-neutral-divider cursor-not-allowed opacity-60' }}"
                    title="{{ $hasFilters ? 'Clear all filters' : 'No filters applied' }}">

                    <svg class="w-3 h-3 me-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                    Clear
                </a>
            </form>

            <div class="flex items-center space-x-4">
                <span class="text-[10px] font-bold uppercase tracking-widest text-neutral-body">Sort By:</span>
                <a href="{{ route('admin.scholarships.index', ['sort' => 'name', 'direction' => request('direction') == 'asc' ? 'desc' : 'asc', 'search' => request('search')]) }}"
                    class="text-[10px] font-bold uppercase border-b-2 {{ request('sort') == 'name' ? 'border-brand-navy' : 'border-transparent text-gray-400' }}">
                    Name {{ request('sort') == 'name' ? (request('direction') == 'asc' ? '↑' : '↓') : '' }}
                </a>
                <a href="{{ route('admin.scholarships.index', ['sort' => 'updated_at', 'direction' => request('direction') == 'asc' ? 'desc' : 'asc', 'search' => request('search')]) }}"
                    class="text-[10px] font-bold uppercase border-b-2 {{ request('sort') == 'updated_at' || !request('sort') ? 'border-brand-navy' : 'border-transparent text-gray-400' }}">
                    Latest {{ request('sort') == 'updated_at' ? (request('direction') == 'asc' ? '↑' : '↓') : '' }}
                </a>
            </div>
        </div>

        {{-- PROGRAM TABLE --}}
        <div class="bg-white border border-neutral-divider shadow-sm overflow-hidden">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="bg-brand-navy text-white">
                        <th class="px-8 py-4 text-[10px] font-bold uppercase tracking-widest w-1/3">
                            <a href="{{ route('admin.scholarships.index', ['sort' => 'name', 'direction' => request('direction') == 'asc' ? 'desc' : 'asc']) }}" class="hover:text-gray-300">
                                Scholarship Name
                            </a>
                        </th>
                        <th class="px-8 py-4 text-[10px] font-bold uppercase tracking-widest">Program Description</th>
                        <th class="px-8 py-4 text-[10px] font-bold uppercase tracking-widest">Statistics</th>
                        <th class="px-8 py-4 text-[10px] font-bold uppercase tracking-widest">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-neutral-divider">
                    @forelse($scholarships as $s)
                    <tr class="hover:bg-gray-50/50 transition-colors group">
                        {{-- Name --}}
                        <td class="px-8 py-6">
                            <div class="flex items-start space-x-3">
                                <div class="mt-1 h-2 w-2 bg-brand-crimson shrink-0"></div>
                                <div>
                                    <h4 class="font-serif text-lg font-bold text-neutral-heading group-hover:text-brand-navy transition-colors">
                                        {{ $s->name }}
                                    </h4>
                                    <span class="text-[9px] font-bold text-gray-400 uppercase tracking-tighter italic">
                                        Ref ID: SCH-{{ str_pad($s->id, 4, '0', STR_PAD_LEFT) }}
                                    </span>
                                    <span class="text-[8px] text-brand-navy/60 font-semibold uppercase tracking-widest mt-1">
                                        Updated {{ $s->updated_at->diffForHumans() }}
                                    </span>
                                </div>
                            </div>
                        </td>

                        {{-- Description --}}
                        <td class="px-8 py-6">
                            <p class="text-sm text-neutral-body leading-relaxed max-w-xl">
                                {{ $s->description }}
                            </p>
                        </td>

                        <td class="px-8 py-6">
                            <div class="flex flex-col gap-1">
                                <span class="inline-flex items-center px-2 py-0.5 rounded text-[10px] font-bold uppercase tracking-wider bg-blue-100 text-blue-800">
                                    Total: {{ $s->total_applicants }}
                                </span>
                                <span class="inline-flex items-center px-2 py-0.5 rounded text-[10px] font-bold uppercase tracking-wider bg-green-100 text-green-800">
                                    Approved: {{ $s->approved_count }}
                                </span>
                                <span class="inline-flex items-center px-2 py-0.5 rounded text-[10px] font-bold uppercase tracking-wider bg-yellow-100 text-yellow-800">
                                    Pending: {{ $s->pending_count }}
                                </span>
                                <span class="inline-flex items-center px-2 py-0.5 rounded text-[10px] font-bold uppercase tracking-wider bg-red-100 text-red-800">
                                    Rejected: {{ $s->rejected_count }}
                                </span>
                            </div>
                        </td>

                        {{-- Actions --}}
                        <td class="px-8 py-6 text-right">
                            <div class="flex justify-end items-center space-x-4">
                                <a href="{{ route('admin.scholarships.edit', $s->id) }}"
                                    class="text-[10px] font-bold uppercase tracking-[0.15em] text-brand-navy hover:text-brand-crimson transition-colors flex items-center">
                                    <svg class="w-3 h-3 me-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                                    </svg>
                                    Edit
                                </a>

                                <form action="{{ route('admin.scholarships.destroy', $s->id) }}" method="POST" class="inline">
                                    @csrf @method('DELETE')
                                    <button type="submit"
                                        onclick="return confirm('Archive this program? This will prevent new student applications.')"
                                        class="text-[10px] font-bold uppercase tracking-[0.15em] text-gray-300 hover:text-red-600 transition-colors flex items-center">
                                        <svg class="w-3 h-3 me-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                                        </svg>
                                        Delete
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="3" class="px-8 py-20 text-center">
                            <svg class="mx-auto h-12 w-12 text-neutral-divider mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" />
                            </svg>
                            <h3 class="text-lg font-serif font-bold text-neutral-heading">No Programs Listed</h3>
                            <p class="text-[10px] text-neutral-body uppercase tracking-widest mt-1">The scholarship registry is currently empty.</p>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        {{-- Footer Note --}}
        <div class="mt-6 flex items-center justify-center space-x-2 text-[9px] font-bold text-gray-400 uppercase tracking-widest">
            <span class="h-px w-8 bg-neutral-divider"></span>
            <span>End of Official Catalog</span>
            <span class="h-px w-8 bg-neutral-divider"></span>
        </div>

    </div>
</x-app-layout>