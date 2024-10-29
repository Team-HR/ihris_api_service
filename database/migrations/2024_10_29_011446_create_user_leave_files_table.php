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
        Schema::create('user_leave_files', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('employees_id');
            $table->unsignedBigInteger('leave_id');
            $table->string('authority_of_leave_path')->nullable();
            $table->string('authority_of_leave_filename')->nullable();
            $table->string('clearance_path')->nullable();
            $table->string('clearance_filename')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('user_leave_files');
    }
};
