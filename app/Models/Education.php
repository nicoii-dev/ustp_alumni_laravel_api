<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Education extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'college',
        'course',
        'college_sy',
        'high_school',
        'high_address',
        'high_sy',
        'elem_school',
        'elem_address',
        'elem_sy',
    ];
}
