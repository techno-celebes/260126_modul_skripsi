<template>
<div class="container-fluid py-4">

    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h1 class="h3 fw-bold text-dark mb-1">Kuliah Kerja Nyata (KKN)</h1>
            <p class="text-muted mb-0">Daftar Pengajuan KKN</p>
        </div>
        <button class="btn btn-warning text-dark" @click="showModal = true">
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
                            <td><span class="badge" :class="getStatusBadgeClass(item.status)">{{ item.status }}</span></td>
                            <td>
                                <button class="btn btn-sm btn-warning" @click="$inertia.visit(`/kkn/${item.id}`)">
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
                <button class="btn btn-danger text-white" @click="closeModal">Close</button>
                <button class="btn btn-warning text-dark" :disabled="!isFormValid" @click="submitForm">Submit</button>
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
const activeTab = ref('detail')

const form = useForm({
    nama: props.auth.user.name,
    nim: '123456789',
    alamat: '',
    penanggung_jawab: '',
    durasi: ''
})

const isFormValid = computed(() =>
    form.alamat && form.penanggung_jawab && form.durasi
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
