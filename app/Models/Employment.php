<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Employment extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'status',
        'type',
        'state_of_reasons',
        'present_occupation',
        'line_of_business'
    ];
}
