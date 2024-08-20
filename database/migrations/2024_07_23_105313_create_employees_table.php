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
        Schema::create('employees', function (Blueprint $table) {
            $table->id();
            $table->string('employee_number')->unique();
            $table->string('last_name');
            $table->string('first_name');
            $table->string('middle_name');
            $table->foreignId('office_id')->constrained('offices')->cascadeOnDelete()->nullable();
            $table->foreignId('department_id')->constrained('departments')->cascadeOnDelete()->nullable();  
            $table->string('position')->nullable();  
            $table->foreignId('employment_types_id')->constrained('employment_types')->cascadeOnDelete()->nullable(); 
            $table->date('date_hired')->nullable();
            $table->string('biometric_id')->nullable(); 
            $table->string('payment_type')->nullable();  
            $table->string('monthly_basic_salary')->nullable(); 
            $table->boolean('monday_to_friday'); 
            $table->boolean('minimum_wage'); 
            $table->foreignId('payroll_group_id')->constrained('payroll_groups')->cascadeOnDelete()->nullable(); 
            $table->string('tin')->nullable();  
            $table->string('sss')->nullable();  
            $table->string('philhealth')->nullable();  
            $table->string('hdmf')->nullable(); 
            $table->string('timesheet_required')->nullable(); 
            $table->string('regular_holiday_pay')->nullable(); 
            $table->string('special_holiday_pay')->nullable(); 
            $table->string('premium_holiday_pay')->nullable(); 
            $table->string('regular_special_holiday_pay')->nullable(); 
            $table->string('restday_pay')->nullable(); 
            $table->string('overtime_pay')->nullable(); 
            $table->string('de_minimis')->nullable(); 
            $table->string('night_differential')->nullable(); 
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('employees');
    }
};
