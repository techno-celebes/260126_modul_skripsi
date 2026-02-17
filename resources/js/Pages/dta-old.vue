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
                    <button class="btn w-100 mb-2 tab-button" :class="activeTab === 'bimbingan' ? 'btn-success' : 'btn-light'" @click="activeTab='bimbingan'">
                        <i class="fa fa-book me-2"></i>Bimbingan
                    </button>
                    <button class="btn w-100 mb-2 tab-button" :class="activeTab === 'syarat' ? 'btn-success' : 'btn-light'" @click="activeTab='syarat'">
                        <i class="fa fa-check-square me-2"></i>Syarat Ujian
                    </button>
                    <button class="btn w-100 mb-2 tab-button" :class="activeTab === 'jadwal' ? 'btn-success' : 'btn-light'" @click="activeTab='jadwal'">
                        <i class="fa fa-calendar me-2"></i>Jadwal Ujian
                    </button>
                    <button class="btn w-100 tab-button" :class="activeTab === 'nilai' ? 'btn-success' : 'btn-light'" @click="activeTab='nilai'">
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
                        <div class="mb-3">
                            <label class="fw-bold text-dark">Nama</label>
                            <p class="text-dark">{{ permintaan?.nama || '-' }}</p>
                        </div>
                        <div class="mb-3">
                            <label class="fw-bold text-dark">NIM</label>
                            <p class="text-dark">{{ permintaan?.nim || '-' }}</p>
                        </div>
                        <div class="mb-3">
                            <label class="fw-bold text-dark">Jenis Permintaan</label>
                            <p class="text-dark">{{ permintaan?.type || '-' }}</p>
                        </div>
                        <div class="mb-3">
                            <label class="fw-bold text-dark">Periode</label>
                            <p class="text-dark">{{ permintaan?.periode || '-' }}</p>
                        </div>
                        <div class="mb-3">
                            <label class="fw-bold text-dark">Program Studi</label>
                            <p class="text-dark">{{ permintaan?.prodi || '-' }}</p>
                        </div>
                        <div class="mb-3">
                            <label class="fw-bold text-dark">Judul</label>
                            <p class="text-dark">{{ permintaan?.judul || '-' }}</p>
                        </div>
                        
                        <!-- Dosen Pembimbing Section -->
                        <div class="mb-3">
                            <label class="fw-bold text-dark">Dosen Pembimbing</label>
                            <div v-if="!editDosen">
                                <div class="d-flex align-items-center gap-2 mb-2">
                                    <span class="badge bg-primary">Pembimbing 1:</span>
                                    <span>{{ permintaan?.dosen_pembimbing || 'Belum ditentukan' }}</span>
                                </div>
                                <div class="d-flex align-items-center gap-2 mb-2">
                                    <span class="badge bg-info">Pembimbing 2:</span>
                                    <span>{{ permintaan?.dosen_pembimbing_2 || 'Belum ditentukan' }}</span>
                                </div>
                                <button class="btn btn-sm btn-warning mt-2" @click="editDosen = true">
                                    <i class="fa fa-edit me-1"></i>Edit Dosen Pembimbing
                                </button>
                            </div>
                            <div v-else class="border p-3 rounded">
                                <div class="mb-2">
                                    <label class="small fw-bold">Dosen Pembimbing 1</label>
                                    <input class="form-control" v-model="dosenForm.dosen_pembimbing" placeholder="Nama Dosen Pembimbing 1">
                                </div>
                                <div class="mb-2">
                                    <label class="small fw-bold">Dosen Pembimbing 2</label>
                                    <input class="form-control" v-model="dosenForm.dosen_pembimbing_2" placeholder="Nama Dosen Pembimbing 2">
                                </div>
                                <div class="d-flex gap-2">
                                    <button class="btn btn-sm btn-success" @click="updateDosen">Simpan</button>
                                    <button class="btn btn-sm btn-secondary" @click="cancelEditDosen">Batal</button>
                                </div>
                            </div>
                        </div>

                        <div class="mb-3">
                            <label class="fw-bold text-dark">Tanggal Pengajuan</label>
                            <p class="text-dark">{{ formatDate(permintaan?.tanggal_pengajuan) }}</p>
                        </div>
                        <div class="mb-3">
                            <label class="fw-bold text-dark">Status</label>
                            <p><span class="badge" :class="getStatusClass(permintaan?.status_proposal)">{{ permintaan?.status_proposal || 'Menunggu' }}</span></p>
                        </div>
                    </div>

                    <!-- PROGRESS -->
                    <div v-if="activeTab==='progress'">
                        <h5 class="fw-bold mb-3">Progress</h5>

                        <!-- Sub Tabs -->
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

                        <!-- Timeline dengan style bulat + garis -->
                        <div v-if="subTab === 'timeline'">
                            <div class="timeline-container">
                                <div v-for="(item, index) in progressList" :key="item.id" class="timeline-item-wrapper">
                                    <div class="timeline-dot" :class="item.is_selesai ? 'completed' : 'pending'">
                                        <i class="fa" :class="item.is_selesai ? 'fa-check' : 'fa-circle'"></i>
                                    </div>
                                    <div v-if="index < progressList.length - 1" class="timeline-line"></div>
                                    <div class="timeline-content-box">
                                        <div class="d-flex justify-content-between align-items-start mb-2">
                                            <div>
                                                <h6 class="mb-1 fw-bold">{{ item.judul }}</h6>
                                                <p class="text-muted small mb-1">{{ item.deskripsi }}</p>
                                            </div>
                                            <span class="badge" :class="item.is_selesai ? 'bg-success' : 'bg-warning text-dark'">
                                                {{ item.is_selesai ? 'Selesai' : 'Proses' }}
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

                    <!-- BIMBINGAN -->
                    <div v-if="activeTab==='bimbingan'">
                        <h5 class="fw-bold mb-3">Bimbingan</h5>
                        
                        <!-- Alert jika proposal belum disetujui -->
                        <div v-if="permintaan?.status_proposal !== 'Disetujui' && permintaan?.status_proposal !== 'Divalidasi'" class="alert alert-warning">
                            <i class="fa fa-exclamation-triangle me-2"></i>
                            Proposal harus disetujui terlebih dahulu sebelum dapat melakukan bimbingan.
                        </div>

                        <div v-else>
                            <!-- Form Upload Bimbingan -->
                            <div class="mb-4 p-3 border rounded bg-light">
                                <h6 class="fw-bold mb-3">Upload Kartu Bimbingan</h6>
                                <div class="mb-3">
                                    <label>Judul Bimbingan</label>
                                    <input class="form-control" placeholder="Contoh: Bimbingan BAB 1" v-model="bimbinganForm.judul">
                                </div>
                                <div class="mb-3">
                                    <label>Catatan</label>
                                    <textarea class="form-control" rows="3" placeholder="Catatan bimbingan" v-model="bimbinganForm.catatan"></textarea>
                                </div>
                                <div class="mb-3">
                                    <label>File Kartu Bimbingan (PDF/DOC/DOCX)</label>
                                    <input type="file" class="form-control" @change="e=>bimbinganForm.file=e.target.files[0]" accept=".pdf,.doc,.docx">
                                </div>
                                <button class="btn btn-success" :disabled="!isBimbinganValid" @click="submitBimbingan">
                                    <i class="fa fa-upload me-1"></i>Upload Bimbingan
                                </button>
                            </div>

                            <!-- Timeline Bimbingan -->
                            <h6 class="fw-bold mb-3">Riwayat Bimbingan</h6>
                            <div class="timeline-container">
                                <div v-for="(item, index) in bimbinganList" :key="item.id" class="timeline-item-wrapper">
                                    <div class="timeline-dot" :class="item.status_validasi === 'Divalidasi' ? 'completed' : 'pending'">
                                        <i class="fa" :class="item.status_validasi === 'Divalidasi' ? 'fa-check' : 'fa-clock-o'"></i>
                                    </div>
                                    <div v-if="index < bimbinganList.length - 1" class="timeline-line"></div>
                                    <div class="timeline-content-box">
                                        <div class="d-flex justify-content-between align-items-start mb-2">
                                            <div>
                                                <h6 class="mb-1 fw-bold">{{ item.judul }}</h6>
                                                <p v-if="item.catatan" class="text-muted small mb-1">{{ item.catatan }}</p>
                                            </div>
                                            <span class="badge" :class="getValidasiClass(item.status_validasi)">
                                                {{ item.status_validasi || 'Menunggu' }}
                                            </span>
                                        </div>
                                        <div class="text-muted small mb-2">
                                            <i class="fa fa-calendar me-1"></i>{{ formatDate(item.tanggal) }}
                                        </div>
                                        <div class="d-flex gap-2 align-items-center">
                                            <a v-if="item.file_path" :href="`/storage/${item.file_path}`" target="_blank" class="btn btn-sm btn-info">
                                                <i class="fa fa-download"></i> Lihat File
                                            </a>
                                            <span v-if="item.divalidasi_oleh" class="badge bg-primary">
                                                <i class="fa fa-user me-1"></i>{{ item.divalidasi_oleh }}
                                            </span>
                                        </div>
                                        <div v-if="item.catatan_dosen" class="mt-2 p-2 bg-warning bg-opacity-10 rounded">
                                            <small class="fw-bold">Catatan Dosen:</small>
                                            <p class="small mb-0">{{ item.catatan_dosen }}</p>
                                        </div>
                                    </div>
                                </div>
                                <div v-if="bimbinganList.length === 0" class="text-center text-muted py-4">
                                    <i class="fa fa-info-circle fa-2x mb-2"></i>
                                    <p>Belum ada riwayat bimbingan</p>
                                </div>
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
                                        <td><span class="badge bg-danger">Belum</span></td>
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
                            <div v-for="jadwal in jadwalUjianList" :key="jadwal.id" class="card mb-3">
                                <div class="card-body">
                                    <div class="d-flex justify-content-between align-items-start mb-3">
                                        <h6 class="fw-bold mb-0">{{ jadwal.jenis_ujian }}</h6>
                                        <span class="badge bg-primary">{{ jadwal.status }}</span>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-6 mb-2">
                                            <small class="text-muted">Tanggal & Waktu</small>
                                            <p class="mb-0 fw-bold">{{ formatDateTime(jadwal.tanggal_ujian) }}</p>
                                        </div>
                                        <div class="col-md-6 mb-2">
                                            <small class="text-muted">Ruangan</small>
                                            <p class="mb-0 fw-bold">{{ jadwal.ruangan || '-' }}</p>
                                        </div>
                                    </div>
                                    <div class="mt-3">
                                        <small class="text-muted d-block mb-1">Tim Penguji:</small>
                                        <div class="d-flex flex-wrap gap-2">
                                            <span v-if="jadwal.penguji_1" class="badge bg-info">{{ jadwal.penguji_1 }}</span>
                                            <span v-if="jadwal.penguji_2" class="badge bg-info">{{ jadwal.penguji_2 }}</span>
                                            <span v-if="jadwal.penguji_3" class="badge bg-info">{{ jadwal.penguji_3 }}</span>
                                        </div>
                                    </div>
                                    <div v-if="jadwal.catatan" class="mt-3 p-2 bg-light rounded">
                                        <small class="fw-bold">Catatan:</small>
                                        <p class="small mb-0">{{ jadwal.catatan }}</p>
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
</div>
</template>

