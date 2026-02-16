<template>
<div class="container-fluid py-4">

    <div class="d-flex justify-content-between align-items-center mb-4 animate-fade-in">
        <div>
            <h1 class="h3 fw-bold text-dark mb-1" style="font-size: 1.75rem;">Kuliah Kerja Nyata (KKN)</h1>
            <p class="text-muted mb-0">Daftar Pengajuan KKN</p>
        </div>
        <button class="btn btn-warning text-dark" @click="showModal = true">
            <i class="fa fa-plus me-2"></i>Tambah Pengajuan
        </button>
    </div>

    <div class="card animate-slide-in">
        <div class="card-body p-4">
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
                            <td><strong>{{ index + 1 }}</strong></td>
                            <td><strong>{{ item.nama }}</strong></td>
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
                            <td colspan="8" class="text-center text-muted py-5">
                                <i class="fa fa-inbox fa-3x mb-3 d-block" style="opacity: 0.3;"></i>
                                <p class="mb-0">Belum ada data pengajuan KKN</p>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <div v-if="showModal" class="modal-backdrop-custom" @click.self="closeModal">
        <div class="modal-card">
            <div class="modal-header-custom">
                <h5 class="fw-bold mb-0" style="font-size: 1.125rem;">Tambah Pengajuan KKN</h5>
                <button class="btn-close" @click="closeModal"></button>
            </div>

            <div class="modal-body-custom">
                <div class="mb-3">
                    <label for="nama-mahasiswa" class="form-label fw-semibold d-block">Nama Mahasiswa</label>
                    <input id="nama-mahasiswa" name="nama" class="form-control" v-model="form.nama" disabled>
                </div>
                <div class="mb-3">
                    <label for="nim" class="form-label fw-semibold d-block">NIM</label>
                    <input id="nim" name="nim" class="form-control" v-model="form.nim" disabled>
                </div>
                <div class="mb-3">
                    <label for="alamat-kkn" class="form-label fw-semibold d-block">Alamat KKN <span class="text-danger">*</span></label>
                    <input id="alamat-kkn" name="alamat" class="form-control" placeholder="Masukkan Alamat KKN" v-model="form.alamat">
                </div>
                <div class="mb-3">
                    <label for="penanggung-jawab" class="form-label fw-semibold d-block">Penanggung Jawab KKN <span class="text-danger">*</span></label>
                    <input id="penanggung-jawab" name="penanggung_jawab" class="form-control" placeholder="Masukkan Penanggung Jawab" v-model="form.penanggung_jawab">
                </div>
                <div class="mb-3">
                    <label for="durasi-kkn" class="form-label fw-semibold d-block">Durasi KKN <span class="text-danger">*</span></label>
                    <input id="durasi-kkn" name="durasi" class="form-control" placeholder="Contoh: 2 Bulan" v-model="form.durasi">
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
.form-label { margin-bottom: 8px; color: #374151; }
</style>
