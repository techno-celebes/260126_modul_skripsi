<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AktivitasMahasiswa extends Model
{
    protected $table = 'aktivitas_mahasiswa';
    
    protected $fillable = [
        'user_id',
        'nama',
        'nim',
        'jenis',
        'keterangan',
        'status'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function logs()
    {
        return $this->hasMany(AktivitasMahasiswaLog::class, 'aktivitas_mahasiswa_id');
    }
}
