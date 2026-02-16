<template>
<div class="container-fluid py-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h1 class="h3 fw-bold text-dark mb-1">Detail KKN</h1>
            <p class="text-muted mb-0">{{ kknData.nama }}</p>
        </div>
        <button class="btn btn-secondary" @click="$inertia.visit('/kkn')">
            Kembali
        </button>
    </div>

    <div class="row g-3">
        <div class="col-md-3">
            <div class="card">
                <div class="card-body p-2">
                    <button
                        class="btn w-100 mb-2 tab-button"
                        :class="activeTab === 'detail' ? 'btn-success' : 'btn-light'"
                        @click="activeTab = 'detail'">
                        <i class="fa fa-info-circle me-2"></i>Detail KKN
                    </button>
                    <button
                        class="btn w-100 mb-2 tab-button"
                        :class="activeTab === 'aktivitas' ? 'btn-success' : 'btn-light'"
                        @click="activeTab = 'aktivitas'">
                        <i class="fa fa-upload me-2"></i>Upload Aktivitas
                    </button>
                    <button
                        class="btn w-100 tab-button"
                        :class="activeTab === 'penilaian' ? 'btn-success' : 'btn-light'"
                        @click="activeTab = 'penilaian'">
                        <i class="fa fa-star me-2"></i>Penilaian
                    </button>
                </div>
            </div>
        </div>

        <div class="col-md-9">
            <div class="card">
                <div class="card-body">
                    <div v-if="activeTab === 'detail'">
                        <h5 class="fw-bold mb-3">Detail KKN</h5>
                        <div class="mb-3">
                            <label class="fw-bold text-dark">Nama</label>
                            <p class="text-dark">{{ kknData.nama }}</p>
                        </div>
                        <div class="mb-3">
                            <label class="fw-bold text-dark">NIM</label>
                            <p class="text-dark">{{ kknData.nim }}</p>
                        </div>
                        <div class="mb-3">
                            <label class="fw-bold text-dark">Alamat KKN</label>
                            <p class="text-dark">{{ kknData.alamat }}</p>
                        </div>
                        <div class="mb-3">
                            <label class="fw-bold text-dark">Penanggung Jawab</label>
                            <p class="text-dark">{{ kknData.penanggung_jawab }}</p>
                        </div>
                        <div class="mb-3">
                            <label class="fw-bold text-dark">Durasi</label>
                            <p class="text-dark">{{ kknData.durasi }}</p>
                        </div>
                        <div class="mb-3">
                            <label class="fw-bold text-dark">Status</label>
                            <p><span class="badge" :class="getStatusBadgeClass(kknData.status)">{{ kknData.status }}</span></p>
                        </div>
                    </div>

                    <div v-if="activeTab === 'aktivitas'">
                        <h5 class="fw-bold mb-3">Upload Aktivitas</h5>

                        <!-- Sub Tabs -->
                        <ul class="nav nav-tabs mb-3">
                            <li class="nav-item">
                                <a class="nav-link" :class="{ active: subTab === 'harian' }" @click="subTab = 'harian'" style="cursor: pointer;">
                                    Upload Harian
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" :class="{ active: subTab === 'dokumen' }" @click="subTab = 'dokumen'" style="cursor: pointer;">
                                    Dokumen KKN
                                </a>
                            </li>
                        </ul>

                        <!-- Form Upload -->
                        <div class="mb-4 p-3 border rounded">
                            <div class="mb-3">
                                <label>Judul {{ subTab === 'harian' ? 'Aktivitas' : 'Dokumen' }}</label>
                                <input class="form-control" placeholder="Masukkan Judul" v-model="aktivitasForm.judul">
                            </div>
                            <div class="mb-3">
                                <label>Deskripsi</label>
                                <textarea class="form-control" rows="3" placeholder="Masukkan Deskripsi" v-model="aktivitasForm.deskripsi"></textarea>
                            </div>
                            <div class="mb-3" v-if="subTab === 'harian'">
                                <label>Tanggal</label>
                                <input type="date" class="form-control" v-model="aktivitasForm.tanggal">
                            </div>
                            <div class="mb-3">
                                <label>File (Maks 2MB - JPG/PNG/PDF)</label>
                                <input type="file" class="form-control" @change="e=>aktivitasForm.file=e.target.files[0]" accept="image/*,application/pdf">
                            </div>
                            <button class="btn btn-success" :disabled="!isAktivitasValid" @click="uploadAktivitas">
                                Upload {{ subTab === 'harian' ? 'Aktivitas' : 'Dokumen' }}
                            </button>
                        </div>

                        <!-- Tabel Data -->
                        <h6 class="fw-bold mb-2">Data {{ subTab === 'harian' ? 'Aktivitas Harian' : 'Dokumen KKN' }}</h6>
                        <div class="table-responsive">
                            <table class="table table-hover align-middle">
                                <thead class="table-light">
                                    <tr>
                                        <th>No</th>
                                        <th>Judul</th>
                                        <th>Deskripsi</th>
                                        <th v-if="subTab === 'harian'">Tanggal</th>
                                        <th>File</th>
                                        <th>Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr v-for="(item, index) in filteredAktivitas" :key="item.id">
                                        <td>{{ index + 1 }}</td>
                                        <td>{{ item.judul }}</td>
                                        <td>{{ item.deskripsi || '-' }}</td>
                                        <td v-if="subTab === 'harian'">{{ item.tanggal || '-' }}</td>
                                        <td>
                                            <a v-if="item.file_path" :href="`/storage/${item.file_path}`" target="_blank" class="btn btn-sm btn-info text-white">
                                                Lihat
                                            </a>
                                            <span v-else>-</span>
                                        </td>
                                        <td>
                                            <button class="btn btn-sm btn-warning text-white" @click="openDetail(item)">
                                                Detail
                                            </button>
                                        </td>
                                    </tr>
                                    <tr v-if="filteredAktivitas.length === 0">
                                        <td :colspan="subTab === 'harian' ? 6 : 5" class="text-center text-muted">
                                            Belum ada data
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>

                    <div v-if="activeTab === 'penilaian'">
                        <h5 class="fw-bold mb-3">Penilaian KKN</h5>
                        
                        <div class="table-responsive">
                            <table class="table table-hover align-middle">
                                <thead class="table-light">
                                    <tr>
                                        <th>No</th>
                                        <th>Tipe</th>
                                        <th>Judul</th>
                                        <th>Tanggal</th>
                                        <th>Nilai</th>
                                        <th>Status</th>
                                        <th>Catatan</th>
                                        <th>Divalidasi Oleh</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr v-for="(item, index) in aktivitasList.filter(a => a.nilai)" :key="item.id">
                                        <td>{{ index + 1 }}</td>
                                        <td>{{ ucfirst(item.tipe) }}</td>
                                        <td>{{ item.judul }}</td>
                                        <td>{{ item.tanggal || '-' }}</td>
                                        <td>
                                            <span v-if="item.nilai" class="badge bg-primary fs-6">{{ item.nilai }}</span>
                                            <span v-else class="text-muted">-</span>
                                        </td>
                                        <td>
                                            <span class="badge" :class="getStatusClass(item.status_validasi)">
                                                {{ item.status_validasi || 'Menunggu' }}
                                            </span>
                                        </td>
                                        <td>{{ item.catatan_nilai || '-' }}</td>
                                        <td>{{ item.divalidasi_oleh || '-' }}</td>
                                    </tr>
                                    <tr v-if="aktivitasList.filter(a => a.nilai).length === 0">
                                        <td colspan="8" class="text-center text-muted">
                                            Belum ada penilaian
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>

                        <!-- Statistik Nilai -->
                        <div class="row g-3 mt-3">
                            <div class="col-md-4">
                                <div class="card bg-light">
                                    <div class="card-body text-center">
                                        <h6 class="text-muted">Rata-rata Nilai</h6>
                                        <h2 class="fw-bold text-primary">{{ rataRataNilai }}</h2>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="card bg-light">
                                    <div class="card-body text-center">
                                        <h6 class="text-muted">Total Dinilai</h6>
                                        <h2 class="fw-bold text-success">{{ totalDinilai }}</h2>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="card bg-light">
                                    <div class="card-body text-center">
                                        <h6 class="text-muted">Menunggu Penilaian</h6>
                                        <h2 class="fw-bold text-warning">{{ totalMenunggu }}</h2>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal Detail -->
    <div v-if="showDetail" class="modal-backdrop-custom">
        <div class="modal-card">
            <div class="modal-header-custom">
                <h5 class="fw-bold mb-0">Detail {{ detailData.tipe === 'harian' ? 'Aktivitas' : 'Dokumen' }}</h5>
                <button class="btn-close" @click="showDetail=false"></button>
            </div>
            <div class="modal-body-custom">
                <p><b>Judul:</b> {{ detailData.judul }}</p>
                <p><b>Deskripsi:</b> {{ detailData.deskripsi || '-' }}</p>
                <p v-if="detailData.tipe === 'harian'"><b>Tanggal:</b> {{ detailData.tanggal || '-' }}</p>
                <p><b>File:</b>
                    <a v-if="detailData.file_path" :href="`/storage/${detailData.file_path}`" target="_blank">Lihat File</a>
                    <span v-else>-</span>
                </p>
            </div>
            <div class="modal-footer-custom">
                <button class="btn btn-danger" @click="showDetail=false">Close</button>
            </div>
        </div>
    </div>
