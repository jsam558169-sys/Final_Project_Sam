<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ScholarshipApplication;
use Illuminate\Support\Facades\Auth;
use App\Models\Scholarship;
use App\Models\Announcement;

class ScholarshipApplicationController extends Controller
{
    // Show student create form
    public function create()
    {
        $scholarships = Scholarship::all();
        return view('student.create_application', compact('scholarships'));
    }

    // Handle student form submission
    public function store(Request $request)
    {
        $request->validate([
            'student_name' => 'required|string|max:100',
            'course' => 'required|string|max:100',
            'year_level' => 'required|integer|min:1|max:4',
            'scholarship_id' => 'required|exists:scholarships,id',

            'contact_number' => 'required|regex:/^[0-9]{10,11}$/',
            'gwa' => 'required|numeric',
            'guardian_name' => 'required|string|max:100',

            'proof_of_income' => 'required|file|mimes:pdf,jpg,png|max:5120',
            'report_card' => 'required|file|mimes:pdf,jpg,png|max:5120',
            'birth_certificate' => 'required|file|mimes:pdf,jpg,png|max:5120',
        ]);

        $userEmail = Auth::user()->email;

        $hasPending = ScholarshipApplication::where('student_email', $userEmail)
            ->where('status', 'Pending')
            ->exists();

        if ($hasPending) {
            return back()->with('error', 'You already have a pending application.');
        }

        $alreadyApplied = ScholarshipApplication::where('student_email', $userEmail)
            ->where('scholarship_id', $request->scholarship_id)
            ->exists();

        if ($alreadyApplied) {
            return back()->with('error', 'Already applied for this scholarship.');
        }

        // FILE UPLOADS
        $proofPath = $request->file('proof_of_income')->store('documents', 'public');
        $reportPath = $request->file('report_card')->store('documents', 'public');
        $birthPath = $request->file('birth_certificate')->store('documents', 'public');


        // CREATE
        ScholarshipApplication::create([
            'student_name' => $request->student_name,
            'student_email' => $userEmail,
            'course' => $request->course,
            'year_level' => $request->year_level,

            'contact_number' => $request->contact_number,
            'gwa' => $request->gwa,
            'guardian_name' => $request->guardian_name,

            'proof_of_income' => $proofPath,
            'report_card' => $reportPath,
            'birth_certificate' => $birthPath,

            'scholarship_id' => $request->scholarship_id,
            'status' => 'Pending',
        ]);

        return redirect()->route('student.dashboard')
            ->with('success', 'Application submitted successfully!');
    }

    public function view($id)
    {
        $application = ScholarshipApplication::with('scholarship')->findOrFail($id);

        // Use the Auth facade instead of the helper to fix the IDE error
        if ($application->student_email !== Auth::user()->email) {
            abort(403, 'Unauthorized action.');
        }

        return view('student.applications.view', compact('application'));
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

    public function dashboard()
    {
        $user = Auth::user();

        // Fetches the 5 most recently created or updated announcements [cite: 1, 187]
        $announcements = Announcement::orderBy('updated_at', 'desc')->take(5)->get();

        $totalApplications = ScholarshipApplication::where('student_email', $user->email)->count();
        $pendingCount = ScholarshipApplication::where('student_email', $user->email)->where('status', 'Pending')->count();
        $approvedCount = ScholarshipApplication::where('student_email', $user->email)->where('status', 'Approved')->count();

        return view('student.dashboard', compact(
            'announcements',
            'totalApplications',
            'pendingCount',
            'approvedCount'
        ));
    }

    // Index: show applications
    public function index()
    {
        $user = Auth::user();

        // ADMIN VIEW
        if ($user->role === 'admin') {
            $applications = ScholarshipApplication::with('scholarship')
                ->orderBy('created_at', 'desc')
                ->get();

            return view('admin.applications.index', compact('applications'));
        }

        // STUDENT VIEW
        $applications = ScholarshipApplication::where('student_email', $user->email)
            ->orderBy('created_at', 'desc')
            ->get();

        $announcements = Announcement::orderBy('updated_at', 'desc')->take(5)->get();

        $hasPending = ScholarshipApplication::where('student_email', $user->email)
            ->where('status', 'Pending')
            ->exists();

        $hasApproved = ScholarshipApplication::where('student_email', $user->email)
            ->where('status', 'Approved')
            ->exists();

        $hasActiveApplication = ScholarshipApplication::where('student_email', $user->email)
            ->whereIn('status', ['Pending', 'Approved'])
            ->exists();

        return view('student.applications.index', compact(
            'applications',
            'announcements',
            'hasPending',
            'hasActiveApplication',
            'hasApproved'
        ));
    }

    // Show edit form
    public function edit($id)
    {
        $application = ScholarshipApplication::findOrFail($id);
        return view('admin.applications.edit', compact('application'));
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
