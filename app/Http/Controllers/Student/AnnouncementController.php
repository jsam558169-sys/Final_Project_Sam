<?php

namespace App\Http\Controllers\Student;

use App\Http\Controllers\Controller;
use App\Models\Announcement;
use Illuminate\Http\Request; // Import Request

class AnnouncementController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->input('search');
        $sort = $request->input('sort', 'updated_at'); // Default to updated_at
        $direction = $request->input('direction', 'desc');

        $query = Announcement::query();

        // Search logic: Check title and message
        if ($search) {
            $query->where(function ($q) use ($search) {
                $q->where('title', 'like', "%{$search}%")
                    ->orWhere('message', 'like', "%{$search}%");
            });
        }

        // Apply Sorting
        $announcements = $query->orderBy($sort, $direction)->get();

        return view('student.announcements.index', compact('announcements'));
    }
}
