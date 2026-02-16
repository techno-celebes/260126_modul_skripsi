<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Inertia\Inertia;
use App\Models\User;
use App\Models\PermintaanAkademik;
use App\Models\KKN;
use App\Models\AktivitasMahasiswa;

class LaporanController extends Controller
{
    public function index()
    {
        // Sync semua aktivitas mahasiswa dari sumber data
        $allUsers = User::where('role', 'mahasiswa')->get();
        foreach ($allUsers as $user) {
            // Sync dari KKN
            $kknList = \App\Models\KKN::where('user_id', $user->id)->get();
            foreach ($kknList as $kkn) {
                $existing = \App\Models\AktivitasMahasiswa::where('user_id', $user->id)
                    ->where('jenis', 'KKN')
                    ->where('keterangan', 'LIKE', '%' . $kkn->alamat . '%')
                    ->first();
                
                if (!$existing) {
                    \App\Models\AktivitasMahasiswa::create([
                        'user_id' => $user->id,
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
            $permintaanList = \App\Models\PermintaanAkademik::where('user_id', $user->id)->get();
            foreach ($permintaanList as $permintaan) {
                $existing = \App\Models\AktivitasMahasiswa::where('user_id', $user->id)
                    ->where('jenis', $permintaan->type)
                    ->where('judul', $permintaan->judul)
                    ->first();
                
                if (!$existing) {
                    \App\Models\AktivitasMahasiswa::create([
                        'user_id' => $user->id,
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
        
        // Hitung statistik realtime
        $totalMahasiswa = User::where('role', 'mahasiswa')->count();
        $totalPermintaan = PermintaanAkademik::count();
        $totalKKN = KKN::count();
        $totalAktivitas = AktivitasMahasiswa::count();
        
        $stats = [
            'totalMahasiswa' => $totalMahasiswa,
            'totalPermintaan' => $totalPermintaan,
            'permintaanDisetujui' => PermintaanAkademik::where('status_proposal', 'Disetujui')->count(),
            'permintaanPending' => PermintaanAkademik::whereIn('status_proposal', ['Menunggu', 'Pending'])->count(),
            'permintaanDitolak' => PermintaanAkademik::where('status_proposal', 'Ditolak')->count(),
            'totalKKN' => $totalKKN,
            'kknAktif' => KKN::whereIn('status', ['Disetujui', 'Berlangsung'])->count(),
            'kknSelesai' => KKN::where('status', 'Selesai')->count(),
            'totalAktivitas' => $totalAktivitas,
            'aktivitasSelesai' => AktivitasMahasiswa::whereIn('status', ['Disetujui', 'Selesai'])->count(),
            'aktivitasPending' => AktivitasMahasiswa::whereIn('status', ['Pending', 'Menunggu'])->count(),
        ];
        
        // Data per bulan untuk grafik (SQLite compatible)
        $permintaanPerBulan = PermintaanAkademik::selectRaw("strftime('%m', created_at) as bulan, COUNT(*) as total")
            ->whereYear('created_at', date('Y'))
            ->groupBy('bulan')
            ->orderBy('bulan')
            ->get()
            ->map(function($item) {
                return [
                    'bulan' => date('F', mktime(0, 0, 0, (int)$item->bulan, 1)),
                    'total' => $item->total
                ];
            });
        
        // Data per jenis aktivitas
        $aktivitasPerJenis = AktivitasMahasiswa::selectRaw('jenis, COUNT(*) as total')
            ->groupBy('jenis')
            ->get()
            ->map(function($item) {
                return [
                    'jenis' => $item->jenis,
                    'total' => $item->total
                ];
            });

        return Inertia::render('Admin/Laporan', [
            'stats' => $stats,
            'permintaanPerBulan' => $permintaanPerBulan,
            'aktivitasPerJenis' => $aktivitasPerJenis
        ]);
    }
}
