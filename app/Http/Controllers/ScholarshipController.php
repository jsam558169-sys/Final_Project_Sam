<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Scholarship;

class ScholarshipController extends Controller
{
    public function index()
    {
        $scholarships = Scholarship::all();
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
}
