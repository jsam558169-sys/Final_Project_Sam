<x-app-layout>
    <x-slot name="header">
        <h2 style="font-size:20px; font-weight:bold;">
            Admin Dashboard - Scholarship Applications
        </h2>
    </x-slot>

    <div style="max-width:1000px; margin:50px auto;">

        @if(session('success'))
        <p style="color:green;">{{ session('success') }}</p>
        @endif

        <div style="margin-bottom:20px;">
            <a href="{{ route('admin.application.create') }}" style="padding:10px 20px; background-color:#007bff; color:white; text-decoration:none; border-radius:5px;">Add New Application</a>
        </div>

        <style>
            table {
                width: 100%;
                border-collapse: collapse;
                font-family: Arial, sans-serif;
                font-size: 14px;
            }

            th,
            td {
                padding: 10px;
                border: 1px solid #ddd;
                text-align: left;
            }

            thead {
                background-color: #333333;
                color: white;
            }

            tbody tr:hover {
                background-color: #f2f2f2;
            }

            a.btn-edit {
                color: #007bff;
                text-decoration: none;
                margin-right: 5px;
            }

            button.btn-delete {
                background-color: #dc3545;
                color: white;
                border: none;
                padding: 5px 10px;
                cursor: pointer;
            }

            button.btn-delete:hover {
                background-color: #c82333;
            }
        </style>

        <table>
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Name</th>
                    <th>Email</th>
                    <th>Course</th>
                    <th>Year</th>
                    <th>Status</th>
                    <th>Remarks</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse($applications as $app)
                <tr>
                    <td>{{ $app->studentID }}</td>
                    <td>{{ $app->student_name }}</td>
                    <td>{{ $app->student_email }}</td>
                    <td>{{ $app->course }}</td>
                    <td>{{ $app->year_level }}</td>
                    <td>{{ $app->status }}</td>
                    <td>{{ $app->remarks }}</td>
                    <td>
                        <a href="{{ route('admin.application.edit', $app->studentID) }}" class="btn-edit">Edit</a>
                        <form action="{{ route('admin.application.destroy', $app->studentID) }}" method="POST" style="display:inline;">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn-delete" onclick="return confirm('Are you sure you want to delete this application?')">Delete</button>
                        </form>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="8" style="padding:10px; text-align:center;">No applications found.</td>
                </tr>
                @endforelse
            </tbody>
        </table>

    </div>
</x-app-layout>