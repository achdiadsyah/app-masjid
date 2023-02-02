<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AppSetting extends Model
{
    use HasFactory;

    protected $fillable = [
        'revision_id',
        'interval',
        'is_ticker',
        'is_gallery',
        'is_idfitri',
        'is_idadha',
        'is_ramadhan',
        'ketua_bkm',
        'bendahara_bkm',
    ];
}
