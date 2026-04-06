<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ScholarshipApplication;
use Illuminate\Support\Facades\Auth;

class StudentController extends Controller
{
    public function index()
    {
        // Only show applications for the logged-in student
        $applications = ScholarshipApplication::where('student_email', Auth::user()->email)
            ->orderBy('created_at', 'desc')
            ->get();

        return view('student.dashboard', compact('applications'));
    }
}
