<template>
    <div class="container-fluid py-4">
        <!-- Header -->
        <div class="d-flex justify-content-between align-items-center mb-4">
            <div>
                <h1 class="h3 fw-bold text-dark mb-1">PENGATURAN TUGAS AKHIR</h1>
                <br>
                <h2 class="text-muted mb-0">
                    Diberitahukan kepada seluruh mahasiswa tingkat akhir bahwa pelaksanaan Tugas Akhir (TA) diatur berdasarkan ketentuan sebagai berikut:<br>
                <br>
<p>A. Ketentuan Umum
<br>
Tugas Akhir merupakan mata kuliah wajib yang harus ditempuh sebagai syarat kelulusan program studi.

Mahasiswa yang berhak mengambil Tugas Akhir adalah mahasiswa yang telah memenuhi persyaratan akademik sesuai ketentuan program studi.

Pelaksanaan Tugas Akhir dilakukan secara individual, kecuali ditentukan lain oleh program studi.</p>
                
<p>B. Persyaratan Pengajuan Tugas Akhir
<br>
Mahasiswa telah lulus mata kuliah prasyarat Tugas Akhir.

Mahasiswa telah memenuhi jumlah Satuan Kredit Semester (SKS) minimum sesuai ketentuan.

Mahasiswa telah melakukan registrasi mata kuliah Tugas Akhir pada semester berjalan.

Mahasiswa mengajukan judul Tugas Akhir sesuai bidang keilmuan program studi.</p>

<p>C. Pembimbingan
<br>
Setiap mahasiswa akan dibimbing oleh satu atau dua dosen pembimbing yang ditetapkan oleh program studi.

Mahasiswa wajib melakukan bimbingan secara berkala dan terdokumentasi.

Pergantian dosen pembimbing hanya dapat dilakukan dengan persetujuan program studi.

Mahasiswa bertanggung jawab atas keaktifan dalam proses bimbingan.</p>

<p>D. Pelaksanaan dan Penulisan
<br>
Penulisan Tugas Akhir wajib mengikuti pedoman penulisan yang ditetapkan oleh fakultas/program studi.

Isi Tugas Akhir harus bersifat orisinal dan bebas dari plagiarisme.

Mahasiswa wajib melakukan pengecekan plagiarisme sesuai ambang batas yang ditentukan.

Segala bentuk pelanggaran akademik akan dikenakan sanksi sesuai peraturan yang berlaku.</p>

<p>E. Ujian Tugas Akhir
<br>
Mahasiswa yang telah memenuhi persyaratan administrasi dan akademik berhak mengikuti ujian Tugas Akhir.

Ujian Tugas Akhir dilaksanakan sesuai jadwal yang ditetapkan oleh program studi.

Mahasiswa wajib hadir tepat waktu dan mematuhi tata tertib ujian.

Hasil ujian Tugas Akhir ditetapkan oleh tim penguji.</p>

<p>F. Ketentuan Lain-lain
<br>
Hal-hal yang belum diatur dalam pengumuman ini akan ditetapkan kemudian oleh program studi.

Mahasiswa diharapkan selalu memantau informasi resmi terkait Tugas Akhir melalui media yang ditentukan.

Demikian pengumuman ini disampaikan untuk dapat diperhatikan dan dilaksanakan sebagaimana mestinya.</p>
                </h2>
            </div>
        </div>
    </div>
</template>

<script setup>
    import PanelLayout from '@/Layouts/PanelLayout/FinancePanelLayout.vue'

    defineOptions({ layout: PanelLayout })
    const props = defineProps({
        auth: Object
    });

</script>

<style scoped>
.card {
    border-radius: 12px;
}

.nav-tabs-custom .nav-link {
    border: none;
    color: #6c757d;
    font-weight: 500;
    padding: 0.75rem 1rem;
    border-radius: 8px;
    margin-right: 0.5rem;
}

.nav-tabs-custom .nav-link.active {
    background-color: #e7f1ff;
    color: #0d6efd;
}

.chart-container {
    height: 250px;
    position: relative;
}

.list-group-item:hover {
    background-color: #f8f9fa;
}
</style>