<script setup>
import { ref, computed } from 'vue'
import { router } from '@inertiajs/vue3'
import PanelLayout from '@/Layouts/PanelLayout/FinancePanelLayout.vue'

defineOptions({ layout: PanelLayout })

const props = defineProps({
    permintaan: Object,
    progress: {
        type: Array,
        default: () => []
    },
    bimbingan: {
        type: Array,
        default: () => []
    },
    jadwalUjian: {
        type: Array,
        default: () => []
    }
})

const activeTab = ref('detail')
const subTab = ref('timeline')
const editDosen = ref(false)

const uploadForm = ref({
    judul: '',
    deskripsi: '',
    file: null
})

const bimbinganForm = ref({
    judul: '',
    catatan: '',
    file: null
})

const dosenForm = ref({
    dosen_pembimbing: props.permintaan?.dosen_pembimbing || '',
    dosen_pembimbing_2: props.permintaan?.dosen_pembimbing_2 || ''
})

const progressList = computed(() => {
    return props.progress.filter(p => p.jenis_progress === 'progress' || p.jenis_progress === 'proposal')
})

const asistensiList = computed(() => {
    return props.progress.filter(p => p.jenis_progress === 'asistensi')
})

const bimbinganList = computed(() => {
    return props.bimbingan || []
})

