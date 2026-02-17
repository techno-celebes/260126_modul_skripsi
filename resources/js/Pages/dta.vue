<template>
<div class="container-fluid py-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h1 class="h3 fw-bold text-dark mb-1">Detail Permintaan Akademik</h1>
            <p class="text-muted mb-0">{{ permintaan?.nama }}</p>
        </div>
        <button class="btn btn-secondary" @click="$inertia.visit('/tugasakhir')">
            Kembali
        </button>
    </div>

    <div class="row g-3">
        <div class="col-md-3">
            <div class="card">
                <div class="card-body p-2">
                    <button class="btn w-100 mb-2 tab-button" :class="activeTab === 'detail' ? 'btn-success' : 'btn-light'" @click="activeTab='detail'">
                        <i class="fa fa-info-circle me-2"></i>Detail Permintaan
                    </button>
                    <button class="btn w-100 mb-2 tab-button" :class="activeTab === 'progress' ? 'btn-success' : 'btn-light'" @click="activeTab='progress'">
                        <i class="fa fa-tasks me-2"></i>Progress
                    </button>
                    <button class="btn w-100 mb-2 tab-button" :class="activeTab === 'bimbingan' ? 'btn-success' : 'btn-light'" @click="activeTab='bimbingan'" :disabled="isDisabled">
                        <i class="fa fa-book me-2"></i>Bimbingan
                    </button>
                    <button class="btn w-100 mb-2 tab-button" :class="activeTab === 'syarat' ? 'btn-success' : 'btn-light'" @click="activeTab='syarat'" :disabled="isDisabled">
                        <i class="fa fa-check-square me-2"></i>Syarat Ujian
                    </button>
                    <button class="btn w-100 mb-2 tab-button" :class="activeTab === 'jadwal' ? 'btn-success' : 'btn-light'" @click="activeTab='jadwal'" :disabled="isDisabled">
                        <i class="fa fa-calendar me-2"></i>Jadwal Ujian
                    </button>
                    <button class="btn w-100 tab-button" :class="activeTab === 'nilai' ? 'btn-success' : 'btn-light'" @click="activeTab='nilai'" :disabled="isDisabled">
                        <i class="fa fa-star me-2"></i>Nilai Ujian
                    </button>
                </div>
            </div>
        </div>

        <div class="col-md-9">
            <div class="card">
                <div class="card-body">
                    
                    <!-- DETAIL -->
                    <div v-if="activeTab==='detail'">
                        <h5 class="fw-bold mb-3">Detail Permintaan</h5>
                        
                        <!-- Alert Status -->
                        <div v-if="permintaan?.status_proposal === 'Ditolak'" class="alert alert-danger mb-4">
                            <i class="fa fa-times-circle me-2"></i>
                            <strong>Permintaan Ditolak!</strong> Proposal Anda telah ditolak. Anda tidak dapat melanjutkan ke tahap bimbingan.
                            <div v-if="permintaan?.keterangan" class="mt-2">
                                <small><strong>Alasan:</strong> {{ permintaan.keterangan }}</small>
                            </div>
                        </div>
                        
                        <div v-if="permintaan?.status_proposal === 'Menunggu'" class="alert alert-warning mb-4">
                            <i class="fa fa-clock-o me-2"></i>
                            <strong>Menunggu Persetujuan!</strong> Proposal Anda sedang dalam proses review oleh admin. Harap tunggu hingga disetujui untuk melanjutkan ke tahap bimbingan.
                        </div>

                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label class="fw-bold text-dark">Nama</label>
                                <p class="text-dark">{{ permintaan?.nama || '-' }}</p>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="fw-bold text-dark">NIM</label>
                                <p class="text-dark">{{ permintaan?.nim || '-' }}</p>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label class="fw-bold text-dark">Jenis Permintaan</label>
                                <p class="text-dark">{{ permintaan?.type || '-' }}</p>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="fw-bold text-dark">Periode</label>
                                <p class="text-dark">{{ permintaan?.periode || '-' }}</p>
                            </div>
                        </div>
                        <div class="mb-3">
                            <label class="fw-bold text-dark">Program Studi</label>
                            <p class="text-dark">{{ permintaan?.prodi || '-' }}</p>
                        </div>
                        <div class="mb-3">
                            <label class="fw-bold text-dark">Judul</label>
                            <p class="text-dark">{{ permintaan?.judul || '-' }}</p>
                        </div>
                        
                        <!-- Dosen Pembimbing -->
                        <div class="mb-3">
                            <label class="fw-bold text-dark mb-2">Dosen Pembimbing</label>
                            <div class="row g-3">
                                <div class="col-md-6">
                                    <div class="card border">
                                        <div class="card-body p-3">
                                            <div class="d-flex align-items-center gap-3">
                                                <div class="avatar-circle bg-secondary">
                                                    <i class="fa fa-user"></i>
                                                </div>
                                                <div>
                                                    <small class="text-muted d-block">Pembimbing 1</small>
                                                    <strong>{{ permintaan?.dosen_pembimbing || 'Belum ditentukan' }}</strong>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="card border">
                                        <div class="card-body p-3">
                                            <div class="d-flex align-items-center gap-3">
                                                <div class="avatar-circle bg-secondary">
                                                    <i class="fa fa-user"></i>
                                                </div>
                                                <div>
                                                    <small class="text-muted d-block">Pembimbing 2</small>
                                                    <strong>{{ permintaan?.dosen_pembimbing_2 || 'Belum ditentukan' }}</strong>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <button v-if="!isDisabled" class="btn btn-sm btn-warning mt-2" @click="showEditDosen = true">
                                <i class="fa fa-edit me-1"></i>Edit Dosen Pembimbing
                            </button>
                        </div>

                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label class="fw-bold text-dark">Tanggal Pengajuan</label>
                                <p class="text-dark">{{ formatDate(permintaan?.tanggal_pengajuan) }}</p>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="fw-bold text-dark">Status</label>
                                <p><span class="badge fs-6" :class="getStatusClass(permintaan?.status_proposal)">{{ permintaan?.status_proposal || 'Menunggu' }}</span></p>
                            </div>
                        </div>
                    </div>

                    <!-- PROGRESS -->
                    <div v-if="activeTab==='progress'">
                        <h5 class="fw-bold mb-3">Progress</h5>

                        <ul class="nav nav-tabs mb-3">
                            <li class="nav-item">
                                <a class="nav-link" :class="{ active: subTab === 'timeline' }" @click="subTab = 'timeline'" style="cursor: pointer;">
                                    Timeline Progress
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" :class="{ active: subTab === 'asistensi' }" @click="subTab = 'asistensi'" style="cursor: pointer;">
                                    Upload Asistensi
                                </a>
                            </li>
                        </ul>

                        <!-- Timeline -->
                        <div v-if="subTab === 'timeline'">
                            <div class="timeline-container">
                                <div v-for="(item, index) in progressList" :key="item.id" class="timeline-item-wrapper">
                                    <div class="timeline-dot" :class="getDotClass(item)">
                                        <i class="fa fa-circle"></i>
                                    </div>
                                    <div v-if="index < progressList.length - 1" class="timeline-line"></div>
                                    <div class="timeline-content-box">
                                        <div class="d-flex justify-content-between align-items-start mb-2">
                                            <div>
                                                <h6 class="mb-1 fw-bold">{{ item.judul }}</h6>
                                                <p class="text-muted small mb-1">{{ item.deskripsi }}</p>
                                            </div>
                                            <span class="badge" :class="getProgressBadgeClass(item)">
                                                {{ getProgressStatus(item) }}
                                            </span>
                                        </div>
                                        <div class="text-muted small">
                                            <i class="fa fa-calendar me-1"></i>{{ formatDate(item.tanggal) }}
                                        </div>
                                        <div v-if="item.divalidasi_oleh" class="mt-2">
                                            <span class="badge bg-info">
                                                <i class="fa fa-user me-1"></i>{{ item.divalidasi_oleh }}
                                            </span>
                                        </div>
                                    </div>
                                </div>
                                <div v-if="progressList.length === 0" class="text-center text-muted py-4">
                                    <i class="fa fa-info-circle fa-2x mb-2"></i>
                                    <p>Belum ada progress</p>
                                </div>
                            </div>
                        </div>

                        <!-- Upload Asistensi -->
                        <div v-if="subTab === 'asistensi'">
                            <!-- Alert jika ditolak -->
                            <div v-if="permintaan.status_proposal === 'Ditolak'" class="alert alert-danger">
                                <i class="fa fa-exclamation-triangle me-2"></i>
                                <strong>Akses Ditolak!</strong> Proposal Anda telah ditolak. Anda tidak dapat mengupload asistensi.
                            </div>

                            <div v-else>
                                <div class="mb-4 p-3 border rounded">
                                    <div class="mb-3">
                                        <label>Judul Asistensi</label>
                                        <input class="form-control" placeholder="Masukkan Judul" v-model="uploadForm.judul">
                                    </div>
                                    <div class="mb-3">
                                        <label>Deskripsi</label>
                                        <textarea class="form-control" rows="3" placeholder="Masukkan Deskripsi" v-model="uploadForm.deskripsi"></textarea>
                                    </div>
                                    <div class="mb-3">
                                        <label>File (Maks 10MB - PDF/DOC/DOCX)</label>
                                        <input type="file" class="form-control" @change="e=>uploadForm.file=e.target.files[0]" accept=".pdf,.doc,.docx">
                                    </div>
                                    <button class="btn btn-success" :disabled="!isUploadValid" @click="submitUpload">
                                        Upload Asistensi
                                    </button>
                                </div>

                                <h6 class="fw-bold mb-2">Data Asistensi</h6>
                                <div class="table-responsive">
                                    <table class="table table-hover align-middle">
                                        <thead class="table-light">
                                            <tr>
                                                <th>No</th>
                                                <th>Judul</th>
                                            <th>Deskripsi</th>
                                            <th>Tanggal</th>
                                            <th>File</th>
                                            <th>Status</th>
                                            <th>Divalidasi Oleh</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr v-for="(item, index) in asistensiList" :key="item.id">
                                            <td>{{ index + 1 }}</td>
                                            <td>{{ item.judul }}</td>
                                            <td>{{ item.deskripsi || '-' }}</td>
                                            <td>{{ formatDate(item.tanggal) }}</td>
                                            <td>
                                                <a v-if="item.file_path" :href="`/storage/${item.file_path}`" target="_blank" class="btn btn-sm btn-info text-white">
                                                    Lihat
                                                </a>
                                                <span v-else>-</span>
                                            </td>
                                            <td>
                                                <span class="badge" :class="getValidasiClass(item.status_validasi)">
                                                    {{ item.status_validasi || 'Menunggu' }}
                                                </span>
                                            </td>
                                            <td>{{ item.divalidasi_oleh || '-' }}</td>
                                        </tr>
                                        <tr v-if="asistensiList.length === 0">
                                            <td colspan="7" class="text-center text-muted">Belum ada data</td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                            </div>
                        </div>
                    </div>

                    <!-- BIMBINGAN -->
                    <div v-if="activeTab==='bimbingan'">
                        <h5 class="fw-bold mb-3">Bimbingan</h5>
                        
                        <!-- Dosen Pembimbing Cards -->
                        <div class="row g-3 mb-4">
                            <div class="col-md-6">
                                <div class="card border-primary">
                                    <div class="card-body">
                                        <div class="d-flex align-items-center gap-3">
                                            <div class="avatar-circle-lg bg-secondary">
                                                <i class="fa fa-user text-white"></i>
                                            </div>
                                            <div>
                                                <small class="text-muted d-block">Dosen Pembimbing 1</small>
                                                <h6 class="mb-0 fw-bold">{{ permintaan?.dosen_pembimbing || 'Belum ditentukan' }}</h6>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="card border-info">
                                    <div class="card-body">
                                        <div class="d-flex align-items-center gap-3">
                                            <div class="avatar-circle-lg bg-secondary">
                                                <i class="fa fa-user text-white"></i>
                                            </div>
                                            <div>
                                                <small class="text-muted d-block">Dosen Pembimbing 2</small>
                                                <h6 class="mb-0 fw-bold">{{ permintaan?.dosen_pembimbing_2 || 'Belum ditentukan' }}</h6>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Form Upload Bimbingan -->
                        <div class="mb-4 p-4 border rounded">
                            <h6 class="fw-bold mb-3"><i class="fa fa-upload me-2"></i>Upload Kartu Bimbingan</h6>
                            <div class="mb-3">
                                <label class="fw-bold">Judul/Topik Bimbingan <span class="text-danger">*</span></label>
                                <input class="form-control" placeholder="Contoh: Bimbingan BAB 1 - Pendahuluan" v-model="bimbinganForm.judul">
                            </div>
                            <div class="mb-3">
                                <label class="fw-bold">Catatan Mahasiswa <span class="text-danger">*</span></label>
                                <textarea class="form-control" rows="3" placeholder="Tuliskan apa yang ingin dikonsultasikan kepada dosen pembimbing..." v-model="bimbinganForm.catatan"></textarea>
                                <small class="text-muted">Jelaskan materi yang dikonsultasikan dan pertanyaan Anda</small>
                            </div>
                            <div class="mb-3">
                                <label class="fw-bold">File Kartu Bimbingan (PDF/DOC/DOCX)</label>
                                <input type="file" class="form-control" @change="e=>bimbinganForm.file=e.target.files[0]" accept=".pdf,.doc,.docx">
                                <small class="text-muted">Upload kartu bimbingan yang sudah ditandatangani (opsional)</small>
                            </div>
                            <button class="btn btn-success" :disabled="!isBimbinganValid" @click="submitBimbingan">
                                <i class="fa fa-upload me-1"></i>Upload Bimbingan
                            </button>
                        </div>

                        <!-- Timeline Bimbingan -->
                        <h6 class="fw-bold mb-3">Riwayat Bimbingan</h6>
                        <div class="timeline-container">
                            <div v-for="(item, index) in bimbinganList" :key="item.id" class="timeline-item-wrapper">
                                <div class="timeline-dot" :class="item.status_validasi === 'Disetujui' ? 'completed' : 'pending'">
                                    <i class="fa fa-circle"></i>
                                </div>
                                <div v-if="index < bimbinganList.length - 1" class="timeline-line"></div>
                                <div class="timeline-content-box">
                                    <div class="d-flex justify-content-between align-items-start mb-2">
                                        <div class="flex-grow-1">
                                            <h6 class="mb-1 fw-bold">{{ item.judul }}</h6>
                                            <p v-if="item.catatan" class="text-muted small mb-1">
                                                <strong>Catatan Mahasiswa:</strong> {{ item.catatan }}
                                            </p>
                                            <p v-if="item.catatan_dosen" class="text-success small mb-1">
                                                <strong>Catatan Dosen:</strong> {{ item.catatan_dosen }}
                                            </p>
                                        </div>
                                        <span class="badge" :class="getValidasiClass(item.status_validasi)">
                                            {{ item.status_validasi || 'Menunggu' }}
                                        </span>
                                    </div>
                                    <div class="text-muted small mb-2">
                                        <i class="fa fa-calendar me-1"></i>{{ formatDate(item.tanggal) }}
                                    </div>
                                    <div class="d-flex gap-2 align-items-center flex-wrap">
                                        <a v-if="item.file_path" :href="`/storage/${item.file_path}`" target="_blank" class="btn btn-sm btn-info" title="Lihat File">
                                            <i class="fa fa-eye"></i>
                                        </a>
                                        <span v-if="item.divalidasi_oleh" class="badge bg-secondary">
                                            <i class="fa fa-user-check me-1"></i>Divalidasi: {{ item.divalidasi_oleh }}
                                        </span>
                                        <span v-if="item.tanggal_validasi" class="badge bg-light text-dark">
                                            <i class="fa fa-clock me-1"></i>{{ formatDate(item.tanggal_validasi) }}
                                        </span>
                                    </div>
                                    <div v-if="item.catatan_dosen" class="mt-2 p-2 border-start border-warning border-3 bg-light">
                                        <small class="fw-bold text-warning">Catatan Dosen:</small>
                                        <p class="small mb-0 mt-1">{{ item.catatan_dosen }}</p>
                                    </div>
                                </div>
                            </div>
                            <div v-if="bimbinganList.length === 0" class="text-center text-muted py-4">
                                <i class="fa fa-info-circle fa-2x mb-2"></i>
                                <p>Belum ada riwayat bimbingan</p>
                            </div>
                        </div>
                    </div>

                    <!-- SYARAT -->
                    <div v-if="activeTab==='syarat'">
                        <h5 class="fw-bold mb-3">Syarat Ujian</h5>
                        <div class="table-responsive">
                            <table class="table table-hover align-middle">
                                <thead class="table-light">
                                    <tr>
                                        <th>No</th>
                                        <th>Syarat</th>
                                        <th>Wajib</th>
                                        <th>Status</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td>1</td>
                                        <td>Kartu Bimbingan</td>
                                        <td>Ya</td>
                                        <td><span class="badge" :class="bimbinganList.length > 0 ? 'bg-success' : 'bg-danger'">{{ bimbinganList.length > 0 ? 'Sudah' : 'Belum' }}</span></td>
                                    </tr>
                                    <tr>
                                        <td>2</td>
                                        <td>Transkrip Nilai</td>
                                        <td>Ya</td>
                                        <td><span class="badge" :class="hasTranskrip ? 'bg-success' : 'bg-danger'">{{ hasTranskrip ? 'Sudah' : 'Belum' }}</span></td>
                                    </tr>
                                    <tr>
                                        <td>3</td>
                                        <td>Proposal Disetujui</td>
                                        <td>Ya</td>
                                        <td><span class="badge" :class="permintaan?.status_proposal === 'Disetujui' ? 'bg-success' : 'bg-danger'">{{ permintaan?.status_proposal === 'Disetujui' ? 'Sudah' : 'Belum' }}</span></td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>

                    <!-- JADWAL -->
                    <div v-if="activeTab==='jadwal'">
                        <h5 class="fw-bold mb-3">Jadwal Ujian</h5>
                        <div v-if="jadwalUjianList.length > 0">
                            <div v-for="jadwal in jadwalUjianList" :key="jadwal.id" class="card border-0 shadow-sm mb-3">
                                <div class="card-body p-4">
                                    <div class="d-flex justify-content-between align-items-start mb-3">
                                        <div>
                                            <h5 class="fw-bold mb-1 text-primary">
                                                <i class="fa fa-calendar-check me-2"></i>{{ jadwal.jenis_ujian }}
                                            </h5>
                                            <span class="badge bg-success">{{ jadwal.status }}</span>
                                        </div>
                                    </div>
                                    
                                    <div class="row g-3 mb-3">
                                        <div class="col-md-6">
                                            <div class="d-flex align-items-start">
                                                <i class="fa fa-clock text-primary me-2 mt-1"></i>
                                                <div>
                                                    <small class="text-muted d-block">Tanggal & Waktu</small>
                                                    <p class="mb-0 fw-bold">{{ formatDateTime(jadwal.tanggal_ujian) }}</p>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="d-flex align-items-start">
                                                <i class="fa fa-map-marker text-danger me-2 mt-1"></i>
                                                <div>
                                                    <small class="text-muted d-block">Ruangan</small>
                                                    <p class="mb-0 fw-bold">{{ jadwal.ruangan || '-' }}</p>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    
                                    <div class="mb-3">
                                        <small class="text-muted d-block mb-3">
                                            <i class="fa fa-users me-1"></i>Tim Penguji
                                        </small>
                                        <div class="row g-2">
                                            <div v-if="jadwal.penguji_1" class="col-md-4">
                                                <div class="card border-info h-100">
                                                    <div class="card-body p-3">
                                                        <div class="d-flex align-items-center gap-2">
                                                            <div class="avatar-circle-sm bg-info">
                                                                <span class="text-white fw-bold">1</span>
                                                            </div>
                                                            <div>
                                                                <small class="text-muted d-block">Penguji 1</small>
                                                                <strong class="small">{{ jadwal.penguji_1 }}</strong>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div v-if="jadwal.penguji_2" class="col-md-4">
                                                <div class="card border-info h-100">
                                                    <div class="card-body p-3">
                                                        <div class="d-flex align-items-center gap-2">
                                                            <div class="avatar-circle-sm bg-info">
                                                                <span class="text-white fw-bold">2</span>
                                                            </div>
                                                            <div>
                                                                <small class="text-muted d-block">Penguji 2</small>
                                                                <strong class="small">{{ jadwal.penguji_2 }}</strong>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div v-if="jadwal.penguji_3" class="col-md-4">
                                                <div class="card border-info h-100">
                                                    <div class="card-body p-3">
                                                        <div class="d-flex align-items-center gap-2">
                                                            <div class="avatar-circle-sm bg-info">
                                                                <span class="text-white fw-bold">3</span>
                                                            </div>
                                                            <div>
                                                                <small class="text-muted d-block">Penguji 3</small>
                                                                <strong class="small">{{ jadwal.penguji_3 }}</strong>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    
                                    <div v-if="jadwal.catatan" class="alert alert-warning mb-0">
                                        <i class="fa fa-sticky-note me-2"></i>
                                        <strong>Catatan:</strong> {{ jadwal.catatan }}
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div v-else class="alert alert-info">
                            <i class="fa fa-info-circle me-2"></i>
                            Jadwal ujian belum tersedia. Silakan hubungi admin untuk informasi lebih lanjut.
                        </div>
                    </div>

                    <!-- NILAI -->
                    <div v-if="activeTab==='nilai'">
                        <h5 class="fw-bold mb-3">Nilai Progress</h5>
                        
                        <div v-if="nilaiList.length > 0">
                            <div class="table-responsive">
                                <table class="table table-hover">
                                    <thead class="table-light">
                                        <tr>
                                            <th>No</th>
                                            <th>Judul</th>
                                            <th>Tanggal</th>
                                            <th>Nilai</th>
                                            <th>Status</th>
                                            <th>Catatan</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr v-for="(item, index) in nilaiList" :key="item.id">
                                            <td>{{ index + 1 }}</td>
                                            <td>{{ item.judul }}</td>
                                            <td>{{ formatDate(item.tanggal) }}</td>
                                            <td>
                                                <span v-if="item.nilai" class="badge bg-primary fs-6">{{ item.nilai }}</span>
                                                <span v-else class="text-muted">-</span>
                                            </td>
                                            <td>
                                                <span class="badge" :class="getValidasiClass(item.status_validasi)">
                                                    {{ item.status_validasi || 'Menunggu' }}
                                                </span>
                                            </td>
                                            <td>{{ item.catatan_nilai || '-' }}</td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>

                            <div class="row g-3 mt-3">
                                <div class="col-md-6">
                                    <div class="card bg-light">
                                        <div class="card-body text-center">
                                            <h6 class="text-muted">Rata-rata Nilai</h6>
                                            <h2 class="fw-bold text-primary">{{ rataRataNilai }}</h2>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="card bg-light">
                                        <div class="card-body text-center">
                                            <h6 class="text-muted">Total Dinilai</h6>
                                            <h2 class="fw-bold text-success">{{ totalDinilai }}</h2>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div v-else class="alert alert-info">
                            Belum ada nilai untuk permintaan ini.
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>

    <!-- Modal Edit Dosen -->
    <div v-if="showEditDosen" class="modal-backdrop-custom">
        <div class="modal-card">
            <div class="modal-header-custom bg-warning">
                <h5 class="fw-bold mb-0">Edit Dosen Pembimbing</h5>
                <button class="btn-close" @click="closeEditDosen"></button>
            </div>
            <div class="modal-body-custom">
                <div class="mb-3">
                    <label class="fw-bold">Dosen Pembimbing 1</label>
                    <input class="form-control" v-model="dosenForm.dosen_pembimbing" placeholder="Nama Dosen Pembimbing 1">
                </div>
                <div class="mb-3">
                    <label class="fw-bold">Dosen Pembimbing 2</label>
                    <input class="form-control" v-model="dosenForm.dosen_pembimbing_2" placeholder="Nama Dosen Pembimbing 2">
                </div>
            </div>
            <div class="modal-footer-custom">
                <button class="btn btn-secondary" @click="closeEditDosen">Batal</button>
                <button class="btn btn-warning" @click="updateDosen">Simpan</button>
            </div>
        </div>
    </div>
</div>
</template>

<script setup>
import { ref, computed } from 'vue'
import { router } from '@inertiajs/vue3'
import PanelLayout from '@/Layouts/PanelLayout/FinancePanelLayout.vue'

defineOptions({ layout: PanelLayout })

const props = defineProps({
    permintaan: Object,
    progress: { type: Array, default: () => [] },
    bimbingan: { type: Array, default: () => [] },
    jadwalUjian: { type: Array, default: () => [] }
})

const activeTab = ref('detail')
const subTab = ref('timeline')
const showEditDosen = ref(false)

const uploadForm = ref({ judul: '', deskripsi: '', file: null })
const bimbinganForm = ref({ judul: '', catatan: '', file: null })
const dosenForm = ref({
    dosen_pembimbing: props.permintaan?.dosen_pembimbing || '',
    dosen_pembimbing_2: props.permintaan?.dosen_pembimbing_2 || ''
})

const isDitolak = computed(() => props.permintaan?.status_proposal === 'Ditolak')
const isDisabled = computed(() => props.permintaan?.status_proposal !== 'Disetujui')
const progressList = computed(() => props.progress.filter(p => p.jenis_progress === 'progress' || p.jenis_progress === 'proposal'))
const asistensiList = computed(() => props.progress.filter(p => p.jenis_progress === 'asistensi'))
const bimbinganList = computed(() => props.bimbingan || [])
const jadwalUjianList = computed(() => props.jadwalUjian || [])
const nilaiList = computed(() => props.progress.filter(p => p.jenis_progress === 'asistensi' && p.file_path))

