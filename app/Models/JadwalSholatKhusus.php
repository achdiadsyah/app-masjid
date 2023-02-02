<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class JadwalSholatKhusus extends Model
{
    use HasFactory;

    protected $fillable = [
        'tanggal',
        'time',
        'sholat',
        'imam',
        'keterangan_imam',
        'muazin',
        'keterangan_muazin',
        'khatib',
        'keterangan_khatib',
        'created_by',
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'created_by', 'id');
    }
}
