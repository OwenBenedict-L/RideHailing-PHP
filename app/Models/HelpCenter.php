<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class HelpCenter extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'jenis_keluhan',
        'isi_keluhan',
        'status',
    ];
}