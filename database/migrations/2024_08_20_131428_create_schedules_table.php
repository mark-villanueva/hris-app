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
        Schema::create('schedules', function (Blueprint $table) {
            $table->id();
            $table->string('schedule_name');
            $table->time('time_in')->nullable();
            $table->time('break_time_start')->nullable();
            $table->time('break_time_end')->nullable();
            $table->time('time_out')->nullable();
            $table->boolean('default_schedule'); 
            $table->boolean('active'); 
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('schedules');
    }
};
