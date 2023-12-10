<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Alumni extends Model
{
    use HasFactory;

    protected $fillable = [
        'first_name',
        'middle_name',
        'last_name',
        'course',
        'year_graduated'
    ];

    public function user() {
        return $this->hasOne(User::class, 'alumni_id', 'id');
    }
}
