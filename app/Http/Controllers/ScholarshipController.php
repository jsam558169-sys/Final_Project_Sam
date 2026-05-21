<?php

namespace App\Http\Controllers;

use App\Models\ScholarshipApplication;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Models\Scholarship;

class ScholarshipController extends Controller
{
    public function index(Request $request)
    {
        // Get search and sort parameters
        $search = $request->input('search');
        $sort = $request->input('sort', 'updated_at');
        $direction = $request->input('direction', 'desc');

        // Use withCount to get statistics for each scholarship
        $query = Scholarship::withCount([
            'applications as total_applicants',
            'applications as approved_count' => function ($query) {
                $query->where('status', 'Approved');
            },
            'applications as pending_count' => function ($query) {
                $query->where('status', 'Pending');
            },
            'applications as rejected_count' => function ($query) {
                $query->where('status', 'Rejected');
            }
        ]);

        // Search Logic
        if ($search) {
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                    ->orWhere('description', 'like', "%{$search}%");
            });
        }

        // Sorting Logic
        $scholarships = $query->orderBy($sort, $direction)->get();

        return view('admin.scholarships.index', compact('scholarships'));
    }

    public function create()
    {
        return view('admin.scholarships.create');
    }
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:100',
            'description' => 'nullable|string',
        ]);

        Scholarship::create($request->all());
        return redirect()->route('admin.scholarships.index')
            ->with('success', 'Scholarship added!');
    }

    // Show edit form
    public function edit($id)
    {
        $scholarship = Scholarship::findOrFail($id);
        return view('admin.scholarships.edit', compact('scholarship'));
    }

    // Update scholarship
    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required|string|max:100',
            'description' => 'nullable|string',
        ]);

        $scholarship = Scholarship::findOrFail($id);
        $scholarship->update($request->all());

        return redirect()->route('admin.scholarships.index')
            ->with('success', 'Scholarship updated!');
    }

    // Delete scholarship
    public function destroy($id)
    {
        $scholarship = Scholarship::findOrFail($id);
        $scholarship->delete();

        return redirect()->route('admin.scholarships.index')
            ->with('success', 'Scholarship deleted!');
    }

    public function studentIndex(Request $request)
    {
        // Get search and sort parameters from the URL
        $search = $request->input('search');
        $sort = $request->input('sort', 'updated_at'); // Default sort
        $direction = $request->input('direction', 'desc');

        // Build the query
        $query = Scholarship::query();

        if ($search) {
            $query->where('name', 'like', "%{$search}%")
                ->orWhere('description', 'like', "%{$search}%");
        }

        // Apply sorting
        $scholarships = $query->orderBy($sort, $direction)->get();

        $userEmail = Auth::user()->email;

        $hasPending = ScholarshipApplication::where('student_email', $userEmail)
            ->where('status', 'Pending')
            ->exists();

        $appliedScholarships = ScholarshipApplication::where('student_email', $userEmail)
            ->pluck('scholarship_id')
            ->toArray();

        return view('student.scholarships.index', compact(
            'scholarships',
            'hasPending',
            'appliedScholarships'
        ));
    }
}
