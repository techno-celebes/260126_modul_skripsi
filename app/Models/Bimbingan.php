<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Bimbingan extends Model
{
    protected $table = 'bimbingan';
    
    protected $fillable = [
        'permintaan_akademik_id',
        'judul',
        'catatan',
        'tanggal',
        'file_path',
        'status_validasi',
        'divalidasi_oleh',
        'tanggal_validasi',
        'catatan_dosen',
        'nilai'
    ];

    protected $casts = [
        'tanggal' => 'date',
        'tanggal_validasi' => 'date'
    ];

    public function permintaan()
    {
        return $this->belongsTo(PermintaanAkademik::class, 'permintaan_akademik_id');
    }
}
