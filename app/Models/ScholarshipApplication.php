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
        'remarks',
        'scholarship_id',

        'contact_number',
        'gwa',
        'guardian_name',

        'proof_of_income',
        'report_card',
        'birth_certificate',
    ];

    protected $attributes = [
        'status' => 'Pending',
    ];

    public function scholarship()
    {
        return $this->belongsTo(Scholarship::class, 'scholarship_id');
    }
}
