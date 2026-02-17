<template>
    <div class="container-fluid py-4">
        
        <!-- HEADER -->
        <div class="d-flex justify-content-between align-items-center mb-4">
            <div>
                <h1 class="h3 fw-bold text-dark mb-1">Detail Aktivitas</h1>
                <p class="text-muted mb-0">Informasi detail aktivitas mahasiswa</p>
            </div>
            <Link :href="route('aktivitas')" class="btn btn-secondary">
                Kembali
            </Link>
        </div>
    
        <div class="row g-3">
            
            <!-- SIDEBAR -->
            <div class="col-md-3">
                <div class="card">
                    <div class="card-body p-2">
                        <button class="btn w-100 mb-2 tab-button"
                            :class="activeTab === 'detail' ? 'btn-success' : 'btn-light'"
                            @click="activeTab='detail'">
                            <i class="fa fa-info-circle me-2"></i>Detail Aktivitas
                        </button>
                        <button class="btn w-100 mb-2 tab-button"
                            :class="activeTab === 'log' ? 'btn-success' : 'btn-light'"
                            @click="activeTab='log'">
                            <i class="fa fa-list me-2"></i>Log Aktivitas
                        </button>
                        <button v-if="aktivitas?.status === 'Disetujui'" class="btn w-100 tab-button"
                            :class="activeTab === 'nilai' ? 'btn-success' : 'btn-light'"
                            @click="activeTab='nilai'">
                            <i class="fa fa-star me-2"></i>Penilaian
                        </button>
                    </div>
                </div>
            </div>
    
            <!-- CONTENT -->
            <div class="col-md-9">
                <div class="card">
                    <div class="card-body">
    
                        <!-- DETAIL -->
                        <div v-if="activeTab==='detail'">
                            <h5 class="fw-bold mb-3">Detail Aktivitas</h5>
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label class="fw-bold text-dark">Nama Mahasiswa</label>
                                    <p class="text-dark">{{ aktivitas?.nama || '-' }}</p>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label class="fw-bold text-dark">NIM</label>
                                    <p class="text-dark">{{ aktivitas?.nim || '-' }}</p>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label class="fw-bold text-dark">Jenis Aktivitas</label>
                                    <p class="text-dark">{{ aktivitas?.jenis || '-' }}</p>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label class="fw-bold text-dark">Status</label>
                                    <p>
                                        <span class="badge fs-6" :class="getStatusBadgeClass(aktivitas?.status)">
                                            {{ aktivitas?.status || 'Pending' }}
                                        </span>
                                    </p>
                                </div>
                            </div>
                            <div class="mb-3">
                                <label class="fw-bold text-dark">Keterangan</label>
                                <p class="text-dark">{{ aktivitas?.keterangan || '-' }}</p>
                            </div>
                            <div class="mb-3">
                                <label class="fw-bold text-dark">Tanggal Dibuat</label>
                                <p class="text-dark">{{ formatDate(aktivitas?.created_at) }}</p>
                            </div>
                        </div>
    
                        <!-- LOG -->
                        <div v-if="activeTab==='log'">
                            <h5 class="fw-bold mb-3">Log Aktivitas</h5>
                            <p class="text-muted mb-4">Log otomatis dari KKN, Magang, dan Permintaan Akademik</p>

                            <!-- Timeline dengan bulat + garis -->
                            <div class="timeline-container">
                                <div v-for="(log, index) in logs" :key="log.id" class="timeline-item-wrapper">
                                    <div class="timeline-dot" :class="log.status_validasi === 'Disetujui' ? 'completed' : (log.status_validasi === 'Ditolak' ? 'rejected' : 'pending')">
                                        <i class="fa" :class="log.status_validasi === 'Disetujui' ? 'fa-check' : (log.status_validasi === 'Ditolak' ? 'fa-times' : 'fa-circle')"></i>
                                    </div>
                                    <div v-if="index < logs.length - 1" class="timeline-line"></div>
                                    <div class="timeline-content-box">
                                        <div class="d-flex justify-content-between align-items-start mb-2">
                                            <div>
                                                <h6 class="mb-1 fw-bold">{{ log.judul }}</h6>
                                                <p v-if="log.deskripsi" class="text-muted small mb-1">{{ log.deskripsi }}</p>
                                            </div>
                                            <span class="badge" :class="log.status_validasi === 'Disetujui' ? 'bg-success' : (log.status_validasi === 'Ditolak' ? 'bg-danger' : 'bg-warning text-dark')">
                                                {{ log.status_validasi || 'Menunggu' }}
                                            </span>
                                        </div>
                                        <div class="text-muted small mb-2">
                                            <i class="fa fa-calendar me-1"></i>{{ formatDate(log.created_at) }}
                                        </div>
                                        <div class="d-flex gap-2 align-items-center">
                                            <a v-if="log.file_path" :href="`/storage/${log.file_path}`" target="_blank" class="btn btn-sm btn-info">
                                                <i class="fa fa-download"></i> Lihat File
                                            </a>
                                            <span v-if="log.nilai" class="badge bg-primary">Nilai: {{ log.nilai }}</span>
                                            <span v-if="log.divalidasi_oleh" class="badge bg-info">
                                                <i class="fa fa-user me-1"></i>{{ log.divalidasi_oleh }}
                                            </span>
                                        </div>
                                    </div>
                                </div>
                                <div v-if="logs.length === 0" class="text-center text-muted py-4">
                                    <i class="fa fa-info-circle fa-2x mb-2"></i>
                                    <p>Belum ada log aktivitas</p>
                                </div>
                            </div>
                        </div>
    
                        <!-- NILAI -->
                        <div v-if="activeTab==='nilai' && aktivitas?.status === 'Disetujui'">
                            <h5 class="fw-bold mb-3">Penilaian Aktivitas</h5>
                            
                            <div class="table-responsive">
                                <table class="table table-hover align-middle">
                                    <thead class="table-light">
                                        <tr>
                                            <th>No</th>
                                            <th>Judul</th>
                                            <th>Tanggal</th>
                                            <th>Nilai</th>
                                            <th>Status</th>
                                            <th>Catatan</th>
                                            <th>Divalidasi Oleh</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr v-for="(log, index) in logs.filter(l => l.nilai)" :key="log.id">
                                            <td>{{ index + 1 }}</td>
                                            <td>{{ log.judul }}</td>
                                            <td>{{ formatDate(log.tanggal || log.created_at) }}</td>
                                            <td>
                                                <span v-if="log.nilai" class="badge bg-primary fs-6">{{ log.nilai }}</span>
                                                <span v-else class="text-muted">-</span>
                                            </td>
                                            <td>
                                                <span class="badge" :class="getStatusClass(log.status_validasi)">
                                                    {{ log.status_validasi || 'Menunggu' }}
                                                </span>
                                            </td>
                                            <td>{{ log.catatan_nilai || '-' }}</td>
                                            <td>{{ log.divalidasi_oleh || '-' }}</td>
                                        </tr>
                                        <tr v-if="logs.filter(l => l.nilai).length === 0">
                                            <td colspan="7" class="text-center text-muted">
                                                Belum ada penilaian
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>

                            <!-- Statistik Nilai -->
                            <div class="row g-3 mt-3">
                                <div class="col-md-4">
                                    <div class="card bg-light">
                                        <div class="card-body text-center">
                                            <h6 class="text-muted">Rata-rata Nilai</h6>
                                            <h2 class="fw-bold text-primary">{{ rataRataNilai }}</h2>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="card bg-light">
                                        <div class="card-body text-center">
                                            <h6 class="text-muted">Total Dinilai</h6>
                                            <h2 class="fw-bold text-success">{{ totalDinilai }}</h2>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="card bg-light">
                                        <div class="card-body text-center">
                                            <h6 class="text-muted">Menunggu Penilaian</h6>
                                            <h2 class="fw-bold text-warning">{{ totalMenunggu }}</h2>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
    
                    </div>
                </div>
            </div>
    
        </div>
    
    </div>
    </template>
    
    <script setup>
    import PanelLayout from "@/Layouts/PanelLayout/FinancePanelLayout.vue";
    import { ref, computed } from 'vue'
    import { Link } from "@inertiajs/vue3";
    
    defineOptions({ layout: PanelLayout });
    
    const props = defineProps({
        aktivitas: Object,
        logs: {
            type: Array,
            default: () => []
        }
    });
    
    const activeTab = ref('detail')

    const rataRataNilai = computed(() => {
        const nilaiArray = props.logs.filter(item => item.nilai).map(item => parseFloat(item.nilai))
        if (nilaiArray.length === 0) return '0.00'
        const sum = nilaiArray.reduce((a, b) => a + b, 0)
        return (sum / nilaiArray.length).toFixed(2)
    })

    const totalDinilai = computed(() => {
        return props.logs.filter(item => item.nilai).length
    })

    const totalMenunggu = computed(() => {
        return props.logs.filter(item => item.file_path && !item.nilai && item.status_validasi !== 'Ditolak').length
    })

    function formatDate(date) {
        if (!date) return '-'
        return new Date(date).toLocaleDateString('id-ID', {
            day: '2-digit',
            month: 'long',
            year: 'numeric',
            hour: '2-digit',
            minute: '2-digit'
        })
    }

    function getStatusClass(status) {
        const map = {
            'Menunggu': 'bg-warning text-dark',
            'Disetujui': 'bg-success text-white',
            'Ditolak': 'bg-danger text-white'
        }
        return map[status] || 'bg-secondary'
    }

    function getStatusBadgeClass(status) {
        const map = {
            'Menunggu': 'bg-warning text-dark',
            'Disetujui': 'bg-success text-white',
            'Ditolak': 'bg-danger text-white',
            'Selesai': 'bg-primary text-white',
            'Proses': 'bg-info text-white'
        }
        return map[status] || 'bg-secondary text-white'
    }
    </script>
    
    <style scoped>
    .card{border-radius:12px;}
    .tab-button{text-align:left;font-weight:600;transition:.3s;}
    .tab-button:hover{transform:translateX(5px);}

    .table th{
        background-color:#f8f9fa;
        font-weight:600;
        text-align: center;
        vertical-align: middle;
        padding: 16px 12px;
    }

    .table td {
        text-align: center;
        vertical-align: middle;
        padding: 14px 12px;
    }

    /* Timeline Style - Simple */
    .timeline-container {
        position: relative;
        padding-left: 30px;
    }

    .timeline-item-wrapper {
        position: relative;
        margin-bottom: 25px;
    }

    .timeline-dot {
        position: absolute;
        left: -27px;
        top: 0;
        font-size: 14px;
        z-index: 2;
    }

    .timeline-dot.completed i {
        color: #28a745;
    }

    .timeline-dot.pending i {
        color: #ffc107;
    }

    .timeline-dot.rejected i {
        color: #dc3545;
    }

    .timeline-line {
        position: absolute;
        left: -21px;
        top: 20px;
        width: 2px;
        height: calc(100% - 10px);
        background: #e5e7eb;
        z-index: 1;
    }

    .timeline-content-box {
        background: #f8f9fa;
        padding: 15px 20px;
        border-radius: 12px;
        border-left: 4px solid #0d6efd;
        box-shadow: 0 2px 4px rgba(0,0,0,0.05);
        transition: all 0.3s ease;
    }

    .timeline-content-box:hover {
        box-shadow: 0 4px 12px rgba(0,0,0,0.1);
        transform: translateX(5px);
    }
    .timeline-content-box {
    background: #f8f9fa;
    padding: 15px 20px;
    border-radius: 12px;
    border-left: 4px solid #0d6efd;
    box-shadow: 0 2px 4px rgba(0,0,0,0.05);
    transition: all 0.3s ease;
}

.timeline-content-box:hover {
    box-shadow: 0 4px 12px rgba(0,0,0,0.1);
    transform: translateX(5px);
}
</style>
