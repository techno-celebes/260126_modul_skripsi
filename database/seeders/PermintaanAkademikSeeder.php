<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\AktivitasMahasiswa;
use App\Models\AktivitasMahasiswaLog;
use App\Models\User;
use Carbon\Carbon;

class PermintaanAkademikSeeder extends Seeder
{
    public function run(): void
    {
        $user = User::first();
        
        if (!$user) {
            $this->command->warn('Tidak ada user. Silakan buat user terlebih dahulu.');
            return;
        }

        // Contoh 1: Skripsi - Sudah disetujui
        $aktivitas1 = AktivitasMahasiswa::create([
            'user_id' => $user->id,
            'nama' => $user->name,
            'nim' => $user->nim ?? '1234567890',
            'jenis' => 'Skripsi',
            'keterangan' => 'Pengajuan skripsi dengan topik sistem informasi',
            'judul' => 'Evaluasi Tata Kelola Sistem Pemerintahan Berbasis E-Government',
            'dosen_pembimbing' => 'Dr. Ahmad Fauzi, M.Kom',
            'dosen_pembimbing_id' => 'DSN001',
            'tanggal_pengajuan' => Carbon::now()->subDays(30),
            'tanggal_persetujuan' => Carbon::now()->subDays(25),
            'status' => 'Disetujui',
            'status_proposal' => 'Disetujui',
            'disetujui_oleh' => 'Dr. Ahmad Fauzi, M.Kom',
            'is_selesai' => false
        ]);

        // Log untuk aktivitas 1
        AktivitasMahasiswaLog::create([
            'aktivitas_mahasiswa_id' => $aktivitas1->id,
            'jenis_log' => 'proposal',
            'judul' => 'Pengajuan Proposal',
            'deskripsi' => 'Mahasiswa mengajukan proposal skripsi',
            'tanggal' => Carbon::now()->subDays(30),
            'is_selesai' => true
        ]);

        AktivitasMahasiswaLog::create([
            'aktivitas_mahasiswa_id' => $aktivitas1->id,
            'jenis_log' => 'progress',
            'judul' => 'Proposal Diperiksa',
            'deskripsi' => 'Proposal telah diperiksa oleh dosen pembimbing',
            'tanggal' => Carbon::now()->subDays(27),
            'divalidasi_oleh' => 'Dr. Ahmad Fauzi, M.Kom',
            'tanggal_validasi' => Carbon::now()->subDays(27),
            'is_selesai' => true
        ]);

        AktivitasMahasiswaLog::create([
            'aktivitas_mahasiswa_id' => $aktivitas1->id,
            'jenis_log' => 'progress',
            'judul' => 'Judul dan Dosen Pembimbing Ditentukan',
            'deskripsi' => 'Judul: Evaluasi Tata Kelola Sistem Pemerintahan Berbasis E-Government. Dosen Pembimbing: Dr. Ahmad Fauzi, M.Kom',
            'tanggal' => Carbon::now()->subDays(25),
            'divalidasi_oleh' => 'Tenaga Kependidikan',
            'tanggal_validasi' => Carbon::now()->subDays(25),
            'is_selesai' => true
        ]);

        AktivitasMahasiswaLog::create([
            'aktivitas_mahasiswa_id' => $aktivitas1->id,
            'jenis_log' => 'asistensi',
            'judul' => 'Asistensi Bab 1',
            'deskripsi' => 'Upload draft Bab 1 untuk review',
            'tanggal' => Carbon::now()->subDays(20),
            'file_path' => 'asistensi/bab1.pdf',
            'status_validasi' => 'Divalidasi',
            'divalidasi_oleh' => 'Dr. Ahmad Fauzi, M.Kom',
            'tanggal_validasi' => Carbon::now()->subDays(18),
            'is_selesai' => true
        ]);

        AktivitasMahasiswaLog::create([
            'aktivitas_mahasiswa_id' => $aktivitas1->id,
            'jenis_log' => 'asistensi',
            'judul' => 'Asistensi Bab 2',
            'deskripsi' => 'Upload draft Bab 2 untuk review',
            'tanggal' => Carbon::now()->subDays(10),
            'file_path' => 'asistensi/bab2.pdf',
            'status_validasi' => 'Menunggu',
            'is_selesai' => false
        ]);

        // Contoh 2: Skripsi - Menunggu persetujuan
        $aktivitas2 = AktivitasMahasiswa::create([
            'user_id' => $user->id,
            'nama' => $user->name,
            'nim' => $user->nim ?? '1234567890',
            'jenis' => 'Skripsi',
            'keterangan' => 'Pengajuan skripsi dengan topik machine learning',
            'judul' => 'Implementasi Metode Weight Aggregated Sum Product Assessment (WASPAS) untuk Sistem Pendukung Keputusan',
            'dosen_pembimbing' => 'Dr. Siti Nurhaliza, M.T',
            'tanggal_pengajuan' => Carbon::now()->subDays(5),
            'status' => 'Menunggu',
            'status_proposal' => 'Menunggu',
            'is_selesai' => false
        ]);

        AktivitasMahasiswaLog::create([
            'aktivitas_mahasiswa_id' => $aktivitas2->id,
            'jenis_log' => 'proposal',
            'judul' => 'Pengajuan Proposal',
            'deskripsi' => 'Mahasiswa mengajukan proposal skripsi',
            'tanggal' => Carbon::now()->subDays(5),
            'is_selesai' => false
        ]);

        AktivitasMahasiswaLog::create([
            'aktivitas_mahasiswa_id' => $aktivitas2->id,
            'jenis_log' => 'progress',
            'judul' => 'Menunggu Validasi Data',
            'deskripsi' => 'Berkas sedang dalam proses validasi oleh tenaga kependidikan',
            'tanggal' => Carbon::now()->subDays(4),
            'is_selesai' => false
        ]);

        $this->command->info('Seeder berhasil dijalankan!');
    }
}
