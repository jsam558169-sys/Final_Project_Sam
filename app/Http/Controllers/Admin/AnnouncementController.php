<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Announcement;

class AnnouncementController extends Controller
{
    public function index()
    {
        // Sorts by the latest update, pushing new and edited posts to the top
        $announcements = Announcement::orderBy('updated_at', 'desc')->get();

        return view('admin.announcements.index', compact('announcements'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required',
            'message' => 'required',
        ]);

        Announcement::create([
            'title' => $request->title,
            'message' => $request->message,
        ]);

        return redirect()->back()->with('success', 'Announcement posted successfully!');
    }

    public function update(Request $request, $id)
    {
        $announcement = Announcement::findOrFail($id);

        $announcement->update([
            'title' => $request->title,
            'message' => $request->message,
        ]);

        return redirect()->route('admin.announcements.index')
            ->with('success', 'Announcement updated successfully!');
    }

    public function destroy($id)
    {
        $announcement = Announcement::findOrFail($id);
        $announcement->delete();

        return redirect()->back()->with('success', 'Announcement deleted successfully!');
    }

    public function edit($id)
    {
        $announcement = Announcement::findOrFail($id);

        return view('admin.announcements.edit', compact('announcement'));
    }

    public function view($id)
    {
        $announcement = Announcement::findOrFail($id);
        return view('admin.announcements.view', compact('announcement'));
    }
}
