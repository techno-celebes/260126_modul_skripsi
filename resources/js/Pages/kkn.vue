<template>
    <div class="container-fluid py-4">
        <!-- Header -->
        <div class="d-flex justify-content-between align-items-center mb-4">
            <div>
                <h1 class="h3 fw-bold text-dark mb-1">Kuliah Kerja Nyata (KKN)</h1>
                <p class="text-muted mb-0">Daftar Pengajuan KKN</p>
            </div>
            <button class="btn btn-primary" @click="showModal = true">
                <i class="fa fa-plus me-2"></i>Tambah Pengajuan KKN
            </button>
        </div>

        <!-- Tabel Daftar KKN -->
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
                            </tr>
                        </thead>
                        <tbody>
                            <tr v-for="(item, index) in daftarKKN" :key="index">
                                <td>{{ index + 1 }}</td>
                                <td>{{ item.nama }}</td>
                                <td>{{ item.nim }}</td>
                                <td>{{ item.alamat }}</td>
                                <td>{{ item.penanggungJawab }}</td>
                                <td>{{ item.durasi }}</td>
                                <td><span class="badge bg-warning">{{ item.status }}</span></td>
                            </tr>
                            <tr v-if="daftarKKN.length === 0">
                                <td colspan="7" class="text-center text-muted">Belum ada data pengajuan KKN</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <!-- Modal Tambah Pengajuan -->
        <Modal :show="showModal" @close="showModal = false">
            <div class="p-4">
                <h5 class="fw-bold mb-4">Tambah Pengajuan KKN</h5>
                <form @submit.prevent="submitForm">
                    <div class="mb-3">
                        <label class="form-label">Nama</label>
                        <input type="text" class="form-control" v-model="form.nama" disabled>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">NIM</label>
                        <input type="text" class="form-control" v-model="form.nim" disabled>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Alamat KKN</label>
                        <input type="text" class="form-control" v-model="form.alamat" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Penanggung Jawab KKN</label>
                        <input type="text" class="form-control" v-model="form.penanggungJawab" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Durasi KKN</label>
                        <input type="text" class="form-control" v-model="form.durasi" placeholder="Contoh: 2 Bulan" required>
                    </div>
                    <div class="d-flex justify-content-end gap-2">
                        <button type="button" class="btn btn-secondary" @click="showModal = false">Batalkan</button>
                        <button type="submit" class="btn btn-primary">Tambah</button>
                    </div>
                </form>
            </div>
        </Modal>
    </div>
</template>

<script setup>
import PanelLayout from '@/Layouts/PanelLayout/FinancePanelLayout.vue'
import Modal from '@/Components/Modal.vue'
import { ref } from 'vue'

defineOptions({ layout: PanelLayout })

const props = defineProps({
    auth: Object
});

const showModal = ref(false)
const daftarKKN = ref([])

const form = ref({
    nama: props.auth.user.name,
    nim: '123456789',
    alamat: '',
    penanggungJawab: '',
    durasi: ''
})

const submitForm = () => {
    daftarKKN.value.push({
        nama: form.value.nama,
        nim: form.value.nim,
        alamat: form.value.alamat,
        penanggungJawab: form.value.penanggungJawab,
        durasi: form.value.durasi,
        status: 'Pending'
    })
    
    form.value.alamat = ''
    form.value.penanggungJawab = ''
    form.value.durasi = ''
    showModal.value = false
}
</script>

<style scoped>
.card {
    border-radius: 12px;
}

.table th {
    background-color: #f8f9fa;
    font-weight: 600;
}
</style>
