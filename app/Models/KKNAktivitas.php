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
        'file_path'
    ];

    public function kkn()
    {
        return $this->belongsTo(KKN::class);
    }
}
