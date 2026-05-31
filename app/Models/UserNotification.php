<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class UserNotification extends Model
{
    protected $fillable = [
        'user_id',
        'type',
        'title',
        'message',
        'is_read',
    ];

    /**
     * Menghubungkan notifikasi kembali ke pengguna (User) yang menerimanya.
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}