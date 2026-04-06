<x-app-layout>
    <x-slot name="header">
        <h2 style="font-size:22px; font-weight:bold; color:#333;">
            My Scholarship Applications
        </h2>
    </x-slot>

    <div style="max-width:900px; margin:50px auto;">

        {{-- Success message --}}
        @if(session('success'))
        <p style="color:green; font-weight:bold; margin-bottom:20px;">{{ session('success') }}</p>
        @endif

        {{-- Submit New Application Button --}}
        <div style="margin-bottom: 30px; text-align:right;">
            <a href="{{ route('student.applications.create') }}"
                style="background-color:#28a745; color:white; padding:12px 20px; text-decoration:none; border-radius:8px; font-weight:bold; font-size:16px; transition:0.3s;">
                + Submit New Application
            </a>
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
                padding: 12px;
                border: 1px solid #ddd;
                text-align: left;
            }

            thead {
                background-color: #333333;
                color: white;
            }

            tbody tr:hover {
                background-color: #f9f9f9;
            }

            .status-pending {
                color: orange;
                font-weight: bold;
            }

            .status-approved {
                color: green;
                font-weight: bold;
            }

            .status-rejected {
                color: red;
                font-weight: bold;
            }

            /* Empty message styling */
            .empty-message {
                text-align: center;
                padding: 20px;
                font-style: italic;
                color: #555;
            }
        </style>

        <table>
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Course</th>
                    <th>Year Level</th>
                    <th>Status</th>
                    <th>Remarks</th>
                    <th>Submitted On</th>
                </tr>
            </thead>
            <tbody>
                @forelse($applications as $app)
                <tr>
                    <td>{{ $app->studentID }}</td>
                    <td>{{ $app->course }}</td>
                    <td>{{ $app->year_level }}</td>
                    <td class="
                        @if($app->status === 'Pending') status-pending 
                        @elseif($app->status === 'Approved') status-approved 
                        @elseif($app->status === 'Rejected') status-rejected 
                        @endif">
                        {{ $app->status }}
                    </td>
                    <td>{{ $app->remarks ?? '-' }}</td>
                    <td>{{ $app->created_at->format('M d, Y') }}</td>
                </tr>
                @empty
                <tr>
                    <td colspan="6" class="empty-message">
                        You have not submitted any applications yet.<br>
                        Click the <strong>+ Submit New Application</strong> button above to get started.
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>

    </div>
</x-app-layout>