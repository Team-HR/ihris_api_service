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
        Schema::connection('ihris_v2')->create('core_functions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('mfo_period_id')
                ->constrained('mfo_periods')
                ->cascadeOnDelete();
            $table->foreignId('parent_id')
                ->nullable()
                ->constrained('core_functions')
                ->nullOnDelete();   
            $table->foreignId('department_id')
                ->constrained('departments')
                ->cascadeOnDelete();
            $table->string('title');
            $table->string('order');
            $table->softDeletes();
            $table->timestamps();
        });

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('core_functions');
    }
};
