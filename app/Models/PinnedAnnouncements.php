<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\AnnouncementImages;
use App\Models\Announcement;

class PinnedAnnouncements extends Model
{
    use HasFactory;

    protected $fillable = [
        'announcement_id',
        'user_id',
    ];

    public function announcement()
    {
        return $this->belongsTo(Announcement::class, 'announcement_id', 'id');
    }

    public function announcementImages()
    {
        return $this->hasMany(AnnouncementImages::class, 'announcement_id', 'announcement_id');
    }
}
