<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class JobPostingImages extends Model
{
    use HasFactory;

    protected $fillable = [
        'job_posting_id',
        'url',
    ];
}
