<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\PermintaanAkademik;
use App\Models\PermintaanAkademikProgress;
use App\Models\User;
use Carbon\Carbon;

class PermintaanAkademikDemoSeeder extends Seeder
{
    public function run(): void
    {
        $user = User::first();
        
        if (!$user) {
            $this->command->warn('Tidak ada user. Silakan buat user terlebih dahulu.');
            return;
        }

        // Contoh 1: Proposal Skripsi - Sudah disetujui, ada progress
        $permintaan1 = PermintaanAkademik::create([
            'user_id' => $user->id,
            'nama' => $user->name,
            'nim' => $user->nim ?? '1234567890',
            'type' => 'Proposal Skripsi',
            'periode' => 'Periode Gasal 2025/2026',
            'prodi' => 'Teknik Informatika',
            'judul' => 'Evaluasi Tata Kelola Sistem Pemerintahan Berbasis E-Government',
            'dosen_pembimbing' => 'Dr. Ahmad Fauzi, M.Kom',
            'dosen_pembimbing_id' => 'DSN001',
            'tanggal_pengajuan' => Carbon::now()->subDays(45),
            'tanggal_persetujuan' => Carbon::now()->subDays(40),
            'status' => 'Disetujui',
            'status_proposal' => 'Disetujui',
            'disetujui_oleh' => 'Dr. Ahmad Fauzi, M.Kom',
            'is_selesai' => false
        ]);

        // Progress untuk permintaan 1
        PermintaanAkademikProgress::create([
            'permintaan_akademik_id' => $permintaan1->id,
            'jenis_progress' => 'proposal',
            'judul' => 'Pengajuan Proposal oleh Mahasiswa',
            'deskripsi' => 'Mahasiswa mengajukan proposal skripsi dengan judul: Evaluasi Tata Kelola Sistem Pemerintahan Berbasis E-Government',
            'tanggal' => Carbon::now()->subDays(45),
            'is_selesai' => true
        ]);

        PermintaanAkademikProgress::create([
            'permintaan_akademik_id' => $permintaan1->id,
            'jenis_progress' => 'progress',
            'judul' => 'Berkas Sudah Diperiksa',
            'deskripsi' => 'Proposal telah diperiksa dan divalidasi oleh dosen pembimbing',
            'tanggal' => Carbon::now()->subDays(42),
            'divalidasi_oleh' => 'Dr. Ahmad Fauzi, M.Kom',
            'tanggal_validasi' => Carbon::now()->subDays(42),
            'is_selesai' => true
        ]);

        PermintaanAkademikProgress::create([
            'permintaan_akademik_id' => $permintaan1->id,
            'jenis_progress' => 'progress',
            'judul' => 'Judul dan Dosen Pembimbing Telah Ditentukan',
            'deskripsi' => 'Judul: Evaluasi Tata Kelola Sistem Pemerintahan Berbasis E-Government. Dosen Pembimbing: Dr. Ahmad Fauzi, M.Kom',
            'tanggal' => Carbon::now()->subDays(40),
            'divalidasi_oleh' => 'Tenaga Kependidikan',
            'tanggal_validasi' => Carbon::now()->subDays(40),
            'is_selesai' => true
        ]);

        PermintaanAkademikProgress::create([
            'permintaan_akademik_id' => $permintaan1->id,
            'jenis_progress' => 'progress',
            'judul' => 'Disetujui oleh Dosen Pembimbing',
            'deskripsi' => 'Proposal telah disetujui dan mahasiswa dapat melanjutkan ke tahap penelitian',
            'tanggal' => Carbon::now()->subDays(40),
            'divalidasi_oleh' => 'Dr. Ahmad Fauzi, M.Kom',
            'tanggal_validasi' => Carbon::now()->subDays(40),
            'is_selesai' => true
        ]);

        // Asistensi untuk permintaan 1
        PermintaanAkademikProgress::create([
            'permintaan_akademik_id' => $permintaan1->id,
            'jenis_progress' => 'asistensi',
            'judul' => 'Asistensi Bab 1 - Pendahuluan',
            'deskripsi' => 'Upload draft Bab 1 untuk review dosen pembimbing',
            'tanggal' => Carbon::now()->subDays(30),
            'status_validasi' => 'Divalidasi',
            'divalidasi_oleh' => 'Dr. Ahmad Fauzi, M.Kom',
            'tanggal_validasi' => Carbon::now()->subDays(28),
            'is_selesai' => true
        ]);

        PermintaanAkademikProgress::create([
            'permintaan_akademik_id' => $permintaan1->id,
            'jenis_progress' => 'asistensi',
            'judul' => 'Asistensi Bab 2 - Tinjauan Pustaka',
            'deskripsi' => 'Upload draft Bab 2 untuk review dosen pembimbing',
            'tanggal' => Carbon::now()->subDays(20),
            'status_validasi' => 'Divalidasi',
            'divalidasi_oleh' => 'Dr. Ahmad Fauzi, M.Kom',
            'tanggal_validasi' => Carbon::now()->subDays(18),
            'is_selesai' => true
        ]);

        PermintaanAkademikProgress::create([
            'permintaan_akademik_id' => $permintaan1->id,
            'jenis_progress' => 'asistensi',
            'judul' => 'Asistensi Bab 3 - Metodologi',
            'deskripsi' => 'Upload draft Bab 3 untuk review dosen pembimbing',
            'tanggal' => Carbon::now()->subDays(10),
            'status_validasi' => 'Menunggu',
            'is_selesai' => false
        ]);

        // Contoh 2: Proposal Skripsi - Menunggu validasi
        $permintaan2 = PermintaanAkademik::create([
            'user_id' => $user->id,
            'nama' => $user->name,
            'nim' => $user->nim ?? '1234567890',
            'type' => 'Proposal Skripsi',
            'periode' => 'Periode Gasal 2025/2026',
            'prodi' => 'Teknik Informatika',
            'judul' => 'Implementasi Metode Weight Aggregated Sum Product Assessment (WASPAS) untuk Sistem Pendukung Keputusan Pemilihan Laptop',
            'dosen_pembimbing' => 'Dr. Siti Nurhaliza, M.T',
            'tanggal_pengajuan' => Carbon::now()->subDays(7),
            'status' => 'Menunggu',
            'status_proposal' => 'Menunggu',
            'is_selesai' => false
        ]);

        PermintaanAkademikProgress::create([
            'permintaan_akademik_id' => $permintaan2->id,
            'jenis_progress' => 'proposal',
            'judul' => 'Pengajuan Proposal oleh Mahasiswa',
            'deskripsi' => 'Mahasiswa mengajukan proposal skripsi dengan judul: Implementasi Metode WASPAS',
            'tanggal' => Carbon::now()->subDays(7),
            'is_selesai' => false
        ]);

        PermintaanAkademikProgress::create([
            'permintaan_akademik_id' => $permintaan2->id,
            'jenis_progress' => 'progress',
            'judul' => 'Menunggu Validasi Data Ujian TA',
            'deskripsi' => 'Berkas sedang dalam proses validasi oleh tenaga kependidikan',
            'tanggal' => Carbon::now()->subDays(6),
            'is_selesai' => false
        ]);

        // Contoh 3: Seminar Hasil - Sudah selesai
        $permintaan3 = PermintaanAkademik::create([
            'user_id' => $user->id,
            'nama' => $user->name,
            'nim' => $user->nim ?? '1234567890',
            'type' => 'Seminar Hasil Skripsi',
            'periode' => 'Periode Genap 2024/2025',
            'prodi' => 'Teknik Informatika',
            'judul' => 'Sistem Informasi Manajemen Perpustakaan Berbasis Web',
            'dosen_pembimbing' => 'Prof. Dr. Budi Santoso, M.Kom',
            'dosen_pembimbing_id' => 'DSN002',
            'tanggal_pengajuan' => Carbon::now()->subDays(90),
            'tanggal_persetujuan' => Carbon::now()->subDays(85),
            'status' => 'Disetujui',
            'status_proposal' => 'Disetujui',
            'disetujui_oleh' => 'Prof. Dr. Budi Santoso, M.Kom',
            'is_selesai' => true
        ]);

        PermintaanAkademikProgress::create([
            'permintaan_akademik_id' => $permintaan3->id,
            'jenis_progress' => 'proposal',
            'judul' => 'Pengajuan Seminar Hasil',
            'deskripsi' => 'Mahasiswa mengajukan seminar hasil skripsi',
            'tanggal' => Carbon::now()->subDays(90),
            'is_selesai' => true
        ]);

        PermintaanAkademikProgress::create([
            'permintaan_akademik_id' => $permintaan3->id,
            'jenis_progress' => 'progress',
            'judul' => 'Disetujui oleh Dosen Pembimbing',
            'deskripsi' => 'Seminar hasil telah disetujui oleh dosen pembimbing',
            'tanggal' => Carbon::now()->subDays(85),
            'divalidasi_oleh' => 'Prof. Dr. Budi Santoso, M.Kom',
            'tanggal_validasi' => Carbon::now()->subDays(85),
            'is_selesai' => true
        ]);

        PermintaanAkademikProgress::create([
            'permintaan_akademik_id' => $permintaan3->id,
            'jenis_progress' => 'progress',
            'judul' => 'Seminar Hasil Selesai',
            'deskripsi' => 'Seminar hasil telah dilaksanakan dan dinyatakan lulus',
            'tanggal' => Carbon::now()->subDays(80),
            'divalidasi_oleh' => 'Tenaga Kependidikan',
            'tanggal_validasi' => Carbon::now()->subDays(80),
            'is_selesai' => true
        ]);

        $this->command->info('✅ Seeder berhasil! 3 permintaan akademik dengan progress telah dibuat.');
    }
}
