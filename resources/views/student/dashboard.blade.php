<x-app-layout>
    <x-slot name="header">
        <h2 class="font-serif text-3xl text-brand-navy font-bold leading-tight tracking-tight">
            {{ __('Student Dashboard') }}
        </h2>
        <p class="text-xs text-neutral-body uppercase tracking-[0.2em] font-semibold mt-1">
            Academic Year 2025-2026 • Portal Overview
        </p>
    </x-slot>

    <div class="max-w-7xl mx-auto py-10 px-4 sm:px-6 lg:px-8 space-y-10">

        {{-- SUCCESS MESSAGE --}}
        @if(session('success'))
        <div class="bg-white border border-green-200 p-4 shadow-sm flex items-center space-x-3" role="alert">
            <div class="bg-green-100 p-2 text-green-600">
                <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />
                </svg>
            </div>
            <div>
                <p class="font-bold text-[10px] uppercase tracking-widest text-green-800">System Notification</p>
                <p class="text-sm text-green-700">{{ session('success') }}</p>
            </div>
        </div>
        @endif

        {{-- 1. SNAPSHOT SECTION --}}
        <section>
            <div class="flex items-end justify-between mb-6">
                <div>
                    <h3 class="font-serif text-2xl font-bold text-brand-navy tracking-tight">Application Snapshot</h3>
                    <div class="h-1 w-12 bg-brand-crimson mt-2"></div>
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                <x-dashboard-card title="Total Submissions" :value="$totalApplications" type="primary">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                    </svg>
                </x-dashboard-card>

                <x-dashboard-card title="Under Review" :value="$pendingCount" type="primary">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                </x-dashboard-card>

                <x-dashboard-card title="Approved Grants" :value="$approvedCount" type="secondary">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                </x-dashboard-card>
            </div>
        </section>

        {{-- 2. ANNOUNCEMENTS SECTION (The Miniature Bulletin) --}}
        <section>
            <div class="bg-white border border-neutral-divider shadow-sm overflow-hidden">
                {{-- Header --}}
                <div class="bg-brand-navy px-6 py-4 flex justify-between items-center">
                    <div class="flex items-center space-x-2">
                        <svg class="w-4 h-4 text-white/70" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9" />
                        </svg>
                        <h3 class="font-serif font-bold text-lg text-white tracking-wide">University Announcement</h3>
                    </div>
                    <a href="{{ route('student.announcements.index') }}"
                        class="text-[10px] font-bold text-white/80 uppercase tracking-[0.2em] hover:text-white transition-colors flex items-center">
                        View All Announcements
                        <svg class="w-3 h-3 ms-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path d="M17 8l4 4m0 0l-4 4m4-4H3" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                        </svg>
                    </a>
                </div>

                {{-- List --}}
                <div class="divide-y divide-neutral-divider">
                    @forelse($announcements as $a)
                    <div class="flex flex-col md:flex-row group hover:bg-gray-50/50 transition-colors">
                        {{-- Mini Date Sidebar --}}
                        <div class="md:w-32 bg-gray-50/50 p-4 border-b md:border-b-0 md:border-r border-neutral-divider flex flex-col justify-center items-center">
                            <span class="text-[9px] uppercase tracking-widest font-bold text-brand-navy/50">
                                {{ $a->updated_at > $a->created_at ? 'Updated' : 'Posted' }}
                            </span>
                            <span class="text-lg font-serif font-bold text-brand-navy">
                                {{ $a->updated_at->format('M d') }}
                            </span>
                        </div>

                        {{-- Mini Content --}}
                        <div class="flex-1 p-5">
                            <div class="flex items-center space-x-2 mb-1">
                                <span class="h-1.5 w-1.5 bg-brand-crimson rounded-none"></span>
                                <h4 class="font-serif font-bold text-neutral-heading text-md group-hover:text-brand-navy transition-colors">
                                    {{ $a->title }}
                                </h4>
                            </div>
                            <p class="text-neutral-body text-xs leading-relaxed line-clamp-2">
                                {{ Str::limit($a->message, 150) }}
                            </p>
                            <div class="mt-3 flex items-center justify-between">
                                <span class="text-[9px] font-bold text-gray-400 uppercase tracking-widest">
                                    Ref: {{ $a->updated_at->diffForHumans() }}
                                </span>
                            </div>
                        </div>
                    </div>
                    @empty
                    <div class="text-center py-12">
                        <svg class="mx-auto h-8 w-8 text-neutral-divider mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4" stroke-width="1.5" />
                        </svg>
                        <p class="text-neutral-body italic text-xs uppercase tracking-widest">No active announcements at this time</p>
                    </div>
                    @endforelse
                </div>
            </div>
        </section>

    </div>
</x-app-layout>