const rataRataNilai = computed(() => {
    const nilaiArray = nilaiList.value.filter(item => item.nilai).map(item => parseFloat(item.nilai))
    if (nilaiArray.length === 0) return '0.00'
    return (nilaiArray.reduce((a, b) => a + b, 0) / nilaiArray.length).toFixed(2)
})

const totalDinilai = computed(() => nilaiList.value.filter(item => item.nilai).length)
const hasTranskrip = computed(() => totalDinilai.value > 0)
const isUploadValid = computed(() => uploadForm.value.judul.trim() !== '' && uploadForm.value.file !== null)
const isBimbinganValid = computed(() => bimbinganForm.value.judul.trim() !== '')

function formatDate(date) {
    if (!date) return '-'
    return new Date(date).toLocaleDateString('id-ID', { 
        day: '2-digit', 
        month: 'long', 
        year: 'numeric' 
    })
}

function formatDateTime(date) {
    if (!date) return '-'
    return new Date(date).toLocaleDateString('id-ID', { 
        day: '2-digit', 
        month: 'long', 
        year: 'numeric', 
        hour: '2-digit', 
        minute: '2-digit' 
    })
}

function getStatusClass(status) {
    const map = {
        'Menunggu': 'bg-warning text-dark',
        'Disetujui': 'bg-success text-white',
        'Ditolak': 'bg-danger text-white'
    }
    return map[status] || 'bg-secondary text-white'
}

function getValidasiClass(status) {
    const map = {
        'Menunggu': 'bg-warning text-dark',
        'Disetujui': 'bg-success text-white',
        'Ditolak': 'bg-danger text-white'
    }
    return map[status] || 'bg-secondary text-white'
}

function getDotClass(item) {
    if (item.judul && item.judul.toLowerCase().includes('ditolak')) return 'rejected'
    return item.is_selesai ? 'completed' : 'pending'
}

function getProgressStatus(item) {
    if (item.judul && item.judul.toLowerCase().includes('ditolak')) return 'Ditolak'
    return item.is_selesai ? 'Selesai' : 'Proses'
}

function getProgressBadgeClass(item) {
    if (item.judul && item.judul.toLowerCase().includes('ditolak')) return 'bg-danger text-white'
    return item.is_selesai ? 'bg-success text-white' : 'bg-warning text-dark'
}

function submitUpload() {
    const formData = new FormData()
    formData.append('jenis_progress', 'asistensi')
    formData.append('judul', uploadForm.value.judul)
    formData.append('deskripsi', uploadForm.value.deskripsi)
    formData.append('file', uploadForm.value.file)

    router.post(`/tugasakhir/${props.permintaan.id}/progress`, formData, {
        onSuccess: () => { uploadForm.value = { judul: '', deskripsi: '', file: null } }
    })
}

