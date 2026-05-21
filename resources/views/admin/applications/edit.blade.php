<x-app-layout>
    <x-slot name="header">
        <h2 class="font-serif text-3xl font-bold text-brand-navy leading-tight tracking-tight">
            {{ __('Review Submission') }}
        </h2>
        <p class="text-xs text-neutral-body uppercase tracking-[0.2em] font-semibold mt-1">
            Application Ref: #{{ $application->id }} • {{ $application->student_name }}
        </p>
    </x-slot>

    <div class="max-w-4xl mx-auto py-10 px-4 sm:px-6 lg:px-8">

        {{-- BACK LINK --}}
        <div class="mb-6">
            <a href="{{ route('admin.applications.index') }}" class="text-[10px] font-bold uppercase tracking-widest text-brand-navy hover:text-brand-crimson transition-colors flex items-center">
                <svg class="w-3 h-3 me-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                </svg>
                Back to Ledger
            </a>
        </div>

        {{-- NOTIFICATIONS --}}
        @if(session('success'))
        <div class="bg-white border border-green-200 p-4 shadow-sm flex items-center space-x-3 mb-8">
            <div class="bg-green-100 p-2 text-green-600">
                <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />
                </svg>
            </div>
            <div>
                <p class="font-bold text-[10px] uppercase tracking-widest text-green-800">Success</p>
                <p class="text-sm text-green-700">{{ session('success') }}</p>
            </div>
        </div>
        @endif

        @if ($errors->any())
        <div class="bg-white border border-red-200 p-4 shadow-sm flex items-start space-x-3 mb-8">
            <div class="bg-red-100 p-2 text-red-600">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
            </div>
            <div>
                <p class="font-bold text-[10px] uppercase tracking-widest text-red-800">Review Required</p>
                <ul class="text-sm text-red-700 list-disc list-inside">
                    @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        </div>
        @endif

        <div class="bg-white border border-neutral-divider shadow-sm overflow-hidden">
            <div class="bg-brand-navy px-6 py-4">
                <h3 class="text-[10px] font-bold uppercase tracking-[0.2em] text-white">Application Details</h3>
            </div>

            <form action="{{ route('admin.applications.update', $application) }}" method="POST" class="p-8">
                @csrf
                @method('PUT')

                <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                    {{-- Left Column: Student Info --}}
                    <div class="space-y-6">
                        <div>
                            <label class="block text-[10px] font-bold uppercase tracking-widest text-brand-navy mb-2" for="student_name">Full Name</label>
                            <input type="text" id="student_name" name="student_name" required
                                value="{{ old('student_name', $application->student_name) }}"
                                class="w-full border-neutral-divider rounded-none focus:ring-brand-navy focus:border-brand-navy text-sm p-2.5">
                        </div>

                        <div>
                            <label class="block text-[10px] font-bold uppercase tracking-widest text-brand-navy mb-2" for="student_email">Email Address</label>
                            <input type="email" id="student_email" name="student_email"
                                value="{{ old('student_email', $application->student_email) }}"
                                class="w-full border-neutral-divider rounded-none focus:ring-brand-navy focus:border-brand-navy text-sm p-2.5">
                        </div>

                        <div class="grid grid-cols-2 gap-4">
                            <div>
                                <label class="block text-[10px] font-bold uppercase tracking-widest text-brand-navy mb-2" for="course">Course</label>
                                <input type="text" id="course" name="course" required
                                    value="{{ old('course', $application->course) }}"
                                    class="w-full border-neutral-divider rounded-none focus:ring-brand-navy focus:border-brand-navy text-sm p-2.5">
                            </div>
                            <div>
                                <label class="block text-[10px] font-bold uppercase tracking-widest text-brand-navy mb-2" for="year_level">Year Level</label>
                                <select id="year_level" name="year_level" required
                                    class="w-full border-neutral-divider rounded-none focus:ring-brand-navy focus:border-brand-navy text-sm p-2.5">
                                    @for($i = 1; $i <= 4; $i++)
                                        <option value="{{ $i }}" {{ old('year_level', $application->year_level) == $i ? 'selected' : '' }}>Level {{ $i }}</option>
                                        @endfor
                                </select>
                            </div>
                        </div>
                    </div>

                    {{-- Right Column: Admin Decision --}}
                    <div class="space-y-6 bg-gray-50/50 p-6 border border-neutral-divider">
                        @if(auth()->user()->role === 'admin')
                        <div>
                            <label class="block text-[10px] font-bold uppercase tracking-widest text-brand-navy mb-2" for="status">Decision Status *</label>
                            <select id="status" name="status" class="w-full border-neutral-divider rounded-none focus:ring-brand-navy focus:border-brand-navy text-sm p-2.5 font-bold">
                                <option value="Pending" {{ old('status', $application->status) === 'Pending' ? 'selected' : '' }}>PENDING REVIEW</option>
                                <option value="Approved" {{ old('status', $application->status) === 'Approved' ? 'selected' : '' }}>APPROVE APPLICATION</option>
                                <option value="Rejected" {{ old('status', $application->status) === 'Rejected' ? 'selected' : '' }}>REJECT APPLICATION</option>
                            </select>
                        </div>

                        <div>
                            <label class="block text-[10px] font-bold uppercase tracking-widest text-brand-navy mb-2" for="remarks">Administrative Remarks</label>
                            <textarea id="remarks" name="remarks" rows="4"
                                placeholder="Add notes about this decision..."
                                class="w-full border-neutral-divider rounded-none focus:ring-brand-navy focus:border-brand-navy text-sm p-2.5">{{ old('remarks', $application->remarks) }}</textarea>
                        </div>
                        @endif
                    </div>
                </div>

                {{-- DOCUMENT SECTION --}}
                <div class="mt-10 pt-10 border-t border-neutral-divider">
                    <h3 class="text-[10px] font-bold uppercase tracking-[0.2em] text-brand-navy mb-6 text-center">Verification Documents</h3>

                    <div class="flex flex-wrap justify-center gap-6">
                        @foreach(['proof_of_income' => 'Proof of Income', 'report_card' => 'Academic Report', 'birth_certificate' => 'Birth Certificate'] as $field => $label)
                        <div class="flex flex-col items-center">
                            <p class="text-[9px] font-bold uppercase tracking-widest text-neutral-body mb-3">{{ $label }}</p>
                            @if($application->$field)
                            <a href="{{ asset('storage/' . $application->$field) }}" target="_blank"
                                class="flex items-center justify-center w-16 h-16 border-2 border-neutral-divider bg-white text-brand-navy hover:border-brand-navy hover:bg-brand-navy hover:text-white transition-all group">
                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" />
                                </svg>
                            </a>
                            <span class="text-[8px] mt-2 font-bold text-green-600 uppercase tracking-tighter">Verified File</span>
                            @else
                            <div class="flex items-center justify-center w-16 h-16 border-2 border-dashed border-red-200 bg-red-50 text-red-300">
                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M6 18L18 6M6 6l12 12" />
                                </svg>
                            </div>
                            <span class="text-[8px] mt-2 font-bold text-red-400 uppercase tracking-tighter">Missing Document</span>
                            @endif
                        </div>
                        @endforeach
                    </div>
                </div>

                {{-- FORM ACTIONS --}}
                <div class="mt-12 flex justify-end">
                    <button type="submit" class="bg-brand-navy text-white px-10 py-4 text-[10px] font-bold uppercase tracking-[0.2em] hover:bg-opacity-90 transition-colors shadow-lg">
                        Finalize Review & Update
                    </button>
                </div>
            </form>
        </div>
    </div>
</x-app-layout>