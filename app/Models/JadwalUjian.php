<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class JadwalUjian extends Model
{
    protected $table = 'jadwal_ujian';
    
    protected $fillable = [
        'permintaan_akademik_id',
        'jenis_ujian',
        'tanggal_ujian',
        'ruangan',
        'penguji_1',
        'penguji_2',
        'penguji_3',
        'catatan',
        'status'
    ];

    protected $casts = [
        'tanggal_ujian' => 'datetime'
    ];

    public function permintaan()
    {
        return $this->belongsTo(PermintaanAkademik::class, 'permintaan_akademik_id');
    }
}