const jadwalUjianList = computed(() => {
    return props.jadwalUjian || []
})

const nilaiList = computed(() => {
    return props.progress.filter(p => p.jenis_progress === 'asistensi' && p.file_path)
})

const rataRataNilai = computed(() => {
    const nilaiArray = nilaiList.value.filter(item => item.nilai).map(item => parseFloat(item.nilai))
    if (nilaiArray.length === 0) return '0.00'
    const sum = nilaiArray.reduce((a, b) => a + b, 0)
    return (sum / nilaiArray.length).toFixed(2)
})

const totalDinilai = computed(() => {
    return nilaiList.value.filter(item => item.nilai).length
})

const isUploadValid = computed(() => {
    return uploadForm.value.judul.trim() !== '' && uploadForm.value.file !== null
})

const isBimbinganValid = computed(() => {
    return bimbinganForm.value.judul.trim() !== ''
})

function formatDate(date) {
    if (!date) return '-'
    return new Date(date).toLocaleDateString('id-ID', {
        year: 'numeric',
        month: 'long',
        day: 'numeric'
    })
}

function formatDateTime(date) {
    if (!date) return '-'
    return new Date(date).toLocaleString('id-ID', {
        year: 'numeric',
        month: 'long',
        day: 'numeric',
        hour: '2-digit',
        minute: '2-digit'
    })
}

