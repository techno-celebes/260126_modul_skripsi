<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class KKNAktivitas extends Model
{
    protected $table = 'kkn_aktivitas';
    
    protected $fillable = [
        'kkn_id',
        'tipe',
        'judul',
        'deskripsi',
        'tanggal',
        'file_path',
        'nilai',
        'status_validasi',
        'divalidasi_oleh',
        'tanggal_validasi',
        'catatan_nilai',
        'is_selesai'
    ];

    public function kkn()
    {
        return $this->belongsTo(KKN::class);
    }
}
