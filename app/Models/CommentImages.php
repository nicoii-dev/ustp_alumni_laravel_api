<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CommentImages extends Model
{
    use HasFactory;

    protected $fillable = [
        'commend_id',
        'url',
    ];
}
