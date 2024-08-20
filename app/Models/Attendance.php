<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Attendance extends Model
{
    use HasFactory;

    protected $attributes = [
        'maximum_pairing_hours' => 20,
        'minimum_pairing_range' => 2,
        'night_shift_differential_start' => '10:00 pm',
        'night_shift_differential_end' => '6:00 am',
        'automatically_mark_absent' => True,


        
        
    ];
    
}
