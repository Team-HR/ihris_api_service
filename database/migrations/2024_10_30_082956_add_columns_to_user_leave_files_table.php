<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('user_leave_files', function (Blueprint $table) {
            $table->string('birth_certificate_filename')->nullable();
            $table->string('birth_certificate_path')->nullable();
            $table->string('medical_certificate_filename')->nullable();
            $table->string('medical_certificate_path')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('user_leave_files', function (Blueprint $table) {
            $table->dropColumn(['birth_certificate_filename', 'birth_certificate_path', 'medical_certificate_filename', 'medical_certificate_path']);
        });
    }
};
