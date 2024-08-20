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
        Schema::create('attendances', function (Blueprint $table) {
            $table->id();
            $table->integer('maximum_pairing_hours')->nullable();
            $table->integer('minimum_pairing_range')->nullable();
            $table->time('night_shift_differential_start')->nullable();
            $table->time('night_shift_differential_end')->nullable();
            $table->boolean('automatically_mark_absent'); 
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('attendances');
    }
};
