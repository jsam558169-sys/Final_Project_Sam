<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Scholarship extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'description'];

    /**
     * Define the relationship: A Scholarship has many Applications
     */
    public function applications()
    {
        // Replace ScholarshipApplication::class with the correct model name if different
        return $this->hasMany(ScholarshipApplication::class, 'scholarship_id');
    }
}
