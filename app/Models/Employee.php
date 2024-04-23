<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Employee extends Model
{
    use HasFactory;

    public function departments(): BelongsTo
    {
        return $this->belongsTo(Departments::class);
    }

    public function positions(): BelongsTo
    {
        return $this->belongsTo(Positions::class);
    }


    public function salary(): BelongsTo
    {
        return $this->belongsTo(Salary::class);
    }
    
}
