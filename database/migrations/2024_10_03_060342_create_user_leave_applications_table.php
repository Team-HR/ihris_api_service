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
        Schema::create('user_leave_applications', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->unsignedBigInteger('employees_id');
            $table->string('leave_type');
            $table->timestamp('date_of_filing')->nullable();
            $table->json('leave_dates');
            $table->text('remarks')->nullable();
            $table->enum('status', ['pending', 'rejected', 'approved']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('user_leave_applications');
    }
};
