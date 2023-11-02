<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\JobPostingImages;

class JobPosting extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'description',
    ];

    public function jobImages()
    {
        return $this->hasMany(JobPostingImages::class, 'job_posting_id', 'id');
    }

}
