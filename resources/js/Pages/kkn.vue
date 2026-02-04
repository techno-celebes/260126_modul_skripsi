<template>
<div class="container-fluid py-4">

    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h1 class="h3 fw-bold text-dark mb-1">Kuliah Kerja Nyata (KKN)</h1>
            <p class="text-muted mb-0">Daftar Pengajuan KKN</p>
        </div>
        <button class="btn btn-warning text-white" @click="showModal = true">
            Tambah Pengajuan
        </button>
    </div>

    <div class="card">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-hover">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Nama</th>
                            <th>NIM</th>
                            <th>Alamat KKN</th>
                            <th>Penanggung Jawab</th>
                            <th>Durasi</th>
                            <th>Status</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr v-for="(item, index) in daftarKKN" :key="item.id">
                            <td>{{ index + 1 }}</td>
                            <td>{{ item.nama }}</td>
                            <td>{{ item.nim }}</td>
                            <td>{{ item.alamat }}</td>
                            <td>{{ item.penanggung_jawab }}</td>
                            <td>{{ item.durasi }}</td>
                            <td><span class="badge bg-warning">{{ item.status }}</span></td>
                            <td>
                                <button class="btn btn-sm btn-warning text-white" @click="openDetailModal(item)">
                                    <i class="fa fa-pencil"></i>
                                </button>
                            </td>
                        </tr>
                        <tr v-if="daftarKKN.length === 0">
                            <td colspan="8" class="text-center text-muted">Belum ada data pengajuan KKN</td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <div v-if="showModal" class="modal-backdrop-custom">
        <div class="modal-card">
            <div class="modal-header-custom">
                <h5 class="fw-bold mb-0">Tambah Pengajuan KKN</h5>
                <button class="btn-close" @click="closeModal"></button>
            </div>

            <div class="modal-body-custom">
                <div class="mb-3">
                    <label>Nama Mahasiswa</label>
                    <input class="form-control" v-model="form.nama" disabled>
                </div>
                <div class="mb-3">
                    <label>NIM</label>
                    <input class="form-control" v-model="form.nim" disabled>
                </div>
                <div class="mb-3">
                    <label>Alamat KKN</label>
                    <input class="form-control" placeholder="Masukkan Alamat KKN" v-model="form.alamat">
                </div>
                <div class="mb-3">
                    <label>Penanggung Jawab KKN</label>
                    <input class="form-control" placeholder="Masukkan Penanggung Jawab" v-model="form.penanggung_jawab">
                </div>
                <div class="mb-3">
                    <label>Durasi KKN</label>
                    <input class="form-control" placeholder="Contoh: 2 Bulan" v-model="form.durasi">
                </div>
            </div>

            <div class="modal-footer-custom">
                <button class="btn btn-danger" @click="closeModal">Close</button>
                <button class="btn btn-warning text-white" :disabled="!isFormValid" @click="submitForm">Submit</button>
            </div>
        </div>
    </div>

    <div v-if="showDetailModal" class="modal-backdrop-custom">
        <div class="modal-card-large">
            <div class="modal-header-custom">
                <h5 class="fw-bold mb-0">Detail KKN</h5>
                <button class="btn-close" @click="showDetailModal = false"></button>
            </div>

            <div class="modal-body-custom">
                <div class="d-flex gap-2 mb-4">
                    <button 
                        class="btn flex-fill" 
                        :class="activeTab === 'detail' ? 'btn-warning text-white' : 'btn-outline-warning text-dark'"
                        @click="activeTab = 'detail'">
                        Detail KKN
                    </button>
                    <button 
                        class="btn flex-fill" 
                        :class="activeTab === 'aktivitas' ? 'btn-warning text-white' : 'btn-outline-warning text-dark'"
                        @click="activeTab = 'aktivitas'">
                        Upload Aktivitas
                    </button>
                    <button 
                        class="btn flex-fill" 
                        :class="activeTab === 'penilaian' ? 'btn-warning text-white' : 'btn-outline-warning text-dark'"
                        @click="activeTab = 'penilaian'">
                        Penilaian
                    </button>
                </div>

                <div v-if="activeTab === 'detail'">
                    <div class="mb-3">
                        <label class="fw-bold text-dark">Nama</label>
                        <p class="text-dark">{{ selectedKKN?.nama }}</p>
                    </div>
                    <div class="mb-3">
                        <label class="fw-bold text-dark">NIM</label>
                        <p class="text-dark">{{ selectedKKN?.nim }}</p>
                    </div>
                    <div class="mb-3">
                        <label class="fw-bold text-dark">Alamat KKN</label>
                        <p class="text-dark">{{ selectedKKN?.alamat }}</p>
                    </div>
                    <div class="mb-3">
                        <label class="fw-bold text-dark">Penanggung Jawab</label>
                        <p class="text-dark">{{ selectedKKN?.penanggung_jawab }}</p>
                    </div>
                    <div class="mb-3">
                        <label class="fw-bold text-dark">Durasi</label>
                        <p class="text-dark">{{ selectedKKN?.durasi }}</p>
                    </div>
                    <div class="mb-3">
                        <label class="fw-bold text-dark">Status</label>
                        <p><span class="badge bg-warning">{{ selectedKKN?.status }}</span></p>
                    </div>
                </div>

                <div v-if="activeTab === 'aktivitas'">
                    <div class="mb-3">
                        <label>Judul Aktivitas</label>
                        <input class="form-control" placeholder="Masukkan Judul" v-model="aktivitasForm.judul">
                    </div>
                    <div class="mb-3">
                        <label>Deskripsi</label>
                        <textarea class="form-control" rows="4" placeholder="Masukkan Deskripsi" v-model="aktivitasForm.deskripsi"></textarea>
                    </div>
                    <div class="mb-3">
                        <label>Tanggal</label>
                        <input type="date" class="form-control" v-model="aktivitasForm.tanggal">
                    </div>
                    <div class="mb-3">
                        <label>Dokumentasi (Maks 2MB dengan format JPG/PNG)</label>
                        <input type="file" class="form-control" @change="e=>aktivitasForm.file=e.target.files[0]" accept="image/*">
                    </div>
                    <button class="btn btn-warning text-white" :disabled="!isAktivitasValid" @click="uploadAktivitas">Upload Aktivitas</button>
                </div>

                <div v-if="activeTab === 'penilaian'">
                    <div class="alert alert-info">
                        Penilaian akan ditampilkan setelah dosen pembimbing memberikan nilai.
                    </div>
                    <div class="mb-3">
                        <label class="fw-bold">Nilai Akhir</label>
                        <p class="fs-4">-</p>
                    </div>
                    <div class="mb-3">
                        <label class="fw-bold">Catatan Pembimbing</label>
                        <p>Belum ada catatan</p>
                    </div>
                </div>
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
    auth: Object,
    daftarKKN: Array
})

