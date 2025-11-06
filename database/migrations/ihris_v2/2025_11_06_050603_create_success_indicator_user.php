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
        Schema::connection('ihris_v2')->create('success_indicator_user', function (Blueprint $table) {
            $table->id();

            // Old DB user
            $table->unsignedBigInteger('user_id');

            // New DB success indicator
            $table->foreignId('success_indicator_id')
                ->constrained('success_indicators')
                ->cascadeOnDelete();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('success_indicator_user');
    }
};
