<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class JadwalPengajian extends Model
{
    use HasFactory;

    protected $fillable = [
        'tanggal',
        'waktu',
        'pengajian',
        'pengisi_kajian',
        'keterangan_pengisi_kajian',
        'topik_kajian',
        'created_by',
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'created_by', 'id');
    }
}
