<x-app-layout>
    <x-slot name="header">
        <h2 class="font-serif text-3xl font-bold text-brand-navy leading-tight tracking-tight">
            {{ __('Formal Grant Application') }}
        </h2>
        <p class="text-xs text-neutral-body uppercase tracking-[0.2em] font-semibold mt-1">
            Academic Year 2026-2027 • Scholarship Division
        </p>
    </x-slot>

    <div class="max-w-5xl mx-auto py-10 px-4 sm:px-6 lg:px-8">

        {{-- SUCCESS NOTIFICATION --}}
        @if(session('success'))
        <div class="bg-white border border-green-200 p-4 shadow-sm flex items-center space-x-3 mb-8">
            <div class="bg-green-100 p-2 text-green-600">
                <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/></svg>
            </div>
            <div>
                <p class="font-bold text-[10px] uppercase tracking-widest text-green-800">Submission Received</p>
                <p class="text-sm text-green-700">{{ session('success') }}</p>
            </div>
        </div>
        @endif

        {{-- ERROR HANDLING --}}
        @if($errors->any())
        <div class="bg-white border border-brand-crimson/20 p-4 shadow-sm flex items-start space-x-3 mb-8">
            <div class="bg-brand-crimson/10 p-2 text-brand-crimson">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/></svg>
            </div>
            <div>
                <p class="font-bold text-[10px] uppercase tracking-widest text-brand-crimson">Application Errors</p>
                <ul class="mt-1 text-sm text-brand-crimson/80 list-disc list-inside">
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        </div>
        @endif

        <form method="POST" action="{{ route('student.applications.store') }}" enctype="multipart/form-data" class="space-y-8">
            @csrf

            {{-- SECTION 1: PERSONAL & ACADEMIC PROFILE --}}
            <div class="bg-white border border-neutral-divider shadow-sm overflow-hidden">
                <div class="bg-brand-navy px-8 py-4">
                    <h3 class="font-serif font-bold text-lg text-white tracking-wide">I. Personal & Academic Profile</h3>
                </div>
                
                <div class="p-8 grid grid-cols-1 md:grid-cols-2 gap-x-12 gap-y-6">
                    {{-- Full Name --}}
                    <div class="space-y-1">
                        <label class="text-[10px] font-bold uppercase tracking-widest text-neutral-heading">Full Name <span class="text-brand-crimson">*</span></label>
                        <input type="text" name="student_name" value="{{ old('student_name') }}" required
                            class="w-full border-neutral-divider rounded-none focus:ring-brand-navy focus:border-brand-navy text-sm p-2.5">
                    </div>

                    {{-- Guardian --}}
                    <div class="space-y-1">
                        <label class="text-[10px] font-bold uppercase tracking-widest text-neutral-heading">Guardian / Next of Kin <span class="text-brand-crimson">*</span></label>
                        <input type="text" name="guardian_name" value="{{ old('guardian_name') }}" required
                            class="w-full border-neutral-divider rounded-none focus:ring-brand-navy focus:border-brand-navy text-sm p-2.5">
                    </div>

                    {{-- Course --}}
                    <div class="space-y-1">
                        <label class="text-[10px] font-bold uppercase tracking-widest text-neutral-heading">Degree Program / Course <span class="text-brand-crimson">*</span></label>
                        <input type="text" name="course" value="{{ old('course') }}" required
                            class="w-full border-neutral-divider rounded-none focus:ring-brand-navy focus:border-brand-navy text-sm p-2.5">
                    </div>

                    {{-- Contact --}}
                    <div class="space-y-1">
                        <label class="text-[10px] font-bold uppercase tracking-widest text-neutral-heading">Primary Contact Number <span class="text-brand-crimson">*</span></label>
                        <input type="text" name="contact_number" value="{{ old('contact_number') }}" placeholder="09XXXXXXXXX" required
                            class="w-full border-neutral-divider rounded-none focus:ring-brand-navy focus:border-brand-navy text-sm p-2.5">
                    </div>

                    {{-- Year Level --}}
                    <div class="space-y-1">
                        <label class="text-[10px] font-bold uppercase tracking-widest text-neutral-heading">Current Year Level <span class="text-brand-crimson">*</span></label>
                        <select name="year_level" required
                            class="w-full border-neutral-divider rounded-none focus:ring-brand-navy focus:border-brand-navy text-sm p-2.5">
                            <option value="">Select Level</option>
                            @for($i = 1; $i <= 4; $i++)
                                <option value="{{ $i }}" {{ old('year_level') == $i ? 'selected' : '' }}>Year {{ $i }}</option>
                            @endfor
                        </select>
                    </div>

                    {{-- GWA --}}
                    <div class="space-y-1">
                        <label class="text-[10px] font-bold uppercase tracking-widest text-neutral-heading">General Weighted Average (GWA) <span class="text-brand-crimson">*</span></label>
                        <input type="text" name="gwa" value="{{ old('gwa') }}" placeholder="e.g. 1.25 or 92.5" required
                            class="w-full border-neutral-divider rounded-none focus:ring-brand-navy focus:border-brand-navy text-sm p-2.5 font-mono">
                    </div>
                </div>
            </div>

            {{-- SECTION 2: PROGRAM SELECTION --}}
            <div class="bg-white border border-neutral-divider shadow-sm overflow-hidden">
                <div class="bg-brand-navy px-8 py-4">
                    <h3 class="font-serif font-bold text-lg text-white tracking-wide">II. Scholarship Program Selection</h3>
                </div>
                <div class="p-8">
                    <label class="text-[10px] font-bold uppercase tracking-widest text-neutral-heading block mb-2">Select Intended Grant <span class="text-brand-crimson">*</span></label>
                    <select name="scholarship_id" required
                        class="w-full border-neutral-divider rounded-none focus:ring-brand-navy focus:border-brand-navy text-sm p-3 font-serif italic">
                        <option value="">-- Click to Browse Available Programs --</option>
                        @foreach($scholarships as $s)
                        <option value="{{ $s->id }}" {{ old('scholarship_id') == $s->id ? 'selected' : '' }}>
                            {{ $s->name }}
                        </option>
                        @endforeach
                    </select>
                </div>
            </div>

            {{-- SECTION 3: DIGITAL DOSSIER (UPLOADS) --}}
            <div class="bg-white border border-neutral-divider shadow-sm overflow-hidden">
                <div class="bg-brand-navy px-8 py-4">
                    <h3 class="font-serif font-bold text-lg text-white tracking-wide">III. Required Digital Documentation</h3>
                </div>
                <div class="p-8">
                    <p class="text-[10px] text-gray-500 uppercase tracking-widest mb-6 border-b border-neutral-divider pb-4">
                        Please upload clear, legible PDF or Image files (Max 2MB per file).
                    </p>
                    
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                        {{-- Income --}}
                        <div class="space-y-2">
                            <label class="text-[10px] font-bold uppercase tracking-widest text-neutral-heading block">Proof of Income<span class="text-brand-crimson">*</span></label>
                            <input type="file" name="proof_of_income" required
                                class="block w-full text-[10px] text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-none file:border-0 file:text-[10px] file:font-bold file:uppercase file:tracking-widest file:bg-gray-100 file:text-neutral-heading hover:file:bg-gray-200">
                        </div>

                        {{-- Report Card --}}
                        <div class="space-y-2">
                            <label class="text-[10px] font-bold uppercase tracking-widest text-neutral-heading block">Academic Report Card<span class="text-brand-crimson">*</span></label>
                            <input type="file" name="report_card" required
                                class="block w-full text-[10px] text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-none file:border-0 file:text-[10px] file:font-bold file:uppercase file:tracking-widest file:bg-gray-100 file:text-neutral-heading hover:file:bg-gray-200">
                        </div>

                        {{-- Birth Cert --}}
                        <div class="space-y-2">
                            <label class="text-[10px] font-bold uppercase tracking-widest text-neutral-heading block">Birth Certificate<span class="text-brand-crimson">*</span></label>
                            <input type="file" name="birth_certificate" required
                                class="block w-full text-[10px] text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-none file:border-0 file:text-[10px] file:font-bold file:uppercase file:tracking-widest file:bg-gray-100 file:text-neutral-heading hover:file:bg-gray-200">
                        </div>
                    </div>
                </div>
            </div>

            {{-- SUBMISSION ACTION --}}
            <div class="flex items-center justify-between pt-4">
                <a href="{{ route('dashboard') }}" class="text-[10px] font-bold text-neutral-body uppercase tracking-widest hover:text-brand-crimson transition-colors">
                    Discard Application
                </a>
                
                <button type="submit"
                    class="bg-brand-navy hover:bg-opacity-90 text-white px-10 py-4 text-[10px] font-bold uppercase tracking-[0.2em] shadow-lg transition-all focus:outline-none focus:ring-2 focus:ring-brand-navy focus:ring-offset-2">
                    Submit Formal Application
                </button>
            </div>
        </form>

        <p class="mt-12 text-center text-[9px] text-gray-400 uppercase tracking-[0.3em] leading-relaxed">
            By submitting this application, I certify that all information provided is true and correct.<br>
            Any falsification of documents will result in immediate disqualification and disciplinary action.
        </p>

    </div>
</x-app-layout>