</div>
</template>

<script setup>
import { ref, computed } from 'vue'
import { useForm } from '@inertiajs/vue3'
import PanelLayout from '@/Layouts/PanelLayout/FinancePanelLayout.vue'

defineOptions({ layout: PanelLayout })

const props = defineProps({
    kknData: Object,
    aktivitasList: Array
})

const activeTab = ref('detail')
const subTab = ref('harian')
const showDetail = ref(false)
const detailData = ref({})

const aktivitasForm = ref({
    judul: '',
    deskripsi: '',
    tanggal: '',
    file: null
})

const isAktivitasValid = computed(() => {
    if (subTab.value === 'harian') {
        return aktivitasForm.value.judul && aktivitasForm.value.tanggal
    }
    return aktivitasForm.value.judul
})

const filteredAktivitas = computed(() => {
    return props.aktivitasList.filter(item => item.tipe === subTab.value)
})

const rataRataNilai = computed(() => {
    const nilaiArray = props.aktivitasList.filter(item => item.nilai).map(item => parseFloat(item.nilai))
    if (nilaiArray.length === 0) return '0.00'
    const sum = nilaiArray.reduce((a, b) => a + b, 0)
    return (sum / nilaiArray.length).toFixed(2)
})

const totalDinilai = computed(() => {
    return props.aktivitasList.filter(item => item.nilai).length
})

