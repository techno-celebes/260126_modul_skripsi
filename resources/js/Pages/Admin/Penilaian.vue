<template>
<div class="container-fluid py-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h1 class="h3 fw-bold text-dark mb-1">Penilaian Upload</h1>
            <p class="text-muted mb-0">Validasi dan beri nilai berkas yang diupload mahasiswa</p>
        </div>
    </div>

    <div class="card">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-hover">
                    <thead class="table-light">
                        <tr>
                            <th>No</th>
                            <th>Mahasiswa</th>
                            <th>Jenis</th>
                            <th>Judul Upload</th>
                            <th>Tanggal</th>
                            <th>Berkas</th>
                            <th>Nilai</th>
                            <th>Status</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr v-for="(item, index) in uploads" :key="item.id">
                            <td>{{ index + 1 }}</td>
                            <td>{{ item.permintaan?.user?.name || item.permintaan?.nama }}</td>
                            <td>{{ item.permintaan?.type }}</td>
                            <td>{{ item.judul }}</td>
                            <td>{{ formatDate(item.tanggal) }}</td>
                            <td>
                                <a v-if="item.file_path" :href="`/storage/${item.file_path}`" target="_blank" class="btn btn-sm btn-info">
                                    <i class="fa fa-download"></i> Lihat
                                </a>
                                <span v-else>-</span>
                            </td>
                            <td>
                                <span v-if="item.nilai" class="badge bg-primary">{{ item.nilai }}</span>
                                <span v-else class="text-muted">-</span>
                            </td>
                            <td>
                                <span class="badge" :class="getStatusClass(item.status_validasi)">
                                    {{ item.status_validasi || 'Menunggu' }}
                                </span>
                            </td>
                            <td>
                                <button v-if="!item.status_validasi || item.status_validasi === 'Menunggu'" 
                                    class="btn btn-sm btn-success me-1" 
                                    @click="showValidasiModal(item, 'Divalidasi')">
                                    <i class="fa fa-check"></i>
                                </button>
                                <button v-if="!item.status_validasi || item.status_validasi === 'Menunggu'" 
                                    class="btn btn-sm btn-danger" 
                                    @click="showValidasiModal(item, 'Ditolak')">
                                    <i class="fa fa-times"></i>
                                </button>
                                <button v-if="item.status_validasi === 'Divalidasi'" 
                                    class="btn btn-sm btn-warning" 
                                    @click="showValidasiModal(item, 'Divalidasi')">
                                    <i class="fa fa-edit"></i>
                                </button>
                                <span v-if="item.divalidasi_oleh" class="text-muted small d-block">{{ item.divalidasi_oleh }}</span>
                            </td>
                        </tr>
                        <tr v-if="uploads.length === 0">
                            <td colspan="9" class="text-center text-muted">Belum ada upload</td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- Modal Validasi -->
    <div v-if="modalValidasi" class="modal-backdrop-custom">
        <div class="modal-card">
            <div class="modal-header-custom" :class="statusValidasi === 'Divalidasi' ? 'bg-success' : 'bg-danger'">
                <h5 class="fw-bold mb-0 text-white">{{ statusValidasi === 'Divalidasi' ? 'Validasi & Beri Nilai' : 'Tolak' }} Upload</h5>
                <button class="btn-close btn-close-white" @click="closeModal"></button>
            </div>
            <div class="modal-body-custom">
                <p class="mb-2"><strong>Mahasiswa:</strong> {{ selectedItem?.permintaan?.user?.name || selectedItem?.permintaan?.nama }}</p>
                <p class="mb-2"><strong>Judul:</strong> {{ selectedItem?.judul }}</p>
                <p class="mb-3"><strong>Deskripsi:</strong> {{ selectedItem?.deskripsi || '-' }}</p>
                
                <div v-if="statusValidasi === 'Divalidasi'" class="mb-3">
                    <label class="fw-bold">Nilai (0-100) <span class="text-danger">*</span></label>
                    <input 
                        type="number" 
                        class="form-control" 
                        v-model="nilai" 
                        min="0" 
                        max="100" 
                        step="0.01"
                        placeholder="Masukkan nilai"
                    />
                </div>
                
                <div class="mb-3">
                    <label class="fw-bold">Catatan</label>
                    <textarea class="form-control" rows="3" v-model="catatan" placeholder="Tambahkan catatan (opsional)"></textarea>
                </div>
            </div>
            <div class="modal-footer-custom">
                <button class="btn btn-secondary" @click="closeModal">Batal</button>
                <button 
                    class="btn" 
                    :class="statusValidasi === 'Divalidasi' ? 'btn-success' : 'btn-danger'" 
                    :disabled="statusValidasi === 'Divalidasi' && !nilai"
                    @click="submitValidasi">
                    {{ statusValidasi === 'Divalidasi' ? 'Validasi & Simpan' : 'Tolak' }}
                </button>
            </div>
        </div>
    </div>
</div>
</template>

<script setup>
import { ref } from 'vue'
import { router } from '@inertiajs/vue3'
import PanelLayout from '@/Layouts/PanelLayout/FinancePanelLayout.vue'

defineOptions({ layout: PanelLayout })

defineProps({
    uploads: Array
})

const modalValidasi = ref(false)
const selectedItem = ref(null)
const statusValidasi = ref('')
const catatan = ref('')
const nilai = ref(null)

function formatDate(date) {
    if (!date) return '-'
    return new Date(date).toLocaleDateString('id-ID', {
        day: 'numeric',
        month: 'short',
        year: 'numeric'
    })
}

function getStatusClass(status) {
    const map = {
        'Menunggu': 'bg-warning text-dark',
        'Divalidasi': 'bg-success text-white',
        'Ditolak': 'bg-danger text-white',
        'Selesai': 'bg-primary text-white',
        'Proses': 'bg-info text-white'
    }
    return map[status] || 'bg-secondary text-white'
}

function showValidasiModal(item, status) {
    selectedItem.value = item
    statusValidasi.value = status
    catatan.value = item.catatan_nilai || ''
    nilai.value = item.nilai || null
    modalValidasi.value = true
}

function closeModal() {
    modalValidasi.value = false
    selectedItem.value = null
    catatan.value = ''
    nilai.value = null
}

function submitValidasi() {
    router.post(`/admin/penilaian/${selectedItem.value.original_id}/validasi`, {
        status: statusValidasi.value,
        catatan: catatan.value,
        nilai: nilai.value,
        type: selectedItem.value.type
    }, {
        onSuccess: () => {
            closeModal()
        }
    })
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
    width: 600px;
    max-height: 90vh;
    background: white;
    border-radius: 12px;
    display: flex;
    flex-direction: column;
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
