<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PermintaanAkademik extends Model
{
    protected $table = 'permintaan_akademiks';
    
    protected $fillable = [
        'user_id',
        'nama',
        'nim',
        'type',
        'periode',
        'prodi',
        'judul',
        'dosen_pembimbing',
        'dosen_pembimbing_id',
        'dosen_pembimbing_2',
        'dosen_pembimbing_2_id',
        'tanggal_pengajuan',
        'tanggal_persetujuan',
        'status',
        'status_proposal',
        'disetujui_oleh',
        'is_selesai',
        'keterangan'
    ];

    protected $casts = [
        'is_selesai' => 'boolean',
        'tanggal_pengajuan' => 'date',
        'tanggal_persetujuan' => 'date'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function progress()
    {
        return $this->hasMany(PermintaanAkademikProgress::class);
    }

    public function bimbingan()
    {
        return $this->hasMany(Bimbingan::class);
    }

    public function jadwalUjian()
    {
        return $this->hasMany(JadwalUjian::class);
    }
}
