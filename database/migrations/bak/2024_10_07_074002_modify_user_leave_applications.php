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
        Schema::table('user_leave_applications', function (Blueprint $table) {
            $table->dropColumn('remarks');
            $table->boolean('within_philippines')->nullable();
            $table->boolean('abroad')->nullable();
            $table->boolean('in_hospital')->nullable();
            $table->boolean('out_patient')->nullable();
            $table->boolean('completion_of_masters_degree')->nullable();
            $table->boolean('bar_or_board_examination_review')->nullable();
            $table->text('specified_remark')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('user_leave_applications', function (Blueprint $table) {
            //
        });
    }
};
