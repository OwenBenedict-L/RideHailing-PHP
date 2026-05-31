<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Facades\Crypt;

class Chat extends Model 
{
    protected $fillable = [
        'senderUser_id',
        'receiverUser_id',
        'senderDriver_id',
        'receiverDriver_id',
        'message'
    ];

    public function setMessageAttribute($value)
    {
        $this->attributes['message'] = Crypt::encryptString($value);
    }

    public function getMessageAttribute($value)
    {
        return Crypt::decryptString($value);
    }

    public function senderUser(): BelongsTo
    {
        return $this->belongsTo(User::class, 'senderUser_id');
    }

    public function receiverUser(): BelongsTo
    {
        return $this->belongsTo(User::class, 'receiverUser_id');
    }

    public function senderDriver(): BelongsTo
    {
        return $this->belongsTo(Driver::class, 'senderDriver_id');
    }

    public function receiverDriver(): BelongsTo
    {
        return $this->belongsTo(Driver::class, 'receiverDriver_id');
    }
}