const totalMenunggu = computed(() => {
    return props.aktivitasList.filter(item => item.file_path && !item.nilai && item.status_validasi !== 'Ditolak').length
})

function ucfirst(str) {
    if (!str) return ''
    return str.charAt(0).toUpperCase() + str.slice(1)
}

function getStatusClass(status) {
    const map = {
        'Menunggu': 'bg-warning text-dark',
        'Divalidasi': 'bg-success text-white',
        'Ditolak': 'bg-danger text-white'
    }
    return map[status] || 'bg-secondary'
}

function getStatusBadgeClass(status) {
    const map = {
        'Pending': 'bg-warning text-dark',
        'Menunggu': 'bg-warning text-dark',
        'Disetujui': 'bg-success text-white',
        'Divalidasi': 'bg-success text-white',
        'Ditolak': 'bg-danger text-white',
        'Selesai': 'bg-primary text-white',
        'Proses': 'bg-info text-white'
    }
    return map[status] || 'bg-secondary text-white'
}

function uploadAktivitas() {
    const form = useForm({
        tipe: subTab.value,
        judul: aktivitasForm.value.judul,
        deskripsi: aktivitasForm.value.deskripsi,
        tanggal: aktivitasForm.value.tanggal,
        file: aktivitasForm.value.file
    })

    form.post(`/kkn/${props.kknData.id}/aktivitas`, {
        onSuccess: () => {
            aktivitasForm.value = {
                judul: '',
                deskripsi: '',
                tanggal: '',
                file: null
            }
        }
    })
}

function openDetail(item) {
    detailData.value = item
    showDetail.value = true
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

input, select, textarea{
    border-radius:6px;
    font-size:14px;
}

.modal-backdrop-custom{
    position:fixed;
    inset:0;
    background:rgba(0,0,0,.45);
    display:flex;
    justify-content:center;
    align-items:center;
    z-index:9999;
}

.modal-card{
    width:600px;
    max-height:90vh;
    background:white;
    border-radius:12px;
    display:flex;
    flex-direction:column;
}

.modal-header-custom{
    padding:16px 20px;
    border-bottom:1px solid #e5e7eb;
    display:flex;
    justify-content:space-between;
    align-items:center;
}

.modal-body-custom{
    flex:1;
    padding:18px 20px;
    overflow-y:auto;
}

.modal-footer-custom{
    padding:16px 20px;
    border-top:1px solid #e5e7eb;
    display:flex;
    justify-content:flex-end;
    gap:10px;
}
</style>
