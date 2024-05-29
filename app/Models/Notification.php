<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Notification extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'content',
        'type',
        'user_id',
        'is_read',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function markAsRead()
    {
        $this->is_read = true;
        $this->save();
    }

    public function markAsUnread()
    {
        $this->is_read = false;
        $this->save();
    }

    public function isRead()
    {
        return $this->is_read;
    }

    public static function unreadCount()
    {
        return auth()->user()->notifications->where('is_read', false)->count();
    }
}
