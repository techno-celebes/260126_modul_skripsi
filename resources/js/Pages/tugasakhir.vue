<template>
<div class="container-fluid py-4">

    <div class="d-flex justify-content-between align-items-center mb-4 animate-fade-in">
        <div>
            <h1 class="h3 fw-bold text-dark mb-1" style="font-size: 1.75rem;">Permintaan Akademik</h1>
            <p class="text-muted mb-0">Kelola permintaan akademik Anda</p>
        </div>
        <button class="btn btn-warning text-dark" @click="showModal = true">
            <i class="fa fa-plus me-2"></i>Tambah Permintaan
        </button>
    </div>

    <!-- TABS -->
    <ul class="nav nav-tabs mb-4 animate-slide-in" style="border-bottom: 2px solid #e5e7eb;">
        <li class="nav-item">
            <a class="nav-link" :class="{active: activeTab === 'list'}" @click="activeTab = 'list'" style="cursor:pointer; border-radius: 10px 10px 0 0; font-weight: 600;">
                <i class="fa fa-list me-2"></i>Daftar Permintaan
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link" :class="{active: activeTab === 'pengaturan'}" @click="activeTab = 'pengaturan'" style="cursor:pointer; border-radius: 10px 10px 0 0; font-weight: 600;">
                <i class="fa fa-cog me-2"></i>Pengaturan
            </a>
        </li>
    </ul>

    <!-- TAB CONTENT -->
    <div v-if="activeTab === 'list'" class="animate-fade-in">
        <div class="card animate-slide-in">
            <div class="card-body p-4">
                <div class="table-responsive">
                    <table class="table table-hover">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Nama</th>
                                <th>NIM</th>
                                <th>Jenis</th>
                                <th>Judul</th>
                                <th>Dosen Pembimbing</th>
                                <th>Status</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr v-for="(item, index) in dataPermintaan" :key="item.id">
                                <td><strong>{{ index + 1 }}</strong></td>
                                <td><strong>{{ item.nama }}</strong></td>
                                <td>{{ item.nim }}</td>
                                <td><span class="badge bg-info text-white">{{ item.type }}</span></td>
                                <td>{{ item.judul }}</td>
                                <td>{{ item.dosen_pembimbing || '-' }}</td>
                                <td><span class="badge" :class="getStatusClass(item.status_proposal)">{{ item.status_proposal }}</span></td>
                                <td>
                                    <button class="btn btn-sm btn-warning" @click="$inertia.visit(`/tugasakhir/${item.id}`)">
                                        <i class="fa fa-pencil"></i>
                                    </button>
                                </td>
                            </tr>
                            <tr v-if="dataPermintaan.length === 0">
                                <td colspan="8" class="text-center text-muted py-5">
                                    <i class="fa fa-inbox fa-3x mb-3 d-block" style="opacity: 0.3;"></i>
                                    <p class="mb-0">Belum ada data permintaan akademik</p>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <div v-if="activeTab === 'pengaturan'" class="animate-fade-in">
        <div class="card">
            <div class="card-body p-4">
                <h5 class="fw-bold mb-3" style="font-size: 1.5rem; color: #38a169;">
                    <i class="fa fa-book me-2"></i>PENGATURAN PERMINTAAN AKADEMIK
                </h5>
                <p class="text-muted" style="line-height: 1.8;">Diberitahukan kepada seluruh mahasiswa tingkat akhir bahwa pelaksanaan Permintaan Akademik diatur berdasarkan ketentuan sebagai berikut:</p>
                
                <div class="mt-4 p-4" style="background: linear-gradient(135deg, #f0fdf4 0%, #dcfce7 100%); border-radius: 12px; border-left: 4px solid #38a169;">
                    <h6 class="fw-bold" style="color: #38a169; font-size: 1.1rem;">
                        <i class="fa fa-check-circle me-2"></i>A. Ketentuan Umum
                    </h6>
                    <ol style="line-height: 2;">
                        <li>Permintaan akademik merupakan proses wajib yang harus dilakukan mahasiswa sebagai syarat kelulusan.</li>
                        <li>Mahasiswa yang berhak mengajukan adalah mahasiswa yang telah memenuhi persyaratan akademik sesuai ketentuan program studi.</li>
                        <li>Pelaksanaan dilakukan secara individual, kecuali ditentukan lain oleh program studi.</li>
                    </ol>
                </div>

                <div class="mt-4 p-4" style="background: linear-gradient(135deg, #eff6ff 0%, #dbeafe 100%); border-radius: 12px; border-left: 4px solid #3b82f6;">
                    <h6 class="fw-bold" style="color: #3b82f6; font-size: 1.1rem;">
                        <i class="fa fa-file-text me-2"></i>B. Persyaratan Pengajuan
                    </h6>
                    <ol style="line-height: 2;">
                        <li>Mahasiswa telah lulus mata kuliah prasyarat.</li>
                        <li>Mahasiswa telah memenuhi jumlah Satuan Kredit Semester (SKS) minimum sesuai ketentuan.</li>
                        <li>Mahasiswa telah melakukan registrasi pada semester berjalan.</li>
                        <li>Mahasiswa mengajukan judul sesuai bidang keilmuan program studi.</li>
                    </ol>
                </div>

                <div class="mt-4 p-4" style="background: linear-gradient(135deg, #fef3c7 0%, #fde68a 100%); border-radius: 12px; border-left: 4px solid #f59e0b;">
                    <h6 class="fw-bold" style="color: #d97706; font-size: 1.1rem;">
                        <i class="fa fa-users me-2"></i>C. Pembimbingan
                    </h6>
                    <ol style="line-height: 2;">
                        <li>Setiap mahasiswa akan dibimbing oleh satu atau dua dosen pembimbing yang ditetapkan oleh program studi.</li>
                        <li>Mahasiswa wajib melakukan bimbingan secara berkala dan terdokumentasi.</li>
                        <li>Pergantian dosen pembimbing hanya dapat dilakukan dengan persetujuan program studi.</li>
                        <li>Mahasiswa bertanggung jawab atas keaktifan dalam proses bimbingan.</li>
                    </ol>
                </div>

                <div class="mt-4 p-4" style="background: linear-gradient(135deg, #fce7f3 0%, #fbcfe8 100%); border-radius: 12px; border-left: 4px solid #ec4899;">
                    <h6 class="fw-bold" style="color: #db2777; font-size: 1.1rem;">
                        <i class="fa fa-pencil me-2"></i>D. Pelaksanaan dan Penulisan
                    </h6>
                    <ol style="line-height: 2;">
                        <li>Penulisan wajib mengikuti pedoman yang ditetapkan oleh fakultas/program studi.</li>
                        <li>Isi harus bersifat orisinal dan bebas dari plagiarisme.</li>
                        <li>Mahasiswa wajib melakukan pengecekan plagiarisme sesuai ambang batas yang ditentukan.</li>
                        <li>Segala bentuk pelanggaran akademik akan dikenakan sanksi sesuai peraturan yang berlaku.</li>
                    </ol>
                </div>

                <div class="mt-4 p-4" style="background: linear-gradient(135deg, #f3e8ff 0%, #e9d5ff 100%); border-radius: 12px; border-left: 4px solid #a855f7;">
                    <h6 class="fw-bold" style="color: #9333ea; font-size: 1.1rem;">
                        <i class="fa fa-graduation-cap me-2"></i>E. Ujian
                    </h6>
                    <ol style="line-height: 2;">
                        <li>Mahasiswa yang telah memenuhi persyaratan administrasi dan akademik berhak mengikuti ujian.</li>
                        <li>Ujian dilaksanakan sesuai jadwal yang ditetapkan oleh program studi.</li>
                        <li>Mahasiswa wajib hadir tepat waktu dan mematuhi tata tertib ujian.</li>
                        <li>Hasil ujian ditetapkan oleh tim penguji.</li>
                    </ol>
                </div>

                <div class="alert alert-info mt-4" style="border-radius: 12px; border: none; background: linear-gradient(135deg, #e0f2fe 0%, #bae6fd 100%); border-left: 4px solid #0ea5e9;">
                    <i class="fa fa-info-circle me-2" style="font-size: 1.2rem;"></i>
                    <strong>Catatan:</strong> Mahasiswa diharapkan selalu memantau informasi resmi terkait Permintaan Akademik melalui media yang ditentukan.
                </div>
            </div>
        </div>
    </div>

    <!-- MODAL -->
    <div v-if="showModal" class="modal-backdrop-custom" @click.self="closeModal">
        <div class="modal-card">
            <div class="modal-header-custom">
                <h5 class="fw-bold mb-0" style="font-size: 1.125rem;">Tambah Permintaan Akademik</h5>
                <button class="btn-close" @click="closeModal"></button>
            </div>

            <div class="modal-body-custom">
                <div class="mb-3">
                    <label for="nama-mhs" class="form-label fw-semibold d-block">Nama Mahasiswa</label>
                    <input id="nama-mhs" name="nama" class="form-control" v-model="form.nama" disabled>
                </div>
                <div class="mb-3">
                    <label for="nim-mhs" class="form-label fw-semibold d-block">NIM</label>
                    <input id="nim-mhs" name="nim" class="form-control" v-model="form.nim" disabled>
                </div>
                <div class="mb-3">
                    <label for="jenis-permintaan" class="form-label fw-semibold d-block">Jenis Permintaan <span class="text-danger">*</span></label>
                    <select id="jenis-permintaan" name="type" class="form-control" v-model="form.type">
                        <option value="">-- Pilih --</option>
                        <option>Proposal Skripsi</option>
                        <option>Proposal Artikel</option>
                        <option>Komprehensif</option>
                        <option>Seminar Hasil Skripsi</option>
                        <option>Seminar Hasil Artikel</option>
                        <option>Ujian Skripsi</option>
                    </select>
                </div>
                <div class="mb-3">
                    <label for="periode-akademik" class="form-label fw-semibold d-block">Periode Akademik <span class="text-danger">*</span></label>
                    <select id="periode-akademik" name="periode" class="form-control" v-model="form.periode">
                        <option value="">-- Pilih --</option>
                        <option>Periode Gasal 2025/2026</option>
                        <option>Periode Genap 2025/2026</option>
                    </select>
                </div>
                <div class="mb-3">
                    <label for="prodi" class="form-label fw-semibold d-block">Program Studi</label>
                    <input id="prodi" name="prodi" class="form-control" v-model="form.prodi" disabled>
                </div>
                <div class="mb-3">
                    <label for="judul" class="form-label fw-semibold d-block">Judul <span class="text-danger">*</span></label>
                    <textarea id="judul" name="judul" class="form-control" rows="3" v-model="form.judul" placeholder="Masukkan judul"></textarea>
                </div>
            </div>

            <div class="modal-footer-custom">
                <button class="btn btn-danger text-white" @click="closeModal">Batal</button>
                <button class="btn btn-warning text-dark" :disabled="!isFormValid" @click="submitForm">
                    <i class="fa fa-check me-2"></i>Submit
                </button>
            </div>
        </div>
    </div>

