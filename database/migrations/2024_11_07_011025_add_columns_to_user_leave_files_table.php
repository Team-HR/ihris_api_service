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
            $table->string('operating_room_record_path')->nullable();
            $table->string('operating_room_record_filename')->nullable();
            $table->string('hospital_abstract_path')->nullable();
            $table->string('hospital_abstract_filename')->nullable();
            $table->string('discharge_summary_path')->nullable();
            $table->string('discharge_summary_filename')->nullable();
            $table->string('histopath_report_path')->nullable();
            $table->string('histopath_report_filename')->nullable();
            $table->string('fit_to_work_certification_path')->nullable();
            $table->string('fit_to_work_certification_filename')->nullable();
            $table->string('pre_adoptive_placement_authority_path')->nullable();
            $table->string('pre_adoptive_placement_authority_filename')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('user_leave_files', function (Blueprint $table) {
            $table->dropColumn([
                'operating_room_record_path',
                'operating_room_record_filename',
                'hospital_abstract_path',
                'hospital_abstract_filename',
                'discharge_summary_path',
                'discharge_summary_filename',
                'histopath_report_path',
                'histopath_report_filename',
                'fit_to_work_certification_path',
                'fit_to_work_certification_filename',
                'pre_adoptive_placement_authority_path',
                'pre_adoptive_placement_authority_filename',
            ]);
        });
    }
};
