<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ScholarshipApplication;
use Illuminate\Support\Facades\Auth;

class ScholarshipApplicationController extends Controller
{
    // Show student create form
    public function create()
    {
        return view('student.create_application');
    }

    // Handle student form submission
    public function store(Request $request)
    {
        $request->validate([
            'student_name' => 'required|string|max:100',
            'course' => 'required|string|max:100',
            'year_level' => 'required|integer|min:1|max:4',
        ]);

        ScholarshipApplication::create([
            'student_name' => $request->student_name,
            'student_email' => Auth::user()->email, // student's email
            'course' => $request->course,
            'year_level' => $request->year_level,
            'status' => 'Pending',
        ]);

        return redirect()->route('student.dashboard')->with('success', 'Application submitted successfully!');
    }

    // Admin create form
    public function adminCreate()
    {
        return view('admin.create_application');
    }

    // Admin store
    public function adminStore(Request $request)
    {
        $request->validate([
            'student_name' => 'required|string|max:100',
            'student_email' => 'nullable|email|max:100',
            'course' => 'required|string|max:100',
            'year_level' => 'required|integer|min:1|max:4',
            'status' => 'required|in:Pending,Approved,Rejected',
            'remarks' => 'nullable|string',
        ]);

        ScholarshipApplication::create($request->all());

        return redirect()->back()->with('success', 'Application added successfully!');
    }

    // Index: show applications
    public function index()
    {
        if (Auth::user()->role === 'admin') {
            // Admin sees all applications
            $applications = ScholarshipApplication::all();
            return view('admin.applications.index', compact('applications'));
        } else {
            // Student sees only their applications
            $applications = ScholarshipApplication::where('student_email', Auth::user()->email)
                ->orderBy('created_at', 'desc')
                ->get();
        }

        // Use different views for admin/student if you want, or same view
        if (Auth::user()->role === 'admin') {
            return view('admin.applications.index', compact('applications'));
        } else {
            return view('student.dashboard', compact('applications'));
        }
    }

    // Show edit form
    public function edit($id)
    {
        $application = ScholarshipApplication::findOrFail($id);
        return view('applications.edit', compact('application'));
    }

    // Update application
    public function update(Request $request, $id)
    {
        $request->validate([
            'student_name' => 'required|string|max:100',
            'student_email' => 'nullable|email|max:100',
            'course' => 'required|string|max:100',
            'year_level' => 'required|integer|min:1|max:4',
            'status' => 'required|in:Pending,Approved,Rejected',
            'remarks' => 'nullable|string',
        ]);

        $application = ScholarshipApplication::findOrFail($id);
        $application->update($request->all());

        return redirect()->route('admin.applications.index')->with('success', 'Application updated successfully!');
    }

    // Delete application
    public function destroy($id)
    {
        $application = ScholarshipApplication::findOrFail($id);
        $application->delete();

        return redirect()->route('admin.applications.index')->with('success', 'Application deleted successfully!');
    }
}
