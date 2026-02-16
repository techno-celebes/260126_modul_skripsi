<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Inertia\Inertia;
use App\Models\User;

class MahasiswaController extends Controller
{
    public function index()
    {
        $mahasiswa = User::where('role', 'mahasiswa')
            ->latest()
            ->get()
            ->map(function($user) {
                // Sync aktivitas realtime
                $this->syncMahasiswaAktivitas($user->id);
                
                // Hitung data realtime
                $aktivitasCount = \App\Models\AktivitasMahasiswa::where('user_id', $user->id)->count();
                $permintaanCount = \App\Models\PermintaanAkademik::where('user_id', $user->id)->count();
                $kknCount = \App\Models\KKN::where('user_id', $user->id)->count();
                
                // Hitung progress
                $totalAktivitas = $aktivitasCount;
                $selesaiCount = \App\Models\AktivitasMahasiswa::where('user_id', $user->id)
                    ->whereIn('status', ['Disetujui', 'Selesai'])
                    ->count();
                $progress = $totalAktivitas > 0 ? round(($selesaiCount / $totalAktivitas) * 100) : 0;
                
                return [
                    'id' => $user->id,
                    'name' => $user->name,
                    'nim' => $user->nim,
                    'email' => $user->email,
                    'aktivitas_count' => $aktivitasCount,
                    'permintaan_count' => $permintaanCount,
                    'kkn_count' => $kknCount,
                    'progress' => $progress,
                    'status_summary' => [
                        'pending' => \App\Models\AktivitasMahasiswa::where('user_id', $user->id)
                            ->whereIn('status', ['Pending', 'Menunggu'])
                            ->count(),
                        'disetujui' => \App\Models\AktivitasMahasiswa::where('user_id', $user->id)
                            ->where('status', 'Disetujui')
                            ->count(),
                        'ditolak' => \App\Models\AktivitasMahasiswa::where('user_id', $user->id)
                            ->where('status', 'Ditolak')
                            ->count(),
                    ]
                ];
            });

        return Inertia::render('Admin/Mahasiswa', [
            'mahasiswa' => $mahasiswa
        ]);
    }
    
    public function show($id)
    {
        $user = User::where('id', $id)->where('role', 'mahasiswa')->firstOrFail();
        
        // Sync aktivitas realtime
        $this->syncMahasiswaAktivitas($id);
        
        $aktivitas = \App\Models\AktivitasMahasiswa::where('user_id', $id)
            ->with('logs')
            ->latest()
            ->get();
        
        $permintaan = \App\Models\PermintaanAkademik::where('user_id', $id)
            ->with('progress')
            ->latest()
            ->get();
        
        $kkn = \App\Models\KKN::where('user_id', $id)
            ->with('aktivitas')
            ->latest()
            ->get();
        
        return Inertia::render('Admin/MahasiswaDetail', [
            'mahasiswa' => $user,
            'aktivitas' => $aktivitas,
            'permintaan' => $permintaan,
            'kkn' => $kkn
        ]);
    }
    
    private function syncMahasiswaAktivitas($userId)
    {
        // Sync dari KKN
        $kknList = \App\Models\KKN::where('user_id', $userId)->get();
        foreach ($kknList as $kkn) {
            $existing = \App\Models\AktivitasMahasiswa::where('user_id', $userId)
                ->where('jenis', 'KKN')
                ->where('keterangan', 'LIKE', '%' . $kkn->alamat . '%')
                ->first();
            
            if (!$existing) {
                \App\Models\AktivitasMahasiswa::create([
                    'user_id' => $userId,
                    'nama' => $kkn->nama,
                    'nim' => $kkn->nim,
                    'jenis' => 'KKN',
                    'keterangan' => 'KKN di ' . $kkn->alamat . ' selama ' . $kkn->durasi,
                    'status' => $kkn->status
                ]);
            } else {
                $existing->update(['status' => $kkn->status]);
            }
        }
        
        // Sync dari Permintaan Akademik
        $permintaanList = \App\Models\PermintaanAkademik::where('user_id', $userId)->get();
        foreach ($permintaanList as $permintaan) {
            $existing = \App\Models\AktivitasMahasiswa::where('user_id', $userId)
                ->where('jenis', $permintaan->type)
                ->where('judul', $permintaan->judul)
                ->first();
            
            if (!$existing) {
                \App\Models\AktivitasMahasiswa::create([
                    'user_id' => $userId,
                    'nama' => $permintaan->nama,
                    'nim' => $permintaan->nim,
                    'jenis' => $permintaan->type,
                    'judul' => $permintaan->judul,
                    'keterangan' => $permintaan->keterangan ?? 'Permintaan ' . $permintaan->type,
                    'status' => $permintaan->status_proposal ?? 'Menunggu',
                    'dosen_pembimbing' => $permintaan->dosen_pembimbing
                ]);
            } else {
                $existing->update([
                    'status' => $permintaan->status_proposal ?? 'Menunggu',
                    'dosen_pembimbing' => $permintaan->dosen_pembimbing
                ]);
            }
        }
    }
}
