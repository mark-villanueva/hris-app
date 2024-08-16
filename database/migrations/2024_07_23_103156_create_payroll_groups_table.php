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
        Schema::create('payroll_groups', function (Blueprint $table) {
            $table->id();
            $table->string('payroll_group_name');
            $table->integer('days_per_year')->nullable();
            $table->integer('number_of_hours')->nullable();
            $table->string('period');
            $table->boolean('default'); 
            $table->string('first_timesheet_cutoff');
            $table->string('first_paydate');
            $table->string('second_timesheet_cutoff');
            $table->string('second_paydate');
            $table->string('paydate_on_non_workingday');
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('payroll_groups');
    }
};
