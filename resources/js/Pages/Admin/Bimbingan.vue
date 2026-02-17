<template>
<div class="container-fluid py-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h1 class="h3 fw-bold text-dark mb-1">Validasi Bimbingan</h1>
            <p class="text-muted mb-0">Validasi dan beri catatan untuk bimbingan mahasiswa</p>
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
                            <th>Judul Proposal</th>
                            <th>Judul Bimbingan</th>
                            <th>Catatan Mahasiswa</th>
                            <th>Tanggal</th>
                            <th>File</th>
                            <th>Status</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr v-for="(item, index) in bimbingan" :key="item.id">
                            <td>{{ index + 1 }}</td>
                            <td>{{ item.permintaan?.user?.name || item.permintaan?.nama }}</td>
                            <td>{{ item.permintaan?.judul }}</td>
                            <td>{{ item.judul }}</td>
                            <td>{{ item.catatan || '-' }}</td>
                            <td>{{ formatDate(item.tanggal) }}</td>
                            <td>
                                <a v-if="item.file_path" :href="`/storage/${item.file_path}`" target="_blank" class="btn btn-sm btn-info" title="Lihat File">
                                    <i class="fa fa-eye"></i>
                                </a>
                                <span v-else>-</span>
                            </td>
                            <td>
                                <span class="badge" :class="getStatusClass(item.status_validasi)">
                                    {{ item.status_validasi || 'Menunggu' }}
                                </span>
                            </td>
                            <td>
                                <div class="d-flex gap-1 align-items-center">
                                    <button v-if="!item.status_validasi || item.status_validasi === 'Menunggu'" 
                                        class="btn btn-sm btn-success" 
                                        @click="showValidasiModal(item, 'Disetujui')"
                                        title="Setujui">
                                        <i class="fa fa-check"></i>
                                    </button>
                                    <button v-if="!item.status_validasi || item.status_validasi === 'Menunggu'" 
                                        class="btn btn-sm btn-danger" 
                                        @click="showValidasiModal(item, 'Ditolak')"
                                        title="Tolak">
                                        <i class="fa fa-times"></i>
                                    </button>
                                    <button v-if="item.status_validasi === 'Disetujui'" 
                                        class="btn btn-sm btn-warning" 
                                        @click="showValidasiModal(item, 'Disetujui')"
                                        title="Edit Catatan">
                                        <i class="fa fa-edit"></i>
                                    </button>
                                </div>
                                <span v-if="item.divalidasi_oleh" class="text-muted small d-block mt-1">{{ item.divalidasi_oleh }}</span>
                            </td>
                        </tr>
                        <tr v-if="bimbingan.length === 0">
                            <td colspan="9" class="text-center text-muted">Belum ada bimbingan</td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- Modal Validasi -->
    <div v-if="modalValidasi" class="modal-backdrop-custom">
        <div class="modal-card">
            <div class="modal-header-custom" :class="statusValidasi === 'Disetujui' ? 'bg-success' : 'bg-danger'">
                <h5 class="fw-bold mb-0 text-white">{{ statusValidasi === 'Disetujui' ? 'Setujui' : 'Tolak' }} Bimbingan</h5>
                <button class="btn-close btn-close-white" @click="closeModal"></button>
            </div>
            <div class="modal-body-custom">
                <p class="mb-2"><strong>Mahasiswa:</strong> {{ selectedItem?.permintaan?.user?.name || selectedItem?.permintaan?.nama }}</p>
                <p class="mb-2"><strong>Judul Bimbingan:</strong> {{ selectedItem?.judul }}</p>
                <p class="mb-3"><strong>Catatan Mahasiswa:</strong> {{ selectedItem?.catatan || '-' }}</p>
                
                <div v-if="statusValidasi === 'Disetujui'" class="mb-3">
                    <label class="fw-bold">Nilai (0-100)</label>
                    <input type="number" class="form-control" v-model="nilai" min="0" max="100" step="0.01" placeholder="Opsional">
                    <small class="text-muted">Kosongkan jika tidak ingin memberi nilai</small>
                </div>
                
                <div class="mb-3">
                    <label class="fw-bold">Catatan Dosen <span class="text-danger">*</span></label>
                    <textarea class="form-control" rows="4" v-model="catatanDosen" 
                        :placeholder="statusValidasi === 'Disetujui' ? 'Berikan arahan/saran untuk mahasiswa...' : 'Alasan penolakan...'"></textarea>
                </div>
            </div>
            <div class="modal-footer-custom">
                <button class="btn btn-secondary" @click="closeModal">Batal</button>
                <button 
                    class="btn" 
                    :class="statusValidasi === 'Disetujui' ? 'btn-success' : 'btn-danger'" 
                    :disabled="!catatanDosen"
                    @click="submitValidasi">
                    {{ statusValidasi === 'Disetujui' ? 'Setujui Bimbingan' : 'Tolak Bimbingan' }}
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
    bimbingan: Array
})

const modalValidasi = ref(false)
const selectedItem = ref(null)
const statusValidasi = ref('')
const catatanDosen = ref('')
const nilai = ref(null)

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
        'Ditolak': 'bg-danger text-white'
    }
    return map[status] || 'bg-secondary text-white'
}

function showValidasiModal(item, status) {
    selectedItem.value = item
    statusValidasi.value = status
    catatanDosen.value = item.catatan_dosen || ''
    nilai.value = item.nilai || null
    modalValidasi.value = true
}

function closeModal() {
    modalValidasi.value = false
    selectedItem.value = null
    catatanDosen.value = ''
    nilai.value = null
}

function submitValidasi() {
    router.post(`/admin/bimbingan/${selectedItem.value.id}/validasi`, {
        status: statusValidasi.value,
        catatan_dosen: catatanDosen.value,
        nilai: nilai.value
    }, {
        onSuccess: () => closeModal()
    })
}
</script>

<style scoped>
.modal-backdrop-custom {
    position: fixed;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    background: rgba(0, 0, 0, 0.5);
    display: flex;
    align-items: center;
    justify-content: center;
    z-index: 9999;
}

.modal-card {
    background: white;
    border-radius: 12px;
    width: 90%;
    max-width: 600px;
    box-shadow: 0 10px 40px rgba(0, 0, 0, 0.2);
}

.modal-header-custom {
    padding: 1.5rem;
    border-radius: 12px 12px 0 0;
    display: flex;
    justify-content: space-between;
    align-items: center;
}

.modal-body-custom {
    padding: 1.5rem;
}

.modal-footer-custom {
    padding: 1rem 1.5rem;
    border-top: 1px solid #dee2e6;
    display: flex;
    justify-content: flex-end;
    gap: 0.5rem;
}
</style>