const showModal = ref(false)
const showDetailModal = ref(false)
const activeTab = ref('detail')
const selectedKKN = ref(null)

const form = useForm({
    nama: props.auth.user.name,
    nim: '123456789',
    alamat: '',
    penanggung_jawab: '',
    durasi: ''
})

const aktivitasForm = ref({
    judul: '',
    deskripsi: '',
    tanggal: '',
    file: null
})

const isFormValid = computed(() =>
    form.alamat && form.penanggung_jawab && form.durasi
)

const isAktivitasValid = computed(() =>
    aktivitasForm.value.judul &&
    aktivitasForm.value.deskripsi &&
    aktivitasForm.value.tanggal &&
    aktivitasForm.value.file
)

function closeModal(){
    showModal.value = false
}

function submitForm(){
    form.post('/kkn', {
        onSuccess: () => {
            form.reset('alamat', 'penanggung_jawab', 'durasi')
            showModal.value = false
        }
    })
}

function openDetailModal(item){
    selectedKKN.value = item
    activeTab.value = 'detail'
    showDetailModal.value = true
}

function uploadAktivitas(){
    alert('Aktivitas berhasil diupload!')
    aktivitasForm.value = {
        judul: '',
        deskripsi: '',
        tanggal: '',
        file: null
    }
}
</script>

<style scoped>
.card{
    border-radius:12px;
}

.table th{
    background-color:#f8f9fa;
    font-weight:600;
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

.modal-card-large{
    width:900px;
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

input, select, textarea{
    border-radius:6px;
    font-size:14px;
}
</style>
