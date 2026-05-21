<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Scholarship;
use App\Models\ScholarshipApplication;
use App\Models\Announcement;
use App\Models\User;
use Illuminate\Support\Facades\Schema; // Added for safety checks

class AdminController extends Controller
{
    public function index()
    {
        // 1. Fetch Scholarship Stats
        // We count total scholarships. Since there's no 'status' column, 
        // we'll assume all existing records are active for the dashboard display.
        $totalScholarships = Scholarship::count();

        $stats = [
            'total_scholarships'   => $totalScholarships,
            'active_scholarships'  => $totalScholarships, // Temporary placeholder
            'total_applications'   => ScholarshipApplication::count(),
            'pending_applications' => ScholarshipApplication::where('status', 'Pending')->count(),

            // 2. Fetch User Overview
            // Checking if 'role' column exists to avoid another crash
            'total_students'       => Schema::hasColumn('users', 'role')
                ? User::where('role', 'student')->count()
                : User::count(),

            'active_applicants'    => ScholarshipApplication::distinct('student_name')->count(),
        ];

        // 3. Fetch Recent Communications
        $announcements = Announcement::orderBy('updated_at', 'desc')->take(5)->get();

        return view('admin.dashboard', compact('announcements', 'stats'));
    }

    public function listApplications()
    {
        // We don't need .with('user') because the name is stored in 'student_name'
        $applications = ScholarshipApplication::latest()->get();

        return view('admin.applications.index', compact('applications'));
    }

    public function applications()
    {
        $applications = ScholarshipApplication::latest()->get();

        return view('admin.applications.index', compact('applications'));
    }
}
