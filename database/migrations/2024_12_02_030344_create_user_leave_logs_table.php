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
        Schema::create('user_leave_logs', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->unsignedBigInteger('employees_id');
            $table->unsignedBigInteger('leave_id');
            $table->float('vl_total_earned')->nullable();
            $table->float('vl_deduction')->nullable();
            $table->float('vl_balance')->nullable();
            $table->float('sl_total_earned')->nullable();
            $table->float('sl_deduction')->nullable();
            $table->float('sl_balance')->nullable();
            $table->string('days_with_pay')->nullable();
            $table->string('days_without_pay')->nullable();
            $table->string('others')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('user_leave_logs');
    }
};
