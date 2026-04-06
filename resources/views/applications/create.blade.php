<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Submit New Scholarship Application
        </h2>
    </x-slot>

    <div class="max-w-3xl mx-auto py-6 sm:px-6 lg:px-8">

        {{-- Success message --}}
        @if(session('success'))
        <div class="mb-4 p-3 bg-green-100 text-green-800 rounded">
            {{ session('success') }}
        </div>
        @endif

        {{-- Validation errors --}}
        @if ($errors->any())
        <div class="mb-4 p-3 bg-red-100 text-red-800 rounded">
            <ul class="list-disc pl-5">
                @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
        @endif

        {{-- Student Create Form --}}
        <form action="{{ route('applications.store') }}" method="POST" class="space-y-4 bg-white p-6 rounded shadow">
            @csrf

            {{-- Full Name --}}
            <div>
                <label class="block font-medium text-gray-700" for="student_name">Full Name *</label>
                <input type="text" id="student_name" name="student_name" required
                    value="{{ old('student_name', auth()->user()->name) }}"
                    class="mt-1 block w-full border-gray-300 rounded-md shadow-sm">
            </div>

            {{-- Email --}}
            <div>
                <label class="block font-medium text-gray-700" for="student_email">Email *</label>
                <input type="email" id="student_email" name="student_email" required
                    value="{{ old('student_email', auth()->user()->email) }}"
                    class="mt-1 block w-full border-gray-300 rounded-md shadow-sm">
            </div>

            {{-- Course --}}
            <div>
                <label class="block font-medium text-gray-700" for="course">Course *</label>
                <input type="text" id="course" name="course" required
                    value="{{ old('course') }}"
                    class="mt-1 block w-full border-gray-300 rounded-md shadow-sm">
            </div>

            {{-- Year Level --}}
            <div>
                <label class="block font-medium text-gray-700" for="year_level">Year Level *</label>
                <select id="year_level" name="year_level" required
                    class="mt-1 block w-full border-gray-300 rounded-md shadow-sm">
                    @for($i = 1; $i <= 4; $i++)
                        <option value="{{ $i }}" {{ old('year_level') == $i ? 'selected' : '' }}>{{ $i }}</option>
                        @endfor
                </select>
            </div>

            {{-- Status & Remarks (Admins only, hidden for students) --}}
            @if(auth()->user()->role === 'admin')
            <div>
                <label class="block font-medium text-gray-700" for="status">Status *</label>
                <select id="status" name="status" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm">
                    <option value="Pending" {{ old('status') === 'Pending' ? 'selected' : '' }}>Pending</option>
                    <option value="Approved" {{ old('status') === 'Approved' ? 'selected' : '' }}>Approved</option>
                    <option value="Rejected" {{ old('status') === 'Rejected' ? 'selected' : '' }}>Rejected</option>
                </select>
            </div>

            <div>
                <label class="block font-medium text-gray-700" for="remarks">Remarks</label>
                <textarea id="remarks" name="remarks"
                    class="mt-1 block w-full border-gray-300 rounded-md shadow-sm">{{ old('remarks') }}</textarea>
            </div>
            @endif

            {{-- Submit --}}
            <div class="flex justify-end">
                <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700">
                    Submit Application
                </button>
            </div>

        </form>

    </div>
</x-app-layout>