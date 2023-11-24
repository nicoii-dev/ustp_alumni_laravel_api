<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\PostImages;
use App\Models\User;
use App\Models\Like;

class Post extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'title',
        'likes',
    ];

    public function postImages()
    {
    return $this->hasMany(PostImages::class, 'post_id', 'id');
    }

    public function postOwner()
    {
    return $this->belongsTo(User::class, 'user_id', 'id');
    }

    public function postLikes()
    {
    return $this->hasMany(Like::class, 'post_id', 'id');
    }
}
