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
            $table->string('solo_parent_id_filename')->nullable();
            $table->string('solo_parent_id_path')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('user_leave_files', function (Blueprint $table) {
            $table->dropColumn(['solo_parent_id_path', 'solo_parent_id_filename']);
        });
    }
};
