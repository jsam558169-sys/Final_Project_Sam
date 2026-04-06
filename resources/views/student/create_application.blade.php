<x-app-layout>
    <x-slot name="header">
        <h2 style="font-size:20px; font-weight:bold;">
            Submit Scholarship Application
        </h2>
    </x-slot>

    <div style="max-width:600px; margin:50px auto;">

        @if(session('success'))
        <p style="color:green;">{{ session('success') }}</p>
        @endif

        @if($errors->any())
        <div style="color:red;">
            <ul>
                @foreach($errors->all() as $error)
                <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
        @endif

        <form method="POST" action="{{ route('student.applications.store') }}">
            @csrf

            <div style="margin-bottom:15px;">
                <label>Full Name *</label>
                <input type="text" name="student_name" value="{{ old('student_name') }}" required style="width:100%; padding:8px;">
            </div>

            <div style="margin-bottom:15px;">
                <label>Course *</label>
                <input type="text" name="course" value="{{ old('course') }}" required style="width:100%; padding:8px;">
            </div>

            <div style="margin-bottom:15px;">
                <label>Year Level *</label>
                <select name="year_level" required style="width:100%; padding:8px;">
                    <option value="">--Select Year--</option>
                    @for($i = 1; $i <= 4; $i++)
                        <option value="{{ $i }}">{{ $i }}</option>
                        @endfor
                </select>
            </div>

            <button type="submit" style="background:#28a745; color:white; padding:10px 20px; border:none; border-radius:5px;">
                Submit Application
            </button>
        </form>

    </div>
</x-app-layout>