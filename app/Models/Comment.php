<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\CommentImages;
use App\Models\User;

class Comment extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'post_id',
        'comment',
        'showComment',
    ];

    public function commentImages()
    {
        return $this->hasMany(CommentImages::class, 'comment_id', 'id');
    }

    public function commentOwner()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }
}
