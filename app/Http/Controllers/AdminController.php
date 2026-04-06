<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ScholarshipApplication;

class AdminController extends Controller
{
    public function index()
    {
        // Admin sees all applications
        $applications = ScholarshipApplication::all();
        return view('admin.dashboard', compact('applications'));
    }
}
