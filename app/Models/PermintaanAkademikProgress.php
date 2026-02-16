<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PermintaanAkademikProgress extends Model
{
    protected $table = 'permintaan_akademik_progress';
    
    protected $fillable = [
        'permintaan_akademik_id',
        'jenis_progress',
        'judul',
        'deskripsi',
        'tanggal',
        'file_path',
        'status_validasi',
        'divalidasi_oleh',
        'tanggal_validasi',
        'nilai',
        'catatan_nilai',
        'is_selesai'
    ];

    protected $casts = [
        'is_selesai' => 'boolean',
        'tanggal' => 'date',
        'tanggal_validasi' => 'date'
    ];

    public function permintaan()
    {
        return $this->belongsTo(PermintaanAkademik::class, 'permintaan_akademik_id');
    }
    
    public function permintaanAkademik()
    {
        return $this->belongsTo(PermintaanAkademik::class, 'permintaan_akademik_id');
    }
}
