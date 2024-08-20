<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Validation\Rule;

class Employee extends Model
{
    use HasFactory, SoftDeletes;

    public function employmenttypes(): BelongsTo
    {
        return $this->belongsTo(EmploymentTypes::class);
    }

    public function payrollgroup(): BelongsTo
    {
        return $this->belongsTo(PayrollGroup::class);
    }

    public function office(): BelongsTo
    {
        return $this->belongsTo(Office::class);
    }

    public function department(): BelongsTo
    {
        return $this->belongsTo(Department::class);
    }


    // This loop will keep generating a new employee number until a unique one is found.
    public static function generateEmployeeNumber()
    {
        do {
            $year = date('Y');
            $randomDigits = str_pad(mt_rand(1, 9999), 4, '0', STR_PAD_LEFT);
            $employeeNumber = $year . '-EMP-' . $randomDigits;
        } while (self::where('employee_number', $employeeNumber)->exists());
    
        return $employeeNumber;
    }
 
     // Boot method to automatically generate unique employee number on creation 
     protected static function booted()
     {
         static::creating(function ($employee) {
             do {
                 $employee->employee_number = self::generateEmployeeNumber();
             } while (self::where('employee_number', $employee->employee_number)->exists());
         });
     }
     

     public static function rules()
    {
        return [
            'employee_number' => [
                'required',
                Rule::unique('employee')->ignore($this->id),
            ],
            // other validation rules...
        ];
    }
}
