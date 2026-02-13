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
                        <button class="btn w-100 tab-button"
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
                            <div class="mb-3">
                                <label class="fw-bold">Nama Mahasiswa</label>
                                <p>{{ aktivitas?.nama || '-' }}</p>
                            </div>
                            <div class="mb-3">
                                <label class="fw-bold">NIM</label>
                                <p>{{ aktivitas?.nim || '-' }}</p>
                            </div>
                            <div class="mb-3">
                                <label class="fw-bold">Jenis Aktivitas</label>
                                <p>{{ aktivitas?.jenis || '-' }}</p>
                            </div>
                            <div class="mb-3">
                                <label class="fw-bold">Keterangan</label>
                                <p>{{ aktivitas?.keterangan || '-' }}</p>
                            </div>
                            <div class="mb-3">
                                <label class="fw-bold">Status</label>
                                <p><span class="badge bg-warning">{{ aktivitas?.status || 'Pending' }}</span></p>
                            </div>
                        </div>
    
                        <!-- LOG -->
                        <div v-if="activeTab==='log'">
                            <h5 class="fw-bold mb-3">Log Aktivitas</h5>

                            <div class="table-responsive">
                                <table class="table table-hover">
                                    <thead>
                                        <tr>
                                            <th>No</th>
                                            <th>Aktivitas</th>
                                            <th>Waktu</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr v-for="(log, index) in logs" :key="log.id">
                                            <td>{{ index + 1 }}</td>
                                            <td>{{ log.judul }}</td>
                                            <td>{{ formatDate(log.created_at) }}</td>
                                        </tr>
                                        <tr v-if="logs.length === 0">
                                            <td colspan="3" class="text-center text-muted">
                                                Belum ada log aktivitas
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
    
                        <!-- NILAI -->
                        <div v-if="activeTab==='nilai'">
                            <h5 class="fw-bold mb-3">Penilaian</h5>
                            <div class="alert alert-info">
                                Penilaian belum tersedia.
                            </div>
                            <div class="mb-3">
                                <label class="fw-bold">Nilai Akhir</label>
                                <p class="fs-4">-</p>
                            </div>
                            <div class="mb-3">
                                <label class="fw-bold">Catatan</label>
                                <p>Belum ada catatan.</p>
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
    import { ref } from 'vue'
    import { Link } from "@inertiajs/vue3";
    
    defineOptions({ layout: PanelLayout });
    
    defineProps({
        aktivitas: Object,
        logs: {
            type: Array,
            default: () => []
        }
    });
    
    const activeTab = ref('detail')

    function formatDate(date) {
        return new Date(date).toLocaleString('id-ID')
    }
    </script>
    
    <style scoped>
    .card{border-radius:12px;}
    .tab-button{text-align:left;font-weight:600;transition:.3s;}
    .tab-button:hover{transform:translateX(5px);}
    </style>
    