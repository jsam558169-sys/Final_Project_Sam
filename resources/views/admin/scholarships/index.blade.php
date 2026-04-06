<x-app-layout>
    <x-slot name="header">
        <h2>Manage Scholarships</h2>
    </x-slot>

    <div style="max-width:900px; margin:50px auto;">

        @if(session('success'))
        <p style="color:green;">{{ session('success') }}</p>
        @endif

        <a href="{{ route('admin.scholarships.create') }}"
            style="background:#007bff;color:white;padding:10px 15px;border-radius:5px;">
            + Add Scholarship
        </a>

        <table style="width:100%; margin-top:20px;">
            <tr>
                <th>Name</th>
                <th>Description</th>
                <th>Actions</th>
            </tr>

            @forelse($scholarships as $s)
            <tr>
                <td>{{ $s->name }}</td>
                <td>{{ $s->description }}</td>
                <td>
                    <!-- (Edit/Delete later) -->
                    -
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="3">No scholarships yet.</td>
            </tr>
            @endforelse
        </table>

    </div>
</x-app-layout>