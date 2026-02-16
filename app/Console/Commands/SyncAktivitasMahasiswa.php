<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\User;
use App\Models\KKN;
use App\Models\PermintaanAkademik;
use App\Models\AktivitasMahasiswa;

class SyncAktivitasMahasiswa extends Command
{
    protected $signature = 'aktivitas:sync {--user_id=}';
    protected $description = 'Sync aktivitas mahasiswa dari KKN dan Permintaan Akademik';

    public function handle()
    {
        $userId = $this->option('user_id');
        
        if ($userId) {
            $users = User::where('id', $userId)->where('role', 'mahasiswa')->get();
            if ($users->isEmpty()) {
                $this->error("Mahasiswa dengan ID {$userId} tidak ditemukan!");
                return 1;
            }
        } else {
            $users = User::where('role', 'mahasiswa')->get();
        }
        
        $this->info("Memulai sync untuk " . $users->count() . " mahasiswa...");
        $bar = $this->output->createProgressBar($users->count());
        
        $synced = 0;
        $created = 0;
        $updated = 0;
        
        foreach ($users as $user) {
            // Sync dari KKN
            $kknList = KKN::where('user_id', $user->id)->get();
            foreach ($kknList as $kkn) {
                $existing = AktivitasMahasiswa::where('user_id', $user->id)
                    ->where('jenis', 'KKN')
                    ->where('keterangan', 'LIKE', '%' . $kkn->alamat . '%')
                    ->first();
                
                if (!$existing) {
                    AktivitasMahasiswa::create([
                        'user_id' => $user->id,
                        'nama' => $kkn->nama,
                        'nim' => $kkn->nim,
                        'jenis' => 'KKN',
                        'keterangan' => 'KKN di ' . $kkn->alamat . ' selama ' . $kkn->durasi,
                        'status' => $kkn->status
                    ]);
                    $created++;
                } else {
                    $existing->update(['status' => $kkn->status]);
                    $updated++;
                }
                $synced++;
            }
            
            // Sync dari Permintaan Akademik
            $permintaanList = PermintaanAkademik::where('user_id', $user->id)->get();
            foreach ($permintaanList as $permintaan) {
                $existing = AktivitasMahasiswa::where('user_id', $user->id)
                    ->where('jenis', $permintaan->type)
                    ->where('judul', $permintaan->judul)
                    ->first();
                
                if (!$existing) {
                    AktivitasMahasiswa::create([
                        'user_id' => $user->id,
                        'nama' => $permintaan->nama,
                        'nim' => $permintaan->nim,
                        'jenis' => $permintaan->type,
                        'judul' => $permintaan->judul,
                        'keterangan' => $permintaan->keterangan ?? 'Permintaan ' . $permintaan->type,
                        'status' => $permintaan->status_proposal ?? 'Menunggu',
                        'dosen_pembimbing' => $permintaan->dosen_pembimbing,
                        'tanggal_pengajuan' => $permintaan->tanggal_pengajuan
                    ]);
                    $created++;
                } else {
                    $existing->update([
                        'status' => $permintaan->status_proposal ?? 'Menunggu',
                        'dosen_pembimbing' => $permintaan->dosen_pembimbing,
                        'tanggal_persetujuan' => $permintaan->tanggal_persetujuan
                    ]);
                    $updated++;
                }
                $synced++;
            }
            
            $bar->advance();
        }
        
        $bar->finish();
        $this->newLine(2);
        $this->info("✓ Sync selesai!");
        $this->table(
            ['Metric', 'Count'],
            [
                ['Total Mahasiswa', $users->count()],
                ['Total Synced', $synced],
                ['Created', $created],
                ['Updated', $updated],
            ]
        );
        
        return 0;
    }
}
