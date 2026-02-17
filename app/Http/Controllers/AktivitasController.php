<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Inertia\Inertia;
use App\Models\AktivitasMahasiswa;
use App\Models\AktivitasMahasiswaLog;

class AktivitasController extends Controller
{
    public function index()
    {
        // Sync aktivitas dari KKN
        $kknList = \App\Models\KKN::where('user_id', auth()->id())->get();
        foreach ($kknList as $kkn) {
            $existing = AktivitasMahasiswa::where('user_id', auth()->id())
                ->where('jenis', 'KKN')
                ->where('keterangan', 'LIKE', '%' . $kkn->alamat . '%')
                ->first();
            
            if (!$existing) {
                AktivitasMahasiswa::create([
                    'user_id' => auth()->id(),
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
        
        // Sync aktivitas dari Permintaan Akademik
        $permintaanList = \App\Models\PermintaanAkademik::where('user_id', auth()->id())->get();
        foreach ($permintaanList as $permintaan) {
            $existing = AktivitasMahasiswa::where('user_id', auth()->id())
                ->where('jenis', $permintaan->type)
                ->where('judul', $permintaan->judul)
                ->first();
            
            if (!$existing) {
                AktivitasMahasiswa::create([
                    'user_id' => auth()->id(),
                    'nama' => $permintaan->nama,
                    'nim' => $permintaan->nim,
                    'jenis' => $permintaan->type,
                    'judul' => $permintaan->judul,
                    'keterangan' => $permintaan->keterangan ?? 'Permintaan ' . $permintaan->type,
                    'status' => $permintaan->status_proposal ?? 'Menunggu',
                    'dosen_pembimbing' => $permintaan->dosen_pembimbing,
                    'tanggal_pengajuan' => $permintaan->tanggal_pengajuan
                ]);
            } else {
                $existing->update([
                    'status' => $permintaan->status_proposal ?? 'Menunggu',
                    'dosen_pembimbing' => $permintaan->dosen_pembimbing
                ]);
            }
        }
        
        $aktivitas = AktivitasMahasiswa::where('user_id', auth()->id())
            ->with('logs')
            ->latest()
            ->get();
        
        return Inertia::render('Aktivitas', [
            'daftarAktivitas' => $aktivitas
        ]);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'nama' => 'required|string',
            'nim' => 'required|string',
            'jenis' => 'required|string',
            'keterangan' => 'required|string'
        ]);

        $aktivitas = AktivitasMahasiswa::create([
            'user_id' => auth()->id(),
            'nama' => $validated['nama'],
            'nim' => $validated['nim'],
            'jenis' => $validated['jenis'],
            'keterangan' => $validated['keterangan'],
            'status' => 'Menunggu'
        ]);

        AktivitasMahasiswaLog::create([
            'aktivitas_mahasiswa_id' => $aktivitas->id,
            'judul' => 'Aktivitas dibuat'
        ]);

        return redirect()->route('aktivitas');
    }

    public function show($id)
    {
        $aktivitas = AktivitasMahasiswa::where('id', $id)->where('user_id', auth()->id())->firstOrFail();
        
        // Sync status realtime dari sumber data
        $permintaanAkademik = \App\Models\PermintaanAkademik::where('user_id', auth()->id())
            ->where('type', $aktivitas->jenis)
            ->when($aktivitas->judul, function($q) use ($aktivitas) {
                return $q->where('judul', $aktivitas->judul);
            })
            ->latest()
            ->first();
        
        if ($permintaanAkademik) {
            $aktivitas->update([
                'status' => $permintaanAkademik->status_proposal ?? 'Menunggu',
                'dosen_pembimbing' => $permintaanAkademik->dosen_pembimbing,
                'tanggal_persetujuan' => $permintaanAkademik->tanggal_persetujuan
            ]);
        }
        
        if (strtolower($aktivitas->jenis) === 'kkn') {
            $kkn = \App\Models\KKN::where('user_id', auth()->id())->latest()->first();
            if ($kkn) {
                $aktivitas->update(['status' => $kkn->status]);
            }
        }
        
        $logs = collect();
        
        // Log manual
        $manualLogs = AktivitasMahasiswaLog::where('aktivitas_mahasiswa_id', $id)
            ->get()
            ->map(function($item) {
                return [
                    'id' => 'log_' . $item->id,
                    'judul' => $item->judul,
                    'deskripsi' => $item->deskripsi,
                    'tanggal' => $item->tanggal,
                    'created_at' => $item->created_at,
                    'file_path' => $item->file_path,
                    'nilai' => $item->nilai,
                    'status_validasi' => $item->status_validasi,
                    'catatan_nilai' => $item->catatan_nilai,
                    'divalidasi_oleh' => $item->divalidasi_oleh
                ];
            });
        
        $logs = $logs->concat($manualLogs);
        
        // Log dari KKN
        if (strtolower($aktivitas->jenis) === 'kkn') {
            $kknData = \App\Models\KKN::where('user_id', auth()->id())
                ->with('aktivitas')
                ->get();
            
            foreach ($kknData as $kkn) {
                foreach ($kkn->aktivitas as $kknAktivitas) {
                    $logs->push([
                        'id' => 'kkn_' . $kknAktivitas->id,
                        'judul' => $kknAktivitas->judul,
                        'deskripsi' => $kknAktivitas->deskripsi,
                        'tanggal' => $kknAktivitas->tanggal,
                        'created_at' => $kknAktivitas->created_at,
                        'file_path' => $kknAktivitas->file_path,
                        'nilai' => $kknAktivitas->nilai,
                        'status_validasi' => $kknAktivitas->status_validasi,
                        'catatan_nilai' => $kknAktivitas->catatan_nilai,
                        'divalidasi_oleh' => $kknAktivitas->divalidasi_oleh
                    ]);
                }
            }
        }
        
        // Log dari Permintaan Akademik
        if ($permintaanAkademik) {
            foreach ($permintaanAkademik->progress as $progress) {
                $logs->push([
                    'id' => 'progress_' . $progress->id,
                    'judul' => $progress->judul,
                    'deskripsi' => $progress->deskripsi,
                    'tanggal' => $progress->tanggal,
                    'created_at' => $progress->created_at,
                    'file_path' => $progress->file_path,
                    'nilai' => $progress->nilai,
                    'status_validasi' => $progress->status_validasi,
                    'catatan_nilai' => $progress->catatan_nilai,
                    'divalidasi_oleh' => $progress->divalidasi_oleh
                ]);
            }
        }
        
        $logs = $logs->sortByDesc('created_at')->values();
        
        return Inertia::render('aktivitasd', [
            'aktivitas' => $aktivitas->fresh(),
            'logs' => $logs
        ]);
    }

    public function storeLog(Request $request, $id)
    {
        $aktivitas = AktivitasMahasiswa::where('id', $id)->where('user_id', auth()->id())->firstOrFail();
        
        $validated = $request->validate([
            'judul' => 'required|string',
            'file' => 'nullable|file|max:10240'
        ]);

        $filePath = null;
        if ($request->hasFile('file')) {
            $filePath = $request->file('file')->store('aktivitas_logs', 'public');
        }

        AktivitasMahasiswaLog::create([
            'aktivitas_mahasiswa_id' => $aktivitas->id,
            'judul' => $validated['judul'],
            'file_path' => $filePath
        ]);

        return back();
    }
}
