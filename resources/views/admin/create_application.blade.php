<x-app-layout>

    <x-slot name="header">
        Submit Scholarship Application (Admin)
    </x-slot>

    <div class="max-w-3xl mx-auto py-6 sm:px-6 lg:px-8">
        @if(session('success'))
        <div class="mb-4 text-green-600">{{ session('success') }}</div>
        @endif

        @if($errors->any())
        <div class="mb-4 text-red-600">
            <ul class="list-disc pl-5">
                @foreach($errors->all() as $error)
                <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
        @endif

        <div class="bg-white shadow sm:rounded-lg p-6">
            <form method="POST" action="{{ route('admin.application.store') }}">
                @csrf

                <label class="block mt-4">Full Name *</label>
                <input type="text" name="student_name" value="{{ old('student_name') }}" required class="w-full border rounded p-2">

                <label class="block mt-4">Email</label>
                <input type="email" name="student_email" value="{{ old('student_email') }}" class="w-full border rounded p-2">

                <label class="block mt-4">Course / Program *</label>
                <input type="text" name="course" value="{{ old('course') }}" required class="w-full border rounded p-2">

                <label class="block mt-4">Year Level *</label>
                <select name="year_level" required class="w-full border rounded p-2">
                    @for($i = 1; $i <= 4; $i++)
                        <option value="{{ $i }}" {{ old('year_level') == $i ? 'selected' : '' }}>{{ $i }}</option>
                        @endfor
                </select>

                <label class="block mt-4">Status *</label>
                <select name="status" required class="w-full border rounded p-2">
                    <option value="Pending" {{ old('status') == 'Pending' ? 'selected' : '' }}>Pending</option>
                    <option value="Approved" {{ old('status') == 'Approved' ? 'selected' : '' }}>Approved</option>
                    <option value="Rejected" {{ old('status') == 'Rejected' ? 'selected' : '' }}>Rejected</option>
                </select>

                <label class="block mt-4">Remarks</label>
                <textarea name="remarks" class="w-full border rounded p-2">{{ old('remarks') }}</textarea>

                <button type="submit" class="mt-6 px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700">Submit</button>
            </form>
        </div>
    </div>
</x-app-layout>