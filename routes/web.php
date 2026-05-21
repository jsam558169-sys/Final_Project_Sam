<?php

//npm run dev

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ScholarshipApplicationController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\StudentController;
use App\Http\Controllers\ScholarshipController;
use App\Http\Controllers\Admin\AnnouncementController;
use App\Http\Controllers\Student\AnnouncementController as StudentAnnouncementController;
use Illuminate\Support\Facades\Auth;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

// Welcome page (public)
Route::get('/', function () {
    return redirect()->route('login');
});

// Authenticated users dashboard (generic)
Route::middleware(['auth', 'verified'])->get('/dashboard', function () {
    if (Auth::user()->role === 'admin') {
        return redirect()->route('admin.dashboard');
    }

    if (Auth::user()->role === 'student') {
        return redirect()->route('student.dashboard');
    }

    abort(403);
})->name('dashboard');

// Profile management
Route::middleware(['auth'])->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    Route::get('/announcements', [StudentAnnouncementController::class, 'index'])
        ->name('announcements.index');
    Route::get('/announcements/{id}/edit', [AnnouncementController::class, 'edit'])
        ->name('announcements.edit');
});

// -----------------
// ADMIN ROUTES
// -----------------
Route::middleware(['auth', 'role:admin'])->prefix('admin')->name('admin.')->group(function () {


    // Admin dashboard
    Route::get('/dashboard', [AdminController::class, 'index'])->name('dashboard');

    // Scholarships management (CRUD)
    Route::resource('scholarships', ScholarshipController::class);

    Route::get('/announcements/{id}/view', [AnnouncementController::class, 'view'])->name('announcements.view');
    Route::resource('announcements', AnnouncementController::class);

    // Applications management (CRUD)
    Route::resource('applications', ScholarshipApplicationController::class);

    Route::get('/announcements', [AnnouncementController::class, 'index'])
        ->name('announcements.index');

    Route::post('/announcements', [AnnouncementController::class, 'store'])
        ->name('announcements.store');

    Route::put('/announcements/{id}', [AnnouncementController::class, 'update'])
        ->name('announcements.update');

    Route::delete('/announcements/{id}', [AnnouncementController::class, 'destroy'])
        ->name('announcements.destroy');

    Route::get('/announcements/{id}/edit', [AnnouncementController::class, 'edit'])
        ->name('announcements.edit');
});

// -----------------
// STUDENT ROUTES
// -----------------
Route::middleware(['auth', 'role:student'])->prefix('student')->name('student.')->group(function () {

    // Student dashboard
    Route::get('/dashboard', [ScholarshipApplicationController::class, 'dashboard'])->name('dashboard');

    // Student applications (view + create only)
    Route::get('/applications', [ScholarshipApplicationController::class, 'index'])->name('applications.index');
    Route::get('/applications/create', [ScholarshipApplicationController::class, 'create'])->name('applications.create');
    Route::post('/applications', [ScholarshipApplicationController::class, 'store'])->name('applications.store');

    Route::get('/scholarships', [ScholarshipController::class, 'studentIndex'])
        ->name('scholarships.index');

    Route::get('/announcements', [StudentAnnouncementController::class, 'index'])
        ->name('announcements.index');

    Route::get('/applications/{application}/view', [ScholarshipApplicationController::class, 'view'])
        ->name('applications.view');
});

// Auth routes (Breeze)
require __DIR__ . '/auth.php';
