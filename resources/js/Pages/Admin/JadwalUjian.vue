<template>
<div class="container-fluid py-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h1 class="h3 fw-bold text-dark mb-1">Jadwal Ujian</h1>
            <p class="text-muted mb-0">Kelola jadwal ujian mahasiswa</p>
        </div>
        <button class="btn btn-success" @click="showModal = true">
            <i class="fa fa-plus me-2"></i>Tambah Jadwal
        </button>
    </div>

    <div class="card">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-hover">
                    <thead class="table-light">
                        <tr>
                            <th>No</th>
                            <th>Mahasiswa</th>
                            <th>Jenis Ujian</th>
                            <th>Tanggal & Waktu</th>
                            <th>Ruangan</th>
                            <th>Tim Penguji</th>
                            <th>Status</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr v-for="(item, index) in jadwal" :key="item.id">
                            <td>{{ index + 1 }}</td>
                            <td>{{ item.permintaan?.nama }}</td>
                            <td>{{ item.jenis_ujian }}</td>
                            <td>{{ formatDateTime(item.tanggal_ujian) }}</td>
                            <td>{{ item.ruangan || '-' }}</td>
                            <td>
                                <div class="d-flex flex-column gap-1">
                                    <span v-if="item.penguji_1" class="badge bg-info">{{ item.penguji_1 }}</span>
                                    <span v-if="item.penguji_2" class="badge bg-info">{{ item.penguji_2 }}</span>
                                    <span v-if="item.penguji_3" class="badge bg-info">{{ item.penguji_3 }}</span>
                                </div>
                            </td>
                            <td><span class="badge bg-primary">{{ item.status }}</span></td>
                            <td>
                                <div class="d-flex gap-1">
                                    <button class="btn btn-sm btn-warning" @click="editJadwal(item)" title="Edit">
                                        <i class="fa fa-edit"></i>
                                    </button>
                                    <button class="btn btn-sm btn-danger" @click="confirmDelete(item)" title="Hapus">
                                        <i class="fa fa-trash"></i>
                                    </button>
                                </div>
                            </td>
                        </tr>
                        <tr v-if="jadwal.length === 0">
                            <td colspan="8" class="text-center text-muted">Belum ada jadwal ujian</td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- Modal -->
    <div v-if="showModal" class="modal-backdrop-custom">
        <div class="modal-card">
            <div class="modal-header-custom bg-success">
                <h5 class="fw-bold mb-0 text-white">{{ isEdit ? 'Edit' : 'Tambah' }} Jadwal Ujian</h5>
                <button class="btn-close btn-close-white" @click="closeModal"></button>
            </div>
            <div class="modal-body-custom">
                <div class="mb-3" v-if="!isEdit">
                    <label class="fw-bold">Mahasiswa <span class="text-danger">*</span></label>
                    <select class="form-control" v-model="form.permintaan_akademik_id">
                        <option value="">-- Pilih Mahasiswa --</option>
                        <option v-for="p in permintaan" :key="p.id" :value="p.id">
                            {{ p.nama }} - {{ p.type }}
                        </option>
                    </select>
                </div>
                <div class="mb-3">
                    <label class="fw-bold">Jenis Ujian <span class="text-danger">*</span></label>
                    <select class="form-control" v-model="form.jenis_ujian">
                        <option value="">-- Pilih --</option>
                        <option>Ujian Proposal</option>
                        <option>Ujian Seminar Hasil</option>
                        <option>Ujian Skripsi</option>
                        <option>Ujian Komprehensif</option>
                    </select>
                </div>
                <div class="mb-3">
                    <label class="fw-bold">Tanggal & Waktu <span class="text-danger">*</span></label>
                    <input type="datetime-local" class="form-control" v-model="form.tanggal_ujian">
                </div>
                <div class="mb-3">
                    <label class="fw-bold">Ruangan</label>
                    <input class="form-control" v-model="form.ruangan" placeholder="Contoh: Ruang 301">
                </div>
                <div class="mb-3">
                    <label class="fw-bold">Penguji 1</label>
                    <input class="form-control" v-model="form.penguji_1" placeholder="Nama Penguji 1">
                </div>
                <div class="mb-3">
                    <label class="fw-bold">Penguji 2</label>
                    <input class="form-control" v-model="form.penguji_2" placeholder="Nama Penguji 2">
                </div>
                <div class="mb-3">
                    <label class="fw-bold">Penguji 3</label>
                    <input class="form-control" v-model="form.penguji_3" placeholder="Nama Penguji 3">
                </div>
                <div class="mb-3">
                    <label class="fw-bold">Catatan</label>
                    <textarea class="form-control" rows="3" v-model="form.catatan" placeholder="Catatan tambahan"></textarea>
                </div>
                <div class="mb-3" v-if="isEdit">
                    <label class="fw-bold">Status</label>
                    <select class="form-control" v-model="form.status">
                        <option>Terjadwal</option>
                        <option>Selesai</option>
                        <option>Dibatalkan</option>
                    </select>
                </div>
            </div>
            <div class="modal-footer-custom">
                <button class="btn btn-secondary" @click="closeModal">Batal</button>
                <button class="btn btn-success" :disabled="!isFormValid" @click="submitForm">
                    {{ isEdit ? 'Update' : 'Simpan' }}
                </button>
            </div>
        </div>
    </div>

    <!-- Modal Konfirmasi Hapus -->
    <div v-if="showDeleteModal" class="modal-backdrop-custom">
        <div class="modal-card-small">
            <div class="modal-header-custom bg-danger">
                <h5 class="fw-bold mb-0 text-white">Konfirmasi Hapus</h5>
                <button class="btn-close btn-close-white" @click="showDeleteModal = false"></button>
            </div>
            <div class="modal-body-custom">
                <div class="text-center mb-3">
                    <i class="fa fa-exclamation-triangle fa-3x text-danger mb-3"></i>
                    <p class="mb-2"><strong>Yakin ingin menghapus jadwal ini?</strong></p>
                    <p class="text-muted small">Mahasiswa: {{ deleteItem?.permintaan?.nama }}</p>
                    <p class="text-muted small">Jenis: {{ deleteItem?.jenis_ujian }}</p>
                    <p class="text-muted small">Tanggal: {{ formatDateTime(deleteItem?.tanggal_ujian) }}</p>
                </div>
            </div>
            <div class="modal-footer-custom">
                <button class="btn btn-secondary" @click="showDeleteModal = false">Batal</button>
                <button class="btn btn-danger" @click="deleteJadwal">
                    <i class="fa fa-trash me-1"></i>Hapus
                </button>
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
    jadwal: Array,
    permintaan: Array
})

