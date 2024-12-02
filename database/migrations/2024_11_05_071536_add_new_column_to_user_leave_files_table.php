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
            $table->string('barangay_protection_order_path')->nullable();
            $table->string('barangay_protection_order_filename')->nullable();
            $table->string('temporary_or_permanent_protection_order_path')->nullable();
            $table->string('temporary_or_permanent_protection_order_filename')->nullable();
            $table->string('police_report_path')->nullable();
            $table->string('police_report_filename')->nullable();
            $table->string('incident_report_path')->nullable();
            $table->string('incident_report_filename')->nullable();
            $table->string('approved_letter_of_mayor_path')->nullable();
            $table->string('approved_letter_of_mayor_filename')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('user_leave_files', function (Blueprint $table) {
            $table->dropColumn(['barangay_protection_order_path', 'barangay_protection_order_filename', 'temporary_or_permanent_protection_order_path', 'temporary_or_permanent_protection_order_filename', 'police_report_path', 'police_report_filename', 'incident_report_path', 'incident_report_filename', 'approved_letter_of_mayor_path', 'approved_letter_of_mayor_filename']);
        });
    }
};
