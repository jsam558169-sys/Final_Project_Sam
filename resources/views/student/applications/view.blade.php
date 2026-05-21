<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <div>
                <h2 class="font-serif text-3xl font-bold text-brand-navy leading-tight tracking-tight">
                    {{ __('Application Dossier') }}
                </h2>
                <p class="text-xs text-neutral-body uppercase tracking-[0.2em] font-semibold mt-1">
                    Reference: #APP-{{ str_pad($application->id, 5, '0', STR_PAD_LEFT) }} • {{ $application->scholarship->name ?? 'Program Record' }}
                </p>
            </div>
            
            <a href="{{ route('student.applications.index') }}" class="text-[10px] font-bold text-neutral-body uppercase tracking-widest hover:text-brand-navy transition-colors flex items-center">
                <svg class="w-3 h-3 me-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/></svg>
                Return to Ledger
            </a>
        </div>
    </x-slot>

    <div class="max-w-5xl mx-auto py-10 px-4 sm:px-6 lg:px-8">
        
        <div class="bg-white border border-neutral-divider shadow-sm overflow-hidden">
            
            {{-- HEADER SECTION: STATUS & IDENTITY --}}
            <div class="bg-brand-navy px-8 py-6 flex flex-col md:flex-row md:items-center justify-between gap-4 border-b border-neutral-divider">
                <div class="text-white">
                    <h3 class="font-serif font-bold text-xl tracking-wide">{{ $application->student_name }}</h3>
                    <p class="text-[10px] text-white/60 uppercase tracking-[0.2em] mt-1">Primary Applicant Identity</p>
                </div>

                <div class="flex flex-col items-end">
                    @php
                        $statusClasses = [
                            'Approved' => 'bg-green-500 text-white border-green-600',
                            'Pending'  => 'bg-amber-400 text-amber-950 border-amber-500',
                            'Rejected' => 'bg-brand-crimson text-white border-red-800',
                        ][$application->status] ?? 'bg-gray-500 text-white border-gray-600';
                    @endphp
                    <span class="px-4 py-1.5 text-xs font-black uppercase tracking-[0.2em] border {{ $statusClasses }} shadow-inner">
                        {{ $application->status }}
                    </span>
                    <p class="text-[9px] text-white/40 uppercase tracking-widest mt-2">Current Disposition</p>
                </div>
            </div>

            <div class="p-8 space-y-10">
                
                {{-- SUB-SECTION: ACADEMIC STANDING --}}
                <section>
                    <h4 class="text-[10px] font-bold text-neutral-heading uppercase tracking-[0.25em] mb-4 flex items-center">
                        <span class="bg-brand-navy w-2 h-2 me-2"></span> Academic & Administrative Records
                    </h4>
                    <div class="grid grid-cols-1 md:grid-cols-2 border-t border-neutral-divider">
                        <div class="py-4 border-b border-neutral-divider md:border-r md:pe-8">
                            <dt class="text-[9px] font-bold text-gray-400 uppercase tracking-widest">Enrolled Course</dt>
                            <dd class="text-sm font-serif text-neutral-heading mt-1">{{ $application->course }}</dd>
                        </div>
                        <div class="py-4 border-b border-neutral-divider md:ps-8">
                            <dt class="text-[9px] font-bold text-gray-400 uppercase tracking-widest">Academic Year Level</dt>
                            <dd class="text-sm font-serif text-neutral-heading mt-1">Year {{ $application->year_level }}</dd>
                        </div>
                        <div class="py-4 border-b border-neutral-divider md:border-r md:pe-8">
                            <dt class="text-[9px] font-bold text-gray-400 uppercase tracking-widest">Recorded GWA</dt>
                            <dd class="text-sm font-mono font-bold text-neutral-heading mt-1">{{ $application->gwa }}</dd>
                        </div>
                        <div class="py-4 border-b border-neutral-divider md:ps-8">
                            <dt class="text-[9px] font-bold text-gray-400 uppercase tracking-widest">Filing Timestamp</dt>
                            <dd class="text-sm font-serif text-neutral-heading mt-1">{{ $application->created_at->format('F d, Y / h:i a') }} ({{ $application->created_at->diffForHumans() }})</dd>
                        </div>
                    </div>
                </section>

                {{-- SUB-SECTION: OFFICIAL REMARKS --}}
                <section class="bg-neutral-bg p-6 border-l-4 border-brand-navy">
                    <h4 class="text-[10px] font-bold text-neutral-heading uppercase tracking-[0.25em] mb-2">Institutional Remarks</h4>
                    <p class="text-sm text-neutral-body italic leading-relaxed">
                        {{ $application->remarks ?? 'No official notation has been made by the Scholarship Committee at this time.' }}
                    </p>
                </section>

                {{-- SUB-SECTION: DIGITAL DOCUMENTS --}}
                <section>
                    <h4 class="text-[10px] font-bold text-neutral-heading uppercase tracking-[0.25em] mb-4 flex items-center">
                        <span class="bg-brand-navy w-2 h-2 me-2"></span> Verified Digital Documentation
                    </h4>
                    
                    <ul class="divide-y divide-neutral-divider border border-neutral-divider">
                        @php
                            $docs = [
                                'proof_of_income' => 'Proof of Household Income',
                                'report_card' => 'Official Academic Report Card',
                                'birth_certificate' => 'Birth Certificate (PSA/NSO)'
                            ];
                        @endphp

                        @foreach($docs as $field => $label)
                            @if($application->$field)
                            <li class="px-6 py-4 flex items-center justify-between group hover:bg-neutral-bg transition-colors">
                                <div class="flex items-center">
                                    <svg class="w-5 h-5 text-gray-400 group-hover:text-brand-navy transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.172 7l-6.586 6.586a2 2 0 102.828 2.828l6.414-6.586a4 4 0 00-5.656-5.656l-6.415 6.585a6 6 0 108.486 8.486L20.5 13"/></svg>
                                    <span class="ms-3 text-xs font-bold text-neutral-heading uppercase tracking-widest">{{ $label }}</span>
                                </div>
                                <div class="flex items-center space-x-6">
                                    <a href="{{ asset('storage/' . $application->$field) }}" target="_blank" class="text-[10px] font-bold text-brand-navy hover:text-brand-crimson transition-colors uppercase tracking-widest">
                                        View
                                    </a>
                                    <span class="text-neutral-divider text-xs">|</span>
                                    <a href="{{ asset('storage/' . $application->$field) }}" download class="text-[10px] font-bold text-gray-500 hover:text-neutral-heading transition-colors uppercase tracking-widest">
                                        Download
                                    </a>
                                </div>
                            </li>
                            @endif
                        @endforeach
                    </ul>
                </section>
            </div>

            {{-- FOOTER AUDIT --}}
            <div class="bg-neutral-bg px-8 py-4 border-t border-neutral-divider flex justify-between items-center">
                <p class="text-[9px] text-gray-400 uppercase tracking-widest font-bold">Document Integrity Verified</p>
                <button onclick="window.print()" class="text-[9px] font-bold text-brand-navy uppercase tracking-widest hover:underline">
                    Generate Print Copy
                </button>
            </div>

        </div>

    </div>
</x-app-layout>