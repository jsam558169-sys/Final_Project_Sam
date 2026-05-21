<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col md:flex-row md:items-center md:justify-between">
            <div>
                <h2 class="font-serif text-3xl font-bold text-brand-navy leading-tight tracking-tight">
                    {{ __('Admin Dashboard') }}
                </h2>
                <p class="text-xs text-neutral-body uppercase tracking-[0.2em] font-semibold mt-1">
                    System Overview & Academic Oversight
                </p>
            </div>
            <div class="mt-4 md:mt-0 text-[10px] font-bold text-gray-400 uppercase tracking-widest border-l-0 md:border-l md:pl-6 border-neutral-divider">
                Session Status: <span class="text-green-600">Active Admin</span>
            </div>
        </div>
    </x-slot>

    <div class="max-w-7xl mx-auto py-10 px-6 space-y-10">

        {{-- SUCCESS MESSAGE --}}
        @if(session('success'))
        <div class="bg-green-50 border-l-4 border-green-500 text-green-800 p-4 shadow-sm flex items-center">
            <svg class="w-5 h-5 mr-3" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/></svg>
            <span class="font-bold text-xs uppercase tracking-wider">{{ session('success') }}</span>
        </div>
        @endif

        {{-- 1. SCHOLARSHIP OVERVIEW --}}
        <section>
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
                <div class="bg-white border border-neutral-divider p-6 shadow-sm group hover:border-brand-navy transition-colors">
                    <p class="text-[10px] font-bold text-gray-400 uppercase tracking-widest mb-1">Total Catalog</p>
                    <p class="text-3xl font-serif font-bold text-brand-navy">{{ $stats['total_scholarships'] }}</p>
                    <p class="text-[9px] text-neutral-body mt-2 italic">Registered Programs</p>
                </div>

                <div class="bg-white border border-neutral-divider p-6 shadow-sm group hover:border-green-600 transition-colors">
                    <p class="text-[10px] font-bold text-gray-400 uppercase tracking-widest mb-1">Active Status</p>
                    <p class="text-3xl font-serif font-bold text-green-700">{{ $stats['active_scholarships'] }}</p>
                    <p class="text-[9px] text-neutral-body mt-2 italic">Currently Accepting</p>
                </div>

                <div class="bg-white border border-neutral-divider p-6 shadow-sm group hover:border-brand-crimson transition-colors">
                    <p class="text-[10px] font-bold text-gray-400 uppercase tracking-widest mb-1">Archived/Expired</p>
                    <p class="text-3xl font-serif font-bold text-brand-crimson">0</p>
                    <p class="text-[9px] text-neutral-body mt-2 italic">Past Deadlines</p>
                </div>

                <div class="bg-white border border-neutral-divider p-6 shadow-sm group hover:border-brand-navy transition-colors">
                    <p class="text-[10px] font-bold text-gray-400 uppercase tracking-widest mb-1">Global Submissions</p>
                    <p class="text-3xl font-serif font-bold text-brand-navy">{{ $stats['total_applications'] }}</p>
                    <p class="text-[9px] text-neutral-body mt-2 italic">Cumulative Entries</p>
                </div>
            </div>
        </section>

        {{-- GRID CONTAINER FOR LOWER SECTIONS --}}
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-10 items-start">
            
            {{-- 2. RECENT ANNOUNCEMENTS (Occupies 2 columns) --}}
            <div class="lg:col-span-2 space-y-6">
                <div class="flex justify-between items-end h-10 px-1">
                    <h3 class="font-serif text-xl font-bold text-brand-navy">Official Communications</h3>
                    <a href="{{ route('admin.announcements.index') }}" class="text-[10px] font-bold text-brand-crimson hover:text-brand-navy uppercase tracking-widest transition-colors border-b border-brand-crimson/20 pb-1">
                        View Announcements →
                    </a>
                </div>

                <div class="bg-white border border-neutral-divider shadow-sm divide-y divide-neutral-divider">
                    @forelse($announcements as $a)
                    <div class="p-6 hover:bg-neutral-50/50 transition-colors">
                        <div class="flex justify-between items-start mb-2">
                            <h4 class="font-serif font-bold text-brand-navy text-lg leading-tight">{{ $a->title }}</h4>
                            <span class="text-[9px] font-bold text-gray-400 uppercase tracking-tighter whitespace-nowrap ml-4">
                                {{ $a->created_at->format('M d, Y h:i A') }}
                            </span>
                        </div>
                        <p class="text-sm text-neutral-body leading-relaxed mb-3">
                            {{ Str::limit($a->message, 180) }}
                        </p>
                        <div class="flex items-center text-[10px] text-gray-400 uppercase tracking-widest font-bold">
                            <svg class="w-3 h-3 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                            <span>Posted {{ $a->created_at->diffForHumans() }}</span>
                            @if($a->updated_at != $a->created_at)
                                <span class="mx-2 text-gray-300">|</span>
                                <span class="text-brand-crimson/70">Updated {{ $a->updated_at->format('h:i A') }}</span>
                            @endif
                        </div>
                    </div>
                    @empty
                    <div class="p-12 text-center italic text-neutral-body font-serif">
                        No official statements issued at this time.
                    </div>
                    @endforelse
                </div>
            </div>

            {{-- 3. USER OVERVIEW (Occupies 1 column) --}}
            <div class="lg:col-span-1 space-y-6">
                <div class="flex justify-between items-end h-10 px-1">
                    <h3 class="font-serif text-xl font-bold text-brand-navy">Students</h3>
                    <a href="{{ route('admin.applications.index') }}" class="text-[10px] font-bold text-brand-crimson hover:text-brand-navy uppercase tracking-widest transition-colors border-b border-brand-crimson/20 pb-1">
                        Full Registry →
                    </a>
                </div>
                
                <div class="bg-white border border-neutral-divider shadow-sm overflow-hidden">
                    <div class="p-6 space-y-6">
                        <div class="flex items-center justify-between">
                            <div>
                                <p class="text-[10px] font-bold text-gray-400 uppercase tracking-widest">Total Students</p>
                                <p class="text-2xl font-serif font-bold text-brand-navy">{{ $stats['total_students'] }}</p>
                            </div>
                            <div class="p-3 bg-neutral-100 rounded-full text-brand-navy">
                                <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20"><path d="M9 6a3 3 0 11-6 0 3 3 0 016 0zM17 6a3 3 0 11-6 0 3 3 0 016 0zM12.93 17c.046-.327.07-.66.07-1a6.97 6.97 0 00-1.5-4.33A5 5 0 0119 16v1h-6.07zM6 11a7 7 0 00-7 7v1h11v-1a7 7 0 00-7-7z"></path></svg>
                            </div>
                        </div>

                        <hr class="border-neutral-divider">

                        <div class="flex items-center justify-between">
                            <div>
                                <p class="text-[10px] font-bold text-gray-400 uppercase tracking-widest">Active Applicants</p>
                                <p class="text-2xl font-serif font-bold text-brand-navy">{{ $stats['active_applicants'] }}</p>
                            </div>
                            <div class="p-3 bg-yellow-50 rounded-full text-yellow-600">
                                <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20"><path d="M10 2a1 1 0 011 1v1.323l3.954 1.582 1.599-.8a1 1 0 01.894 1.79l-1.233.616 1.738 2.32a1 1 0 01-.274 1.541l-3.974 1.987a1 1 0 01-1.494-.815L11 11.036V14h1a1 1 0 110 2H8a1 1 0 110-2h1v-2.964l-1.005.151a1 1 0 01-1.494-.815L2.527 8.384a1 1 0 01-.274-1.541l1.738-2.32-1.233-.616a1 1 0 11.894-1.79l1.599.8L9.323 4.323V3a1 1 0 011-1z"></path></svg>
                            </div>
                        </div>

                        <hr class="border-neutral-divider">

                        <div class="flex items-center justify-between">
                            <div>
                                <p class="text-[10px] font-bold text-brand-crimson uppercase tracking-widest">Awaiting Review</p>
                                <p class="text-2xl font-serif font-bold text-brand-crimson">{{ $stats['pending_applications'] }}</p>
                            </div>
                            <div class="p-3 bg-red-50 rounded-full text-brand-crimson animate-pulse">
                                <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"></path></svg>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>
</x-app-layout>