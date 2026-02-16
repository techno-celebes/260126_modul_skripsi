<template>
    <div class="container-fluid py-4">
        <!-- Header -->
        <div class="d-flex justify-content-between align-items-center mb-4 animate-fade-in">
            <div>
                <h1 class="h3 fw-bold text-dark mb-1" style="font-size: 1.75rem;">Dashboard</h1>
                <p class="text-muted mb-0" style="font-size: 0.95rem;">
                    Halo, <strong style="color: #38a169;">{{ auth.user.name }}</strong> - Selamat datang di Sistem Akademik
                </p>
            </div>
        </div>

        <!-- MAHASISWA DASHBOARD -->
        <div v-if="auth.user.role === 'mahasiswa'">
            <div class="row g-4 mb-4">
                <div class="col-md-3 animate-slide-in" style="animation-delay: 0.1s;">
                    <div class="card stat-card">
                        <div class="card-body p-3">
                            <div class="d-flex justify-content-between align-items-center">
                                <div>
                                    <p class="text-muted mb-2" style="font-size: 0.8rem; font-weight: 600;">Aktivitas</p>
                                    <h3 class="fw-bold mb-0" style="font-size: 1.75rem; color: #1a1a1a;">{{ stats.aktivitas }}</h3>
                                </div>
                                <div class="icon-box bg-warning bg-opacity-10" style="width: 48px; height: 48px;">
                                    <i class="fa fa-calendar fa-lg text-warning"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-3 animate-slide-in" style="animation-delay: 0.2s;">
                    <div class="card stat-card">
                        <div class="card-body p-3">
                            <div class="d-flex justify-content-between align-items-center">
                                <div>
                                    <p class="text-muted mb-2" style="font-size: 0.8rem; font-weight: 600;">Permintaan Akademik</p>
                                    <h3 class="fw-bold mb-0" style="font-size: 1.75rem; color: #1a1a1a;">{{ stats.permintaan }}</h3>
                                </div>
                                <div class="icon-box bg-success bg-opacity-10" style="width: 48px; height: 48px;">
                                    <i class="fa fa-graduation-cap fa-lg text-success"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-3 animate-slide-in" style="animation-delay: 0.3s;">
                    <div class="card stat-card">
                        <div class="card-body p-3">
                            <div class="d-flex justify-content-between align-items-center">
                                <div>
                                    <p class="text-muted mb-2" style="font-size: 0.8rem; font-weight: 600;">KKN</p>
                                    <h3 class="fw-bold mb-0" style="font-size: 1.75rem; color: #1a1a1a;">{{ stats.kkn }}</h3>
                                </div>
                                <div class="icon-box bg-info bg-opacity-10" style="width: 48px; height: 48px;">
                                    <i class="fa fa-users fa-lg text-info"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-3 animate-slide-in" style="animation-delay: 0.4s;">
                    <div class="card stat-card">
                        <div class="card-body p-3">
                            <div class="d-flex justify-content-between align-items-center">
                                <div>
                                    <p class="text-muted mb-2" style="font-size: 0.8rem; font-weight: 600;">Status</p>
                                    <h3 class="fw-bold mb-0 text-success" style="font-size: 1.75rem;">Aktif</h3>
                                </div>
                                <div class="icon-box bg-primary bg-opacity-10" style="width: 48px; height: 48px;">
                                    <i class="fa fa-check-circle fa-lg text-primary"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row g-3">
                <div class="col-md-8">
                    <div class="card">
                        <div class="card-body">
                            <h5 class="fw-bold mb-3">Aktivitas Terbaru</h5>
                            <div class="table-responsive">
                                <table class="table table-hover">
                                    <thead class="table-light">
                                        <tr>
                                            <th>Jenis</th>
                                            <th>Keterangan</th>
                                            <th>Status</th>
                                            <th>Tanggal</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr v-for="item in recentActivities" :key="item.id">
                                            <td>{{ item.jenis }}</td>
                                            <td>{{ item.keterangan }}</td>
                                            <td><span class="badge" :class="getActivityStatusClass(item.status)">{{ item.status }}</span></td>
                                            <td>{{ formatDate(item.created_at) }}</td>
                                        </tr>
                                        <tr v-if="recentActivities.length === 0">
                                            <td colspan="4" class="text-center text-muted">Belum ada aktivitas</td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="card">
                        <div class="card-body">
                            <h5 class="fw-bold mb-3">Quick Links</h5>
                            <div class="d-grid gap-2">
                                <Link href="/aktivitas" class="btn btn-warning text-dark">
                                    <i class="fa fa-calendar me-2"></i>Aktivitas
                                </Link>
                                <Link href="/tugasakhir" class="btn btn-success text-white">
                                    <i class="fa fa-graduation-cap me-2"></i>Permintaan Akademik
                                </Link>
                                <Link href="/kkn" class="btn btn-info text-white">
                                    <i class="fa fa-users me-2"></i>KKN
                                </Link>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- ADMIN DASHBOARD -->
        <div v-if="auth.user.role === 'admin'">
            <div class="row g-3 mb-4">
                <div class="col-md-3">
                    <div class="card stat-card">
                        <div class="card-body">
                            <div class="d-flex justify-content-between align-items-center">
                                <div>
                                    <p class="text-muted mb-1">Total Mahasiswa</p>
                                    <h3 class="fw-bold mb-0">{{ stats.totalMahasiswa }}</h3>
                                </div>
                                <div class="icon-box bg-primary bg-opacity-10">
                                    <i class="fa fa-users fa-2x text-primary"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="card stat-card">
                        <div class="card-body">
                            <div class="d-flex justify-content-between align-items-center">
                                <div>
                                    <p class="text-muted mb-1">Permintaan Pending</p>
                                    <h3 class="fw-bold mb-0">{{ stats.permintaanPending }}</h3>
                                </div>
                                <div class="icon-box bg-warning bg-opacity-10">
                                    <i class="fa fa-clock-o fa-2x text-warning"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="card stat-card">
                        <div class="card-body">
                            <div class="d-flex justify-content-between align-items-center">
                                <div>
                                    <p class="text-muted mb-1">Disetujui</p>
                                    <h3 class="fw-bold mb-0">{{ stats.permintaanDisetujui }}</h3>
                                </div>
                                <div class="icon-box bg-success bg-opacity-10">
                                    <i class="fa fa-check fa-2x text-success"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="card stat-card">
                        <div class="card-body">
                            <div class="d-flex justify-content-between align-items-center">
                                <div>
                                    <p class="text-muted mb-1">Total KKN</p>
                                    <h3 class="fw-bold mb-0">{{ stats.totalKKN }}</h3>
                                </div>
                                <div class="icon-box bg-info bg-opacity-10">
                                    <i class="fa fa-briefcase fa-2x text-info"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="card">
                <div class="card-body">
                    <h5 class="fw-bold mb-3">Permintaan Terbaru</h5>
                    <div class="table-responsive">
                        <table class="table table-hover">
                            <thead class="table-light">
                                <tr>
                                    <th>Mahasiswa</th>
                                    <th>NIM</th>
                                    <th>Jenis</th>
                                    <th>Judul</th>
                                    <th>Status</th>
                                    <th>Tanggal</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr v-for="item in recentPermintaan" :key="item.id">
                                    <td>{{ item.nama }}</td>
                                    <td>{{ item.nim }}</td>
                                    <td>{{ item.type }}</td>
                                    <td>{{ item.judul }}</td>
                                    <td><span class="badge" :class="getStatusClass(item.status_proposal)">{{ item.status_proposal }}</span></td>
                                    <td>{{ formatDate(item.created_at) }}</td>
                                </tr>
                                <tr v-if="recentPermintaan.length === 0">
                                    <td colspan="6" class="text-center text-muted">Belum ada permintaan</td>
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
import { Link } from '@inertiajs/vue3'
import PanelLayout from '@/Layouts/PanelLayout/FinancePanelLayout.vue'

defineOptions({ layout: PanelLayout })

const props = defineProps({
    auth: Object,
    stats: Object,
    recentActivities: {
        type: Array,
        default: () => []
    },
    recentPermintaan: {
        type: Array,
        default: () => []
    }
})

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
        'Disetujui': 'bg-success text-white',
        'Divalidasi': 'bg-success text-white',
        'Ditolak': 'bg-danger text-white',
        'Selesai': 'bg-primary text-white',
        'Proses': 'bg-info text-white'
    }
    return map[status] || 'bg-secondary text-white'
}

function getActivityStatusClass(status) {
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
.card {
    border-radius: 12px;
    transition: transform 0.2s;
}

.stat-card:hover {
    transform: translateY(-5px);
    box-shadow: 0 4px 12px rgba(0,0,0,0.1);
}

.icon-box {
    width: 60px;
    height: 60px;
    display: flex;
    align-items: center;
    justify-content: center;
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
