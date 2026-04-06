<?php

// app/Models/ScholarshipApplication.php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ScholarshipApplication extends Model
{
    use HasFactory;

    protected $table = 'scholarship_applications';
    protected $primaryKey = 'studentID';

    protected $fillable = [
        'student_name',
        'student_email',
        'course',
        'year_level',
        'status',
        'remarks'
    ];

    protected $attributes = [
        'status' => 'Pending',
    ];
}
