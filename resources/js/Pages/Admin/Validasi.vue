<template>
<div class="container-fluid py-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h1 class="h3 fw-bold text-dark mb-1">Validasi Permintaan</h1>
            <p class="text-muted mb-0">Approve atau tolak permintaan mahasiswa</p>
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
                            <th>NIM</th>
                            <th>Jenis</th>
                            <th>Judul</th>
                            <th>Tanggal</th>
                            <th>Status</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr v-for="(item, index) in permintaan" :key="item.id">
                            <td>{{ index + 1 }}</td>
                            <td>{{ item.nama }}</td>
                            <td>{{ item.nim }}</td>
                            <td>{{ item.type }}</td>
                            <td>{{ item.judul }}</td>
                            <td>{{ formatDate(item.created_at) }}</td>
                            <td>
                                <span class="badge" :class="getStatusClass(item.status_proposal)">
                                    {{ item.status_proposal }}
                                </span>
                            </td>
                            <td>
                                <div class="d-flex gap-2 justify-content-center">
                                    <button v-if="item.status_proposal === 'Menunggu'" 
                                        class="btn btn-sm btn-success" 
                                        @click="showApproveModal(item)"
                                        title="Setuju">
                                        <i class="fa fa-check"></i>
                                    </button>
                                    <button v-if="item.status_proposal === 'Menunggu'" 
                                        class="btn btn-sm btn-danger" 
                                        @click="showRejectModal(item)"
                                        title="Tolak">
                                        <i class="fa fa-times"></i>
                                    </button>
                                    <span v-if="item.status_proposal !== 'Menunggu'" class="text-muted">-</span>
                                </div>
                            </td>
                        </tr>
                        <tr v-if="permintaan.length === 0">
                            <td colspan="8" class="text-center text-muted">Belum ada permintaan</td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- Modal Approve -->
    <div v-if="modalApprove" class="modal-backdrop-custom">
        <div class="modal-card">
            <div class="modal-header-custom bg-success">
                <h5 class="fw-bold mb-0 text-white">Konfirmasi Persetujuan</h5>
                <button class="btn-close btn-close-white" @click="modalApprove = false"></button>
            </div>
            <div class="modal-body-custom">
                <p class="mb-2"><strong>Mahasiswa:</strong> {{ selectedItem?.nama }}</p>
                <p class="mb-2"><strong>Jenis:</strong> {{ selectedItem?.type }}</p>
                <p class="mb-3"><strong>Judul:</strong> {{ selectedItem?.judul }}</p>
                <div class="alert alert-success">
                    <i class="fa fa-check-circle me-2"></i>
                    Apakah Anda yakin ingin menyetujui permintaan ini?
                </div>
            </div>
            <div class="modal-footer-custom">
                <button class="btn btn-secondary" @click="modalApprove = false">Batal</button>
                <button class="btn btn-success" @click="approve">Ya, Setujui</button>
            </div>
        </div>
    </div>

    <!-- Modal Reject -->
    <div v-if="modalReject" class="modal-backdrop-custom">
        <div class="modal-card">
            <div class="modal-header-custom bg-danger">
                <h5 class="fw-bold mb-0 text-white">Konfirmasi Penolakan</h5>
                <button class="btn-close btn-close-white" @click="closeRejectModal"></button>
            </div>
            <div class="modal-body-custom">
                <p class="mb-2"><strong>Mahasiswa:</strong> {{ selectedItem?.nama }}</p>
                <p class="mb-2"><strong>Jenis:</strong> {{ selectedItem?.type }}</p>
                <p class="mb-3"><strong>Judul:</strong> {{ selectedItem?.judul }}</p>
                <div class="alert alert-danger">
                    <i class="fa fa-exclamation-triangle me-2"></i>
                    Apakah Anda yakin ingin menolak permintaan ini?
                </div>
                <div class="mb-3">
                    <label class="fw-bold">Alasan Penolakan <span class="text-danger">*</span></label>
                    <textarea 
                        class="form-control" 
                        rows="4" 
                        v-model="alasanPenolakan"
                        placeholder="Masukkan alasan penolakan..."
                    ></textarea>
                </div>
            </div>
            <div class="modal-footer-custom">
                <button class="btn btn-secondary" @click="closeRejectModal">Batal</button>
                <button class="btn btn-danger" :disabled="!alasanPenolakan.trim()" @click="reject">Ya, Tolak</button>
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
    permintaan: Array
})

const modalApprove = ref(false)
const modalReject = ref(false)
const selectedItem = ref(null)
const alasanPenolakan = ref('')

function formatDate(date) {
    if (!date) return '-'
    return new Date(date).toLocaleDateString('id-ID', {
        day: '2-digit',
        month: 'long',
        year: 'numeric'
    })
}

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

function showApproveModal(item) {
    selectedItem.value = item
    modalApprove.value = true
}

function showRejectModal(item) {
    selectedItem.value = item
    alasanPenolakan.value = ''
    modalReject.value = true
}

function closeRejectModal() {
    modalReject.value = false
    alasanPenolakan.value = ''
    selectedItem.value = null
}

function approve() {
    router.post(`/admin/validasi/${selectedItem.value.id}/approve`, {}, {
        onSuccess: () => {
            modalApprove.value = false
            selectedItem.value = null
        }
    })
}

function reject() {
    router.post(`/admin/validasi/${selectedItem.value.id}/reject`, {
        alasan: alasanPenolakan.value
    }, {
        onSuccess: () => {
            closeRejectModal()
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
