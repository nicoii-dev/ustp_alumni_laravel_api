<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\AnnouncementImages;


class Announcement extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'title',
        'announcement',
    ];

    public function announcementImages()
    {
        return $this->hasMany(AnnouncementImages::class, 'announcement_id', 'id');
    }
}
