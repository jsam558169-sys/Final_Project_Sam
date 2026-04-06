<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ScholarshipApplicationController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\StudentController;
use App\Http\Controllers\ScholarshipController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

// Welcome page (public)
Route::get('/', function () {
    return view('welcome');
});

// Authenticated users dashboard (generic)
Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');
});

// Profile management
Route::middleware(['auth'])->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

// -----------------
// ADMIN ROUTES
// -----------------
Route::middleware(['auth', 'role:admin'])->prefix('admin')->name('admin.')->group(function () {


    // Admin dashboard
    Route::get('/dashboard', [AdminController::class, 'index'])->name('dashboard');

    // Scholarships management (CRUD)
    Route::resource('scholarships', ScholarshipController::class);

    // Applications management (CRUD)
    Route::resource('applications', ScholarshipApplicationController::class);

    // Applications management (full CRUD)
    Route::get('/applications', [ScholarshipApplicationController::class, 'index'])->name('applications.index');
    Route::get('/applications/create', [ScholarshipApplicationController::class, 'adminCreate'])->name('applications.create');
    Route::post('/applications', [ScholarshipApplicationController::class, 'adminStore'])->name('applications.store');
    Route::get('/applications/{id}/edit', [ScholarshipApplicationController::class, 'edit'])->name('applications.edit');
    Route::put('/applications/{id}', [ScholarshipApplicationController::class, 'update'])->name('applications.update');
    Route::delete('/applications/{id}', [ScholarshipApplicationController::class, 'destroy'])->name('applications.destroy');
});

// -----------------
// STUDENT ROUTES
// -----------------
Route::middleware(['auth', 'role:student'])->prefix('student')->name('student.')->group(function () {

    // Student dashboard
    Route::get('/dashboard', [StudentController::class, 'index'])->name('dashboard');

    // Student applications (view + create only)
    Route::get('/applications', [ScholarshipApplicationController::class, 'index'])->name('applications.index');
    Route::get('/applications/create', [ScholarshipApplicationController::class, 'create'])->name('applications.create');
    Route::post('/applications', [ScholarshipApplicationController::class, 'store'])->name('applications.store');

    // Students cannot edit or delete applications
});

// Auth routes (Breeze)
require __DIR__ . '/auth.php';