const showModal = ref(false)
const isEdit = ref(false)
const editId = ref(null)
const showDeleteModal = ref(false)
const deleteItem = ref(null)

const form = ref({
    permintaan_akademik_id: '',
    jenis_ujian: '',
    tanggal_ujian: '',
    ruangan: '',
    penguji_1: '',
    penguji_2: '',
    penguji_3: '',
    catatan: '',
    status: 'Terjadwal'
})

const isFormValid = computed(() => {
    if (isEdit.value) {
        return form.value.jenis_ujian && form.value.tanggal_ujian
    }
    return form.value.permintaan_akademik_id && form.value.jenis_ujian && form.value.tanggal_ujian
})

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

function editJadwal(item) {
    isEdit.value = true
    editId.value = item.id
    form.value = {
        permintaan_akademik_id: item.permintaan_akademik_id,
        jenis_ujian: item.jenis_ujian,
        tanggal_ujian: new Date(item.tanggal_ujian).toISOString().slice(0, 16),
        ruangan: item.ruangan || '',
        penguji_1: item.penguji_1 || '',
        penguji_2: item.penguji_2 || '',
        penguji_3: item.penguji_3 || '',
        catatan: item.catatan || '',
        status: item.status
    }
    showModal.value = true
}

function confirmDelete(item) {
    deleteItem.value = item
    showDeleteModal.value = true
}

function deleteJadwal() {
    router.delete(`/admin/jadwal-ujian/${deleteItem.value.id}`, {
        onSuccess: () => {
            showDeleteModal.value = false
            deleteItem.value = null
        }
    })
}

function closeModal() {
    showModal.value = false
    isEdit.value = false
    editId.value = null
    form.value = {
        permintaan_akademik_id: '',
        jenis_ujian: '',
        tanggal_ujian: '',
        ruangan: '',
        penguji_1: '',
        penguji_2: '',
        penguji_3: '',
        catatan: '',
        status: 'Terjadwal'
    }
}

function submitForm() {
    if (isEdit.value) {
        router.put(`/admin/jadwal-ujian/${editId.value}`, form.value, {
            onSuccess: () => closeModal()
        })
    } else {
        router.post('/admin/jadwal-ujian', form.value, {
            onSuccess: () => closeModal()
        })
    }
}
</script>

<style scoped>
.card {
    border-radius: 12px;
}

.table th {
    background-color: #f8f9fa;
    font-weight: 600;
    text-align: center;
    vertical-align: middle;
    padding: 16px 12px;
}

.table td {
    text-align: center;
    vertical-align: middle;
    padding: 14px 12px;
}

.modal-backdrop-custom {
    position: fixed;
    inset: 0;
    background: rgba(0, 0, 0, 0.5);
    display: flex;
    justify-content: center;
    align-items: center;
    z-index: 9999;
}

.modal-card {
    width: 700px;
    max-height: 90vh;
    background: white;
    border-radius: 12px;
    display: flex;
    flex-direction: column;
}

.modal-card-small {
    width: 450px;
    background: white;
    border-radius: 12px;
    box-shadow: 0 10px 40px rgba(0, 0, 0, 0.2);
}

.modal-header-custom {
    padding: 16px 20px;
    display: flex;
    justify-content: space-between;
    align-items: center;
    border-radius: 12px 12px 0 0;
}

.modal-body-custom {
    flex: 1;
    padding: 20px;
    overflow-y: auto;
}

.modal-footer-custom {
    padding: 16px 20px;
    border-top: 1px solid #e5e7eb;
    display: flex;
    justify-content: flex-end;
    gap: 10px;
}
</style>