function getStatusClass(status) {
    const map = {
        'Menunggu': 'bg-warning text-dark',
        'Disetujui': 'bg-success text-white',
        'Divalidasi': 'bg-success text-white',
        'Ditolak': 'bg-danger text-white',
        'Selesai': 'bg-primary text-white',
        'Proses': 'bg-info text-white'
    }
    return map[status] || 'bg-secondary text-white'
}

function getValidasiClass(status) {
    const map = {
        'Menunggu': 'bg-warning text-dark',
        'Divalidasi': 'bg-success text-white',
        'Ditolak': 'bg-danger text-white'
    }
    return map[status] || 'bg-secondary text-white'
}

function submitUpload() {
    const formData = new FormData()
    formData.append('jenis_progress', 'asistensi')
    formData.append('judul', uploadForm.value.judul)
    formData.append('deskripsi', uploadForm.value.deskripsi)
    formData.append('file', uploadForm.value.file)

    router.post(`/tugasakhir/${props.permintaan.id}/progress`, formData, {
        onSuccess: () => {
            uploadForm.value = { judul: '', deskripsi: '', file: null }
        }
    })
}

function submitBimbingan() {
    const formData = new FormData()
    formData.append('judul', bimbinganForm.value.judul)
    formData.append('catatan', bimbinganForm.value.catatan)
    if (bimbinganForm.value.file) {
        formData.append('file', bimbinganForm.value.file)
    }

    router.post(`/tugasakhir/${props.permintaan.id}/bimbingan`, formData, {
        onSuccess: () => {
            bimbinganForm.value = { judul: '', catatan: '', file: null }
        },
        onError: (errors) => {
            alert(errors.error || 'Terjadi kesalahan')
        }
    })
}

function updateDosen() {
    router.post(`/tugasakhir/${props.permintaan.id}/dosen`, dosenForm.value, {
        onSuccess: () => {
            editDosen.value = false
        }
    })
}

function cancelEditDosen() {
    editDosen.value = false
    dosenForm.value = {
        dosen_pembimbing: props.permintaan?.dosen_pembimbing || '',
        dosen_pembimbing_2: props.permintaan?.dosen_pembimbing_2 || ''
    }
}
</script>

<style scoped>
.card{
    border-radius:12px;
}

.tab-button{
    text-align:left;
    font-weight:600;
    transition:all 0.3s ease;
}

.tab-button:hover{
    transform:translateX(5px);
}

.table th{
    background-color:#f8f9fa;
    font-weight:600;
    text-align: center;
    vertical-align: middle;
    padding: 16px 12px;
}

.table td {
    text-align: center;
    vertical-align: middle;
    padding: 14px 12px;
}

/* Timeline Style - Bulat + Garis */
.timeline-container {
    position: relative;
    padding-left: 50px;
}

.timeline-item-wrapper {
    position: relative;
    margin-bottom: 30px;
}

.timeline-dot {
    position: absolute;
    left: -50px;
    top: 0;
    width: 40px;
    height: 40px;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 18px;
    z-index: 2;
    box-shadow: 0 2px 8px rgba(0,0,0,0.1);
}

.timeline-dot.completed {
    background: linear-gradient(135deg, #28a745 0%, #20c997 100%);
    color: white;
}

.timeline-dot.pending {
    background: linear-gradient(135deg, #ffc107 0%, #ff9800 100%);
    color: white;
}

.timeline-line {
    position: absolute;
    left: -30px;
    top: 40px;
    width: 3px;
    height: calc(100% + 30px);
    background: linear-gradient(180deg, #e9ecef 0%, #dee2e6 100%);
    z-index: 1;
}

.timeline-content-box {
    background: #f8f9fa;
    padding: 15px 20px;
    border-radius: 12px;
    border-left: 4px solid #0d6efd;
    box-shadow: 0 2px 4px rgba(0,0,0,0.05);
    transition: all 0.3s ease;
}

.timeline-content-box:hover {
    box-shadow: 0 4px 12px rgba(0,0,0,0.1);
    transform: translateX(5px);
}

.badge-status {
    flex-shrink: 0;
    align-self: flex-start;
    line-height: 1.5;
    padding: 0.35em 0.65em;
}

input, select, textarea{
    border-radius:6px;
    font-size:14px;
}
</style>
