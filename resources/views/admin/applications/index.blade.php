<x-app-layout>
    <x-slot name="header">
        <h2 class="font-bold text-xl">All Scholarship Applications</h2>
    </x-slot>

    <div class="max-w-7xl mx-auto mt-6 px-4">
        @if(session('success'))
        <p class="text-green-600">{{ session('success') }}</p>
        @endif

        <table class="w-full border-collapse border border-gray-300">
            <thead class="bg-gray-200">
                <tr>
                    <th class="border px-2 py-1">Student ID</th>
                    <th class="border px-2 py-1">Course</th>
                    <th class="border px-2 py-1">Year Level</th>
                    <th class="border px-2 py-1">Status</th>
                    <th class="border px-2 py-1">Remarks</th>
                    <th class="border px-2 py-1">Submitted On</th>
                    <th class="border px-2 py-1">Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse($applications as $app)
                <tr>
                    <td class="border px-2 py-1">{{ $app->studentID }}</td>
                    <td class="border px-2 py-1">{{ $app->course }}</td>
                    <td class="border px-2 py-1">{{ $app->year_level }}</td>
                    <td class="border px-2 py-1">{{ $app->status }}</td>
                    <td class="border px-2 py-1">{{ $app->remarks ?? '-' }}</td>
                    <td class="border px-2 py-1">{{ $app->created_at->format('M d, Y') }}</td>
                    <td class="border px-2 py-1">
                        <a href="{{ route('admin.applications.edit', $app) }}" class="text-blue-600 hover:underline">Review</a>
                        <form action="{{ route('admin.applications.destroy', $app) }}" method="POST" class="inline">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="text-red-600 hover:underline" onclick="return confirm('Are you sure?')">Delete</button>
                        </form>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="8" class="text-center p-4">No applications yet.</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</x-app-layout>