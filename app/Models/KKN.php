<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class KKN extends Model
{
    protected $table = 'kkn';
    
    protected $fillable = [
        'user_id',
        'nama',
        'nim',
        'alamat',
        'penanggung_jawab',
        'durasi',
        'status'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function aktivitas()
    {
        return $this->hasMany(KKNAktivitas::class, 'kkn_id');
    }
}
