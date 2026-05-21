<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ScholarshipApplication;
use Illuminate\Support\Facades\Auth;
use App\Models\Announcement;


class StudentController extends Controller
{
    public function index()
    {
        $userEmail = Auth::user()->email;

        // 1. Fetch Application Counts for the Snapshot Section
        $totalApplications = ScholarshipApplication::where('student_email', $userEmail)->count();
        $pendingCount = ScholarshipApplication::where('student_email', $userEmail)->where('status', 'Pending')->count();
        $approvedCount = ScholarshipApplication::where('student_email', $userEmail)->where('status', 'Approved')->count();

        // 2. Fetch Announcements for the Mini Bulletin
        // Sorting by updated_at ensures edited scholarship details are seen first
        $announcements = Announcement::orderBy('updated_at', 'desc')->take(5)->get();

        // 3. (Optional) Keep your applications list if you use it elsewhere in the view
        $applications = ScholarshipApplication::where('student_email', $userEmail)
            ->orderBy('created_at', 'desc')
            ->get();

        return view('student.dashboard', compact(
            'totalApplications',
            'pendingCount',
            'approvedCount',
            'announcements',
            'applications'
        ));
    }
}