</div>
</template>

<script setup>
import { ref, computed } from 'vue'
import { router, usePage } from '@inertiajs/vue3'
import PanelLayout from '@/Layouts/PanelLayout/FinancePanelLayout.vue'

defineOptions({ layout: PanelLayout })

const props = defineProps({
    dataPermintaan: {
        type: Array,
        default: () => []
    }
})

const page = usePage()
const showModal = ref(false)
const activeTab = ref('list')

const form = ref({
    nama: page.props.auth?.user?.name || 'Admin',
    nim: page.props.auth?.user?.nim || '123456789',
    type: '',
    periode: '',
    prodi: 'Teknik Informatika',
    judul: ''
})

const isFormValid = computed(() =>
    form.value.type && form.value.periode && form.value.judul.trim()
)

function getStatusClass(status) {
    const map = {
        'Menunggu': 'bg-warning text-dark',
        'Disetujui': 'bg-success text-white',
        'Ditolak': 'bg-danger text-white',
        'Selesai': 'bg-primary text-white',
        'Proses': 'bg-info text-white'
    }
    return map[status] || 'bg-secondary text-white'
}

function closeModal(){
    showModal.value = false
    form.value.type = ''
    form.value.periode = ''
    form.value.judul = ''
}

function submitForm(){
    router.post('/tugasakhir', form.value, {
        onSuccess: () => {
            closeModal()
        }
    })
}
</script>

<style scoped>
.card{
    border-radius:12px;
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

.nav-tabs .nav-link{
    color:#6c757d;
    font-weight:500;
}

.nav-tabs .nav-link.active{
    color:#495057;
    font-weight:600;
    border-color:#dee2e6 #dee2e6 #fff;
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
    width:520px;
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
