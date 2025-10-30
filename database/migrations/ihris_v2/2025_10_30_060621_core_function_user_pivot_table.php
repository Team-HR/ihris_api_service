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
        Schema::connection('ihris_v2')->create('core_function_user', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('core_function_id');
            $table->unsignedBigInteger('user_id');
            $table->timestamps();

            // ⚠️ Do NOT add foreign keys because they're across databases.
            // But you can index for performance:
            $table->index('core_function_id');
            $table->index('user_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::connection('ihris_v2')->dropIfExists('core_function_user');
    }
};