function submitBimbingan() {
    const formData = new FormData()
    formData.append('judul', bimbinganForm.value.judul)
    formData.append('catatan', bimbinganForm.value.catatan)
    if (bimbinganForm.value.file) formData.append('file', bimbinganForm.value.file)

    router.post(`/tugasakhir/${props.permintaan.id}/bimbingan`, formData, {
        onSuccess: () => { bimbinganForm.value = { judul: '', catatan: '', file: null } },
        onError: (errors) => { alert(errors.error || 'Terjadi kesalahan') }
    })
}

function updateDosen() {
    router.post(`/tugasakhir/${props.permintaan.id}/dosen`, dosenForm.value, {
        onSuccess: () => { showEditDosen.value = false }
    })
}

function closeEditDosen() {
    showEditDosen.value = false
    dosenForm.value = {
        dosen_pembimbing: props.permintaan?.dosen_pembimbing || '',
        dosen_pembimbing_2: props.permintaan?.dosen_pembimbing_2 || ''
    }
}
</script>

<style scoped>
.card{border-radius:12px;}
.tab-button{text-align:left;font-weight:600;transition:all 0.3s ease;}
.tab-button:hover{transform:translateX(5px);}
.tab-button:disabled{opacity:0.5;cursor:not-allowed;}

.table th{background-color:#f8f9fa;font-weight:600;text-align:center;vertical-align:middle;padding:16px 12px;}
.table td{text-align:center;vertical-align:middle;padding:14px 12px;}

.avatar-circle{
    width:50px;height:50px;border-radius:50%;
    background:#6c757d;
    display:flex;align-items:center;justify-content:center;
    color:white;font-size:20px;
}

.avatar-circle-lg{
    width:60px;height:60px;border-radius:50%;
    display:flex;align-items:center;justify-content:center;
    font-size:24px;
}

.avatar-circle-sm{
    width:40px;height:40px;border-radius:50%;
    display:flex;align-items:center;justify-content:center;
    font-size:16px;
    flex-shrink:0;
}

.timeline-container{position:relative;padding-left:30px;}
.timeline-item-wrapper{position:relative;margin-bottom:25px;}

.timeline-dot{
    position:absolute;left:-27px;top:0;
    font-size:14px;z-index:2;
}

.timeline-dot.completed i{color:#28a745;}
.timeline-dot.pending i{color:#ffc107;}
.timeline-dot.rejected i{color:#dc3545;}

.timeline-line{
    position:absolute;left:-21px;top:20px;
    width:2px;height:calc(100% - 10px);
    background:#e5e7eb;z-index:1;
}

.timeline-content-box{
    background:#f8f9fa;padding:15px 20px;
    border-radius:12px;border-left:4px solid #0d6efd;
    box-shadow:0 2px 4px rgba(0,0,0,0.05);
    transition:all 0.3s ease;
}

.timeline-content-box:hover{
    box-shadow:0 4px 12px rgba(0,0,0,0.1);
    transform:translateX(5px);
}

.modal-backdrop-custom{
    position:fixed;inset:0;background:rgba(0,0,0,0.5);
    display:flex;justify-content:center;align-items:center;z-index:9999;
}

.modal-card{
    width:600px;max-height:90vh;background:white;
    border-radius:12px;display:flex;flex-direction:column;
}

.modal-header-custom{
    padding:16px 20px;display:flex;
    justify-content:space-between;align-items:center;
    border-radius:12px 12px 0 0;
}

.modal-body-custom{flex:1;padding:20px;overflow-y:auto;}

.modal-footer-custom{
    padding:16px 20px;border-top:1px solid #e5e7eb;
    display:flex;justify-content:flex-end;gap:10px;
}

input,select,textarea{border-radius:6px;font-size:14px;}
</style>
