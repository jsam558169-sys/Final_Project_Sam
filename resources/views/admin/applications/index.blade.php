<x-app-layout>
    <x-slot name="header">
        <h2 class="font-serif text-3xl font-bold text-brand-navy leading-tight tracking-tight">
            {{ __('Application Ledger') }}
        </h2>
        <p class="text-xs text-neutral-body uppercase tracking-[0.2em] font-semibold mt-1">
            Review and Process Scholarship Submissions
        </p>
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
                <p class="font-bold text-[10px] uppercase tracking-widest text-green-800">Ledger Updated</p>
                <p class="text-sm text-green-700">{{ session('success') }}</p>
            </div>
        </div>
        @endif

        {{-- SEARCH AND SORT CONTROLS --}}
        <div class="mb-6 flex flex-col md:flex-row md:items-center justify-between gap-4">
            <form action="{{ route('admin.applications.index') }}" method="GET" class="flex w-full md:w-1/2">
                <input type="text" name="search" value="{{ request('search') }}"
                    placeholder="Search students or ID..."
                    class="w-full border-neutral-divider rounded-none focus:ring-brand-navy focus:border-brand-navy text-sm p-2">

                <button type="submit" class="bg-brand-navy text-white px-4 py-2 text-[10px] font-bold uppercase tracking-widest hover:bg-opacity-90 transition-colors">
                    Search
                </button>

                @php
                $hasFilters = request('search') || request('sort');
                @endphp

                <a
                    @if($hasFilters) href="{{ route('admin.applications.index') }}" @endif
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

                {{-- Sort by Scholarship Name --}}
                <a href="{{ route('admin.applications.index', ['sort' => 'scholarship', 'direction' => request('direction') == 'asc' ? 'desc' : 'asc', 'search' => request('search')]) }}"
                    class="text-[10px] font-bold uppercase border-b-2 {{ request('sort') == 'scholarship' ? 'border-brand-navy' : 'border-transparent text-gray-400' }}">
                    Scholarship {{ request('sort') == 'scholarship' ? (request('direction') == 'asc' ? '↑' : '↓') : '' }}
                </a>

                {{-- Sort by Student Name --}}
                <a href="{{ route('admin.applications.index', ['sort' => 'student_name', 'direction' => request('direction') == 'asc' ? 'desc' : 'asc', 'search' => request('search')]) }}"
                    class="text-[10px] font-bold uppercase border-b-2 {{ request('sort') == 'student_name' ? 'border-brand-navy' : 'border-transparent text-gray-400' }}">
                    Student {{ request('sort') == 'student_name' ? (request('direction') == 'asc' ? '↑' : '↓') : '' }}
                </a>

                {{-- Sort by Date (Latest) --}}
                <a href="{{ route('admin.applications.index', ['sort' => 'created_at', 'direction' => request('direction') == 'asc' ? 'desc' : 'asc', 'search' => request('search')]) }}"
                    class="text-[10px] font-bold uppercase border-b-2 {{ request('sort') == 'created_at' || !request('sort') ? 'border-brand-navy' : 'border-transparent text-gray-400' }}">
                    Date {{ request('sort') == 'created_at' ? (request('direction') == 'asc' ? '↑' : '↓') : '' }}
                </a>
            </div>
        </div>

        <div class="bg-white border border-neutral-divider shadow-sm overflow-hidden">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="bg-brand-navy text-white">
                        <th class="px-6 py-4 text-[10px] font-bold uppercase tracking-widest">Student Info</th>
                        <th class="px-6 py-4 text-[10px] font-bold uppercase tracking-widest">Academic Track</th>
                        <th class="px-6 py-4 text-[10px] font-bold uppercase tracking-widest">Scholarship Program</th>
                        <th class="px-6 py-4 text-[10px] font-bold uppercase tracking-widest text-center">Status</th>
                        <th class="px-6 py-4 text-[10px] font-bold uppercase tracking-widest">Submitted</th>
                        <th class="px-6 py-4 text-[10px] font-bold uppercase tracking-widest">Documents</th>
                        <th class="px-6 py-4 text-[10px] font-bold uppercase tracking-widest text-right">Administrative</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-neutral-divider">
                    @forelse($applications as $app)
                    <tr class="hover:bg-gray-50/50 transition-colors group">

                        {{-- Student Info --}}
                        <td class="px-6 py-5">
                            <div class="text-sm font-bold text-neutral-heading">{{ $app->student_name ?? 'Unknown Student' }}</div>

                            <div class="text-[10px] text-brand-navy/70 font-medium">ID: {{ $app->studentID }}</div>
                        </td>

                        {{-- Academic Track --}}
                        <td class="px-6 py-5">
                            <div class="text-sm text-neutral-body font-medium">{{ $app->course }}</div>
                            <div class="text-[10px] text-brand-navy/60 font-bold uppercase tracking-widest mt-1">
                                Level: {{ $app->year_level }}
                            </div>
                        </td>

                        <td class="px-6 py-5">
                            <div class="text-sm text-neutral-body font-bold">
                                {{ $app->scholarship->name ?? 'Not Specified' }}
                            </div>
                            <div class="text-[10px] text-brand-navy/60 font-medium mt-1 italic">
                                Ref ID: #{{ $app->scholarship_id }}
                            </div>
                        </td>

                        {{-- Status Badge --}}
                        <td class="px-6 py-5 text-center">
                            @php
                            $statusClasses = match($app->status) {
                            'Approved' => 'bg-green-50 text-green-700 border-green-200',
                            'Rejected' => 'bg-red-50 text-red-700 border-red-200',
                            default => 'bg-amber-50 text-amber-700 border-amber-200',
                            };
                            @endphp
                            <span class="inline-block px-3 py-1 text-[10px] font-bold uppercase tracking-widest border {{ $statusClasses }}">
                                {{ $app->status }}
                            </span>
                        </td>

                        {{-- Submitted Date --}}
                        <td class="px-6 py-5 text-sm text-neutral-body">
                            {{ $app->created_at->format('M d, Y') }}
                        </td>

                        {{-- Documents --}}
                        <td class="px-6 py-5">
                            <div class="flex items-center space-x-2">
                                @foreach(['proof_of_income' => 'Income', 'report_card' => 'Grades', 'birth_certificate' => 'Birth'] as $field => $label)
                                @if($app->$field)
                                <div class="group/doc relative">
                                    <a href="{{ asset('storage/' . $app->$field) }}" target="_blank"
                                        class="inline-flex items-center justify-center w-8 h-8 border border-neutral-divider bg-white text-neutral-body hover:border-brand-navy hover:text-brand-navy transition-all">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                                        </svg>
                                    </a>
                                    <span class="absolute bottom-full left-1/2 -translate-x-1/2 mb-2 hidden group-hover/doc:block bg-brand-navy text-white text-[9px] px-2 py-1 uppercase tracking-widest whitespace-nowrap">
                                        {{ $label }}
                                    </span>
                                </div>
                                @endif
                                @endforeach
                            </div>
                        </td>

                        {{-- Administrative Actions --}}
                        <td class="px-6 py-5 text-right">
                            <div class="flex justify-end items-center space-x-3">
                                <a href="{{ route('admin.applications.edit', $app) }}"
                                    class="text-[10px] font-bold uppercase tracking-[0.15em] text-brand-navy hover:text-brand-crimson transition-colors">
                                    Review
                                </a>

                                <form action="{{ route('admin.applications.destroy', $app) }}" method="POST" class="inline">
                                    @csrf @method('DELETE')
                                    <button type="submit"
                                        onclick="return confirm('Confirm permanent deletion of this record?')"
                                        class="text-[10px] font-bold uppercase tracking-[0.15em] text-gray-300 hover:text-red-600 transition-colors">
                                        Delete
                                    </button>
                                </form>
                            </div>
                        </td>

                    </tr>
                    @empty
                    <tr>
                        <td colspan="6" class="px-6 py-20 text-center">
                            <p class="text-xs text-neutral-body uppercase tracking-[0.2em] italic font-medium">No scholarship applications found in the ledger.</p>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</x-app-layout>