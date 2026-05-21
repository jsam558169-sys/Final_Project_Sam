<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4">
            <div>
                <h2 class="font-serif text-3xl font-bold text-brand-navy leading-tight tracking-tight">
                    {{ __('Application History') }}
                </h2>
                <p class="text-xs text-neutral-body uppercase tracking-[0.2em] font-semibold mt-1">
                    Monitor the status and progression of your financial aid requests
                </p>
            </div>

            <a href="{{ route('student.scholarships.index') }}"
                class="inline-flex items-center justify-center border border-brand-navy text-brand-navy px-5 py-2.5 text-[10px] font-bold uppercase tracking-[0.2em] hover:bg-brand-navy hover:text-white transition-all">
                <svg class="w-4 h-4 me-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10" />
                </svg>
                Browse Available Grants
            </a>
        </div>
    </x-slot>

    <div class="max-w-7xl mx-auto py-10 px-4 sm:px-6 lg:px-8">

        {{-- STATUS NOTIFICATION --}}
        @if(session('success'))
        <div class="bg-white border border-green-200 p-4 shadow-sm flex items-center space-x-3 mb-8">
            <div class="bg-green-100 p-2 text-green-600">
                <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />
                </svg>
            </div>
            <div>
                <p class="font-bold text-[10px] uppercase tracking-widest text-green-800">System Update</p>
                <p class="text-sm text-green-700">{{ session('success') }}</p>
            </div>
        </div>
        @endif

        {{-- APPLICATIONS TABLE --}}
        <div class="bg-white border border-neutral-divider shadow-sm overflow-hidden">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="bg-neutral-bg border-b border-neutral-divider">
                        <th class="px-6 py-4 text-[10px] font-bold uppercase tracking-widest text-neutral-heading">Ref ID</th>
                        <th class="px-6 py-4 text-[10px] font-bold uppercase tracking-widest text-neutral-heading">Degree / Course</th>
                        <th class="px-6 py-4 text-[10px] font-bold uppercase tracking-widest text-neutral-heading">Level</th>
                        <th class="px-6 py-4 text-[10px] font-bold uppercase tracking-widest text-neutral-heading">Review Status</th>
                        <th class="px-6 py-4 text-[10px] font-bold uppercase tracking-widest text-neutral-heading">Office Remarks</th>
                        <th class="px-6 py-4 text-[10px] font-bold uppercase tracking-widest text-neutral-heading">Filing Date</th>
                        <th class="px-6 py-4 text-[10px] font-bold uppercase tracking-widest text-neutral-heading text-right">Dossier</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-neutral-divider">
                    @forelse($applications as $app)
                    <tr class="hover:bg-gray-50/50 transition-colors group">

                        {{-- Ref ID --}}
                        <td class="px-6 py-5">
                            <span class="font-mono text-xs font-bold text-brand-navy">
                                #APP-{{ str_pad($app->id, 5, '0', STR_PAD_LEFT) }}
                            </span>
                        </td>

                        {{-- Course --}}
                        <td class="px-6 py-5">
                            <p class="text-sm font-medium text-neutral-heading capitalize">{{ $app->course }}</p>
                        </td>

                        {{-- Year --}}
                        <td class="px-6 py-5 text-sm text-neutral-body">
                            Year {{ $app->year_level }}
                        </td>

                        {{-- Status --}}
                        <td class="px-6 py-5">
                            @php
                            $statusClasses = [
                            'Approved' => 'bg-green-50 text-green-700 border-green-200',
                            'Pending' => 'bg-amber-50 text-amber-700 border-amber-200',
                            'Rejected' => 'bg-red-50 text-brand-crimson border-red-200',
                            ][$app->status] ?? 'bg-gray-50 text-gray-700 border-gray-200';
                            @endphp
                            <span class="inline-block px-2.5 py-1 text-[9px] font-black uppercase tracking-tighter border {{ $statusClasses }}">
                                {{ $app->status }}
                            </span>
                        </td>

                        {{-- Remarks --}}
                        <td class="px-6 py-5">
                            <p class="text-xs text-neutral-body italic truncate max-w-[150px]">
                                {{ $app->remarks ?? 'Pending assessment...' }}
                            </p>
                        </td>

                        {{-- Date --}}
                        <td class="px-6 py-5 text-xs text-neutral-body font-medium">
                            {{ $app->created_at->format('d M Y') }}
                        </td>

                        {{-- Action --}}
                        <td class="px-6 py-5 text-right">
                            <a href="{{ route('student.applications.view', $app) }}"
                                class="inline-flex items-center text-[10px] font-bold uppercase tracking-widest text-brand-navy hover:text-brand-crimson transition-colors group">
                                View File
                                <svg class="w-3 h-3 ms-1 transform group-hover:translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                                </svg>
                            </a>
                        </td>

                    </tr>
                    @empty
                    <tr>
                        <td colspan="7" class="px-6 py-20 text-center">
                            <div class="flex flex-col items-center">
                                <svg class="w-12 h-12 text-neutral-divider mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                                </svg>
                                <p class="text-lg font-serif font-bold text-neutral-heading italic">No active records found.</p>
                                <p class="text-[10px] text-neutral-body uppercase tracking-widest mt-1">You have not submitted any formal applications yet.</p>
                            </div>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        {{-- Summary Info --}}
        <div class="mt-6 border-t border-neutral-divider pt-6 flex flex-col md:flex-row justify-between items-center text-[9px] font-bold text-gray-400 uppercase tracking-[0.2em]">
            <p>Showing {{ $applications->count() }} Record(s)</p>
            <p>Institutional Scholarship Registry • v1.0</p>
        </div>
    </div>
</x-app-layout>