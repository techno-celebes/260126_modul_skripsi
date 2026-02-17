<template>
<div class="container-fluid py-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h1 class="h3 fw-bold text-dark mb-1">Nilai Saya</h1>
            <p class="text-muted mb-0">Lihat nilai dari setiap progress yang telah divalidasi</p>
        </div>
    </div>

    <div class="card">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-hover">
                    <thead class="table-light">
                        <tr>
                            <th>No</th>
                            <th>Jenis</th>
                            <th>Judul</th>
                            <th>Tanggal Upload</th>
                            <th>Nilai</th>
                            <th>Status</th>
                            <th>Catatan</th>
                            <th>Divalidasi Oleh</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr v-for="(item, index) in nilaiList" :key="item.id">
                            <td>{{ index + 1 }}</td>
                            <td>{{ item.jenis }}</td>
                            <td>{{ item.judul }}</td>
                            <td>{{ formatDate(item.tanggal) }}</td>
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
                        <tr v-if="nilaiList.length === 0">
                            <td colspan="8" class="text-center text-muted">Belum ada nilai</td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- Statistik Nilai -->
    <div class="row g-3 mt-3">
        <div class="col-md-4">
            <div class="card">
                <div class="card-body text-center">
                    <h6 class="text-muted">Rata-rata Nilai</h6>
                    <h2 class="fw-bold text-primary">{{ rataRata }}</h2>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card">
                <div class="card-body text-center">
                    <h6 class="text-muted">Total Dinilai</h6>
                    <h2 class="fw-bold text-success">{{ totalDinilai }}</h2>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card">
                <div class="card-body text-center">
                    <h6 class="text-muted">Menunggu Penilaian</h6>
                    <h2 class="fw-bold text-warning">{{ totalMenunggu }}</h2>
                </div>
            </div>
        </div>
    </div>
</div>
</template>

<script setup>
import { computed } from 'vue'
import PanelLayout from '@/Layouts/PanelLayout/FinancePanelLayout.vue'

defineOptions({ layout: PanelLayout })

const props = defineProps({
    nilaiList: Array
})

const rataRata = computed(() => {
    const nilaiArray = props.nilaiList.filter(item => item.nilai).map(item => parseFloat(item.nilai))
    if (nilaiArray.length === 0) return '0.00'
    const sum = nilaiArray.reduce((a, b) => a + b, 0)
    return (sum / nilaiArray.length).toFixed(2)
})

const totalDinilai = computed(() => {
    return props.nilaiList.filter(item => item.nilai).length
})

const totalMenunggu = computed(() => {
    return props.nilaiList.filter(item => !item.nilai && item.status_validasi !== 'Ditolak').length
})

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
</style>
