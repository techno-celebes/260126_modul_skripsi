<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AktivitasMahasiswaLog extends Model
{
    protected $table = 'aktivitas_mahasiswa_log';
    
    protected $fillable = [
        'aktivitas_mahasiswa_id',
        'judul',
        'deskripsi',
        'tanggal',
        'file_path'
    ];

    public function aktivitas()
    {
        return $this->belongsTo(AktivitasMahasiswa::class, 'aktivitas_mahasiswa_id');
    }
}
