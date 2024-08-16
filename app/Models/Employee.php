<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Employee extends Model
{
    use HasFactory, SoftDeletes;

    public function employmenttypes(): BelongsTo
    {
        return $this->belongsTo(EmploymentTypes::class);
    }
}
