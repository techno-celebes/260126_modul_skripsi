<template>
<div class="container-fluid py-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h1 class="h3 fw-bold text-dark mb-1">Transkrip Nilai</h1>
            <p class="text-muted mb-0">Riwayat nilai dan prestasi akademik</p>
        </div>
        <button class="btn btn-primary" @click="printTranskrip">
            <i class="fa fa-print me-2"></i>Cetak Transkrip
        </button>
    </div>

    <!-- Info Mahasiswa -->
    <div class="card mb-4">
        <div class="card-body">
            <div class="row">
                <div class="col-md-6">
                    <div class="mb-2" style="display: flex;">
                        <strong style="width: 130px;">Nama:</strong>
                        <span style="flex: 1;">{{ user?.name }}</span>
                    </div>
                    <div class="mb-2" style="display: flex;">
                        <strong style="width: 130px;">NIM:</strong>
                        <span style="flex: 1;">{{ user?.nim }}</span>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="mb-2" style="display: flex;">
                        <strong style="width: 130px;">Program Studi:</strong>
                        <span style="flex: 1;">{{ user?.prodi || '-' }}</span>
                    </div>
                    <div class="mb-2" style="display: flex;">
                        <strong style="width: 130px;">Angkatan:</strong>
                        <span style="flex: 1;">{{ user?.angkatan || '-' }}</span>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Statistik -->
    <div class="row g-3 mb-4">
        <div class="col-md-3">
            <div class="card border-primary h-100">
                <div class="card-body text-center py-4">
                    <div class="mb-3">
                        <i class="fa fa-star fa-2x text-primary"></i>
                    </div>
                    <h4 class="fw-bold mb-1">{{ ipk }}</h4>
                    <small class="text-muted">IPK</small>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card border-success h-100">
                <div class="card-body text-center py-4">
                    <div class="mb-3">
                        <i class="fa fa-check-circle fa-2x text-success"></i>
                    </div>
                    <h4 class="fw-bold mb-1">{{ totalLulus }}</h4>
                    <small class="text-muted">Aktivitas Lulus</small>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card border-warning h-100">
                <div class="card-body text-center py-4">
                    <div class="mb-3">
                        <i class="fa fa-clock fa-2x text-warning"></i>
                    </div>
                    <h4 class="fw-bold mb-1">{{ totalProses }}</h4>
                    <small class="text-muted">Sedang Proses</small>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card border-info h-100">
                <div class="card-body text-center py-4">
                    <div class="mb-3">
                        <i class="fa fa-book fa-2x text-info"></i>
                    </div>
                    <h4 class="fw-bold mb-1">{{ totalSKS }}</h4>
                    <small class="text-muted">Total SKS</small>
                </div>
            </div>
        </div>
    </div>

    <!-- Tabel Transkrip -->
    <div class="card">
        <div class="card-body">
            <h5 class="fw-bold mb-3">Riwayat Nilai</h5>
            <div class="table-responsive">
                <table class="table table-hover">
                    <thead class="table-light">
                        <tr>
                            <th>No</th>
                            <th>Jenis Aktivitas</th>
                            <th>Keterangan</th>
                            <th>Tanggal</th>
                            <th>Nilai</th>
                            <th>Grade</th>
                            <th>Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr v-for="(item, index) in transkrip" :key="item.id">
                            <td>{{ index + 1 }}</td>
                            <td>{{ item.jenis }}</td>
                            <td>{{ item.keterangan }}</td>
                            <td>{{ formatDate(item.tanggal) }}</td>
                            <td>
                                <span v-if="item.nilai" class="badge bg-primary fs-6">{{ item.nilai }}</span>
                                <span v-else class="text-muted">-</span>
                            </td>
                            <td>
                                <span v-if="item.nilai" class="badge" :class="getGradeClass(item.nilai)">
                                    {{ getGrade(item.nilai) }}
                                </span>
                                <span v-else>-</span>
                            </td>
                            <td>
                                <span class="badge" :class="getStatusClass(item.status)">
                                    {{ item.status }}
                                </span>
                            </td>
                        </tr>
                        <tr v-if="transkrip.length === 0">
                            <td colspan="7" class="text-center text-muted py-4">
                                <i class="fa fa-inbox fa-2x mb-2 d-block"></i>
                                Belum ada data nilai
                            </td>
                        </tr>
                    </tbody>
                </table>
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
    transkrip: Array,
    user: Object
})

const ipk = computed(() => {
    const nilaiList = props.transkrip.filter(t => t.nilai)
    if (nilaiList.length === 0) return '0.00'
    const total = nilaiList.reduce((sum, t) => sum + parseFloat(t.nilai), 0)
    return (total / nilaiList.length).toFixed(2)
})

const totalLulus = computed(() => {
    return props.transkrip.filter(t => t.status === 'Disetujui' && t.nilai).length
})

const totalProses = computed(() => {
    return props.transkrip.filter(t => t.status === 'Menunggu').length
})

const totalSKS = computed(() => {
    return props.transkrip.filter(t => t.status === 'Disetujui').length * 4
})

function formatDate(date) {
    if (!date) return '-'
    return new Date(date).toLocaleDateString('id-ID', {
        day: '2-digit',
        month: 'long',
        year: 'numeric'
    })
}

function getGrade(nilai) {
    const n = parseFloat(nilai)
    if (n >= 85) return 'A'
    if (n >= 75) return 'B'
    if (n >= 65) return 'C'
    if (n >= 55) return 'D'
    return 'E'
}

function getGradeClass(nilai) {
    const grade = getGrade(nilai)
    const map = {
        'A': 'bg-success',
        'B': 'bg-info',
        'C': 'bg-warning text-dark',
        'D': 'bg-danger',
        'E': 'bg-dark'
    }
    return map[grade] || 'bg-secondary'
}

function getStatusClass(status) {
    const map = {
        'Menunggu': 'bg-warning text-dark',
        'Disetujui': 'bg-success text-white',
        'Ditolak': 'bg-danger text-white'
    }
    return map[status] || 'bg-secondary text-white'
}

function printTranskrip() {
    window.print()
}
</script>

<style scoped>
.card {
    border-radius: 12px;
    box-shadow: 0 2px 4px rgba(0,0,0,0.05);
}

.card-body {
    display: flex;
    flex-direction: column;
    align-items: center;
    justify-content: center;
}

.card-body h4 {
    text-align: center;
}

.card-body small {
    text-align: center;
}

@media print {
    @page {
        size: A4;
        margin: 15mm;
    }
    
    .btn {
        display: none !important;
    }
    
    .card {
        box-shadow: none !important;
        border: 1px solid #ddd !important;
        page-break-inside: avoid;
    }
    
    .table-responsive {
        overflow: visible !important;
    }
    
    .table {
        width: 100% !important;
        font-size: 10px !important;
        table-layout: auto !important;
    }
    
    .table th, .table td {
        padding: 6px 3px !important;
        white-space: nowrap !important;
        font-size: 10px !important;
    }
    
    .table th {
        background-color: #f8f9fa !important;
        -webkit-print-color-adjust: exact;
        print-color-adjust: exact;
        font-weight: bold !important;
    }
    
    .badge {
        border: 1px solid #000 !important;
        padding: 1px 4px !important;
        font-size: 9px !important;
        white-space: nowrap !important;
    }
    
    .row.g-3 {
        display: none !important;
    }
    
    h1, h5 {
        font-size: 14px !important;
    }
}
</style>
