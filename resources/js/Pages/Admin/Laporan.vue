<template>
<div class="general-2">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h1 class="h3 fw-bold text-dark mb-1">Laporan</h1>
            <p class="text-muted mb-0">Statistik dan laporan sistem</p>
        </div>
    </div>

    <div class="row g-3 mb-4">
        <div class="col-md-4">
            <div class="card stat-card">
                <div class="card-body">
                    <h6 class="text-muted mb-2">Total Mahasiswa</h6>
                    <h2 class="fw-bold mb-0">{{ stats.totalMahasiswa }}</h2>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card stat-card">
                <div class="card-body">
                    <h6 class="text-muted mb-2">Total Permintaan</h6>
                    <h2 class="fw-bold mb-0">{{ stats.totalPermintaan }}</h2>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card stat-card">
                <div class="card-body">
                    <h6 class="text-muted mb-2">Total KKN</h6>
                    <h2 class="fw-bold mb-0">{{ stats.totalKKN }}</h2>
                </div>
            </div>
        </div>
    </div>

    <div class="row g-3">
        <div class="col-md-6">
            <div class="card">
                <div class="card-body">
                    <h5 class="fw-bold mb-3">Status Permintaan</h5>
                    <div class="mb-3">
                        <div class="d-flex justify-content-between mb-2">
                            <span>Disetujui</span>
                            <span class="fw-bold text-success">{{ stats.permintaanDisetujui }}</span>
                        </div>
                        <div class="progress" style="height: 10px;">
                            <div class="progress-bar bg-success" :style="{width: (stats.permintaanDisetujui / stats.totalPermintaan * 100) + '%'}"></div>
                        </div>
                    </div>
                    <div class="mb-3">
                        <div class="d-flex justify-content-between mb-2">
                            <span>Pending</span>
                            <span class="fw-bold text-warning">{{ stats.permintaanPending }}</span>
                        </div>
                        <div class="progress" style="height: 10px;">
                            <div class="progress-bar bg-warning" :style="{width: (stats.permintaanPending / stats.totalPermintaan * 100) + '%'}"></div>
                        </div>
                    </div>
                    <div class="mb-3">
                        <div class="d-flex justify-content-between mb-2">
                            <span>Ditolak</span>
                            <span class="fw-bold text-danger">{{ stats.permintaanDitolak }}</span>
                        </div>
                        <div class="progress" style="height: 10px;">
                            <div class="progress-bar bg-danger" :style="{width: (stats.permintaanDitolak / stats.totalPermintaan * 100) + '%'}"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="card">
                <div class="card-body">
                    <h5 class="fw-bold mb-3">Ringkasan</h5>
                    <table class="table table-sm">
                        <tbody>
                            <tr>
                                <td>Total Aktivitas</td>
                                <td class="text-end fw-bold">{{ stats.totalAktivitas }}</td>
                            </tr>
                            <tr>
                                <td>Total Permintaan</td>
                                <td class="text-end fw-bold">{{ stats.totalPermintaan }}</td>
                            </tr>
                            <tr>
                                <td>Total KKN</td>
                                <td class="text-end fw-bold">{{ stats.totalKKN }}</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
</template>

<script setup>
import PanelLayout from '@/Layouts/PanelLayout/FinancePanelLayout.vue'

defineOptions({ layout: PanelLayout })

defineProps({
    stats: Object,
    permintaanPerBulan: Array
})
</script>

<style scoped>
.card {
    border-radius: 12px;
}

.stat-card {
    transition: transform 0.2s;
}

.stat-card:hover {
    transform: translateY(-5px);
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
