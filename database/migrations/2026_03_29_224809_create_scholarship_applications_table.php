<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::create('scholarship_applications', function (Blueprint $table) {
            $table->id('studentID'); // custom primary key
            $table->string('student_name');
            $table->string('student_email')->nullable();
            $table->string('course');
            $table->integer('year_level');
            $table->enum('status', ['Pending', 'Approved', 'Rejected'])->default('Pending');
            $table->text('remarks')->nullable();
            $table->timestamps(); // adds created_at & updated_at
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('scholarship_applications');
    }
};
