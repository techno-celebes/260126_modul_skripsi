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
                    <button class="btn w-100 mb-2 tab-button" :class="activeTab === 'detail' ? 'btn-success' : 'btn-light'" @click="activeTab = 'detail'">
                        <i class="fa fa-info-circle me-2"></i>Detail Permintaan
                    </button>
                    <button class="btn w-100 mb-2 tab-button" :class="activeTab === 'progress' ? 'btn-success' : 'btn-light'" @click="activeTab = 'progress'">
                        <i class="fa fa-tasks me-2"></i>Progress
                    </button>
                    <button class="btn w-100 mb-2 tab-button" :class="activeTab === 'bimbingan' ? 'btn-success' : 'btn-light'" @click="activeTab = 'bimbingan'">
                        <i class="fa fa-book me-2"></i>Bimbingan
                    </button>
                    <button class="btn w-100 mb-2 tab-button" :class="activeTab === 'syarat' ? 'btn-success' : 'btn-light'" @click="activeTab = 'syarat'">
                        <i class="fa fa-check-square me-2"></i>Syarat Ujian
                    </button>
                    <button class="btn w-100 mb-2 tab-button" :class="activeTab === 'jadwal' ? 'btn-success' : 'btn-light'" @click="activeTab = 'jadwal'">
                        <i class="fa fa-calendar me-2"></i>Jadwal Ujian
                    </button>
                    <button class="btn w-100 tab-button" :class="activeTab === 'nilai' ? 'btn-success' : 'btn-light'" @click="activeTab = 'nilai'">
                        <i class="fa fa-star me-2"></i>Nilai Ujian
                    </button>
                </div>
            </div>
        </div>

        <div class="col-md-9">
            <div class="card">
                <div class="card-body">
                    
                    <!-- DETAIL -->
                    <div v-if="activeTab === 'detail'">
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
                        <div class="mb-3">
                            <label class="fw-bold text-dark">Dosen Pembimbing</label>
                            <p class="text-dark">{{ permintaan?.dosen_pembimbing || 'Belum ditentukan' }}</p>
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
                    <div v-if="activeTab === 'progress'">
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

                        <!-- Timeline -->
                        <div v-if="subTab === 'timeline'">
                            <div class="timeline">
                                <div v-for="item in progressList" :key="item.id" class="timeline-item" :class="{'completed': item.is_selesai}">
                                    <div class="timeline-content">
                                        <div class="d-flex justify-content-between align-items-start mb-2">
                                            <div>
                                                <h6 class="mb-1 fw-bold">
                                                    <i class="fa me-2" :class="item.is_selesai ? 'fa-check-circle text-success' : 'fa-circle-o text-warning'"></i>
                                                    {{ item.judul }}
                                                </h6>
                                                <p class="text-muted small mb-1">{{ item.deskripsi }}</p>
                                            </div>
                                            <span class="badge badge-status" :class="item.is_selesai ? 'bg-success text-white' : 'bg-warning text-dark'">
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
                            <!-- Form Upload -->
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

                            <!-- Tabel Data -->
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
                    <div v-if="activeTab === 'bimbingan'">
                        <h5 class="fw-bold mb-3">Bimbingan</h5>
                        <div class="alert alert-info">
                            Fitur bimbingan akan segera tersedia.
                        </div>
                    </div>

                    <!-- SYARAT -->
                    <div v-if="activeTab === 'syarat'">
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
                                        <td><span class="badge bg-danger">Belum</span></td>
                                    </tr>
                                    <tr>
                                        <td>2</td>
                                        <td>Transkrip Nilai</td>
                                        <td>Ya</td>
                                        <td><span class="badge bg-danger">Belum</span></td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>

                    <!-- JADWAL -->
                    <div v-if="activeTab === 'jadwal'">
                        <h5 class="fw-bold mb-3">Jadwal Ujian</h5>
                        <div class="alert alert-info">
                            Jadwal ujian belum tersedia.
                        </div>
                    </div>

                    <!-- NILAI -->
                    <div v-if="activeTab === 'nilai'">
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
    }
})

const activeTab = ref('detail')
const subTab = ref('timeline')

const uploadForm = ref({
    judul: '',
    deskripsi: '',
    file: null
})

const progressList = computed(() => {
    return props.progress.filter(p => p.jenis_progress === 'progress' || p.jenis_progress === 'proposal')
})

const asistensiList = computed(() => {
    return props.progress.filter(p => p.jenis_progress === 'asistensi')
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

function formatDate(date) {
    if (!date) return '-'
    return new Date(date).toLocaleDateString('id-ID', {
        year: 'numeric',
        month: 'long',
        day: 'numeric'
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

.timeline {
    position: relative;
}

.timeline-item {
    position: relative;
    padding-bottom: 20px;
}

.timeline-content {
    background: transparent;
    padding: 12px 15px;
    border-radius: 8px;
    border-left: 3px solid #ffc107;
}

.timeline-item.completed .timeline-content {
    border-left-color: #28a745;
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
