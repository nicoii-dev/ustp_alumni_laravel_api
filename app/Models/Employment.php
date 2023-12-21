<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\User;

class Employment extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'status',
        'type',
        'state_of_reasons',
        'present_occupation',
        'line_of_business',
        'profession'
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }
}
