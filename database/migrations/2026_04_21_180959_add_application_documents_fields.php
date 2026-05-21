<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('scholarship_applications', function (Blueprint $table) {

            $table->string('contact_number')->nullable();
            $table->decimal('gwa', 5, 2)->nullable();
            $table->string('guardian_name')->nullable();

            $table->string('proof_of_income')->nullable();
            $table->string('report_card')->nullable();
            $table->string('birth_certificate')->nullable();
        });
    }

    public function down(): void
    {
        Schema::table('scholarship_applications', function (Blueprint $table) {

            $table->dropColumn([
                'contact_number',
                'gwa',
                'guardian_name',
                'proof_of_income',
                'report_card',
                'birth_certificate'
            ]);
        });
    }
};
