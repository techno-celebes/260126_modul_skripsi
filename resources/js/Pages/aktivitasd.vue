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
                                <label class="fw-bold">Judul</label>
                                <p>Pengabdian Masyarakat</p>
                            </div>
                            <div class="mb-3">
                                <label class="fw-bold">Mahasiswa</label>
                                <p>Budi Santoso</p>
                            </div>
                            <div class="mb-3">
                                <label class="fw-bold">Lokasi</label>
                                <p>Desa Sukamaju</p>
                            </div>
                            <div class="mb-3">
                                <label class="fw-bold">Periode</label>
                                <p>Jan - Feb 2026</p>
                            </div>
                            <div class="mb-3">
                                <label class="fw-bold">Status</label>
                                <p><span class="badge bg-success">Aktif</span></p>
                            </div>
                        </div>
    
                        <!-- LOG -->
                        <div v-if="activeTab==='log'">
                            <h5 class="fw-bold mb-3">Log Aktivitas</h5>
    
                            <ul class="nav nav-tabs mb-3">
                                <li class="nav-item">
                                    <a class="nav-link" :class="{active:subTab==='harian'}" @click="subTab='harian'" style="cursor:pointer">
                                        Harian
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" :class="{active:subTab==='dokumen'}" @click="subTab='dokumen'" style="cursor:pointer">
                                        Dokumen
                                    </a>
                                </li>
                            </ul>
    
                            <div class="table-responsive">
                                <table class="table table-hover align-middle">
                                    <thead class="table-light">
                                        <tr>
                                            <th>No</th>
                                            <th>Judul</th>
                                            <th>Deskripsi</th>
                                            <th v-if="subTab==='harian'">Tanggal</th>
                                            <th>File</th>
                                            <th>Aksi</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td>1</td>
                                            <td>Observasi</td>
                                            <td>Kunjungan lapangan</td>
                                            <td v-if="subTab==='harian'">2026-02-01</td>
                                            <td><span class="badge bg-info">PDF</span></td>
                                            <td>
                                                <button class="btn btn-sm btn-warning text-white" @click="showDetail=true">
                                                    Detail
                                                </button>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>2</td>
                                            <td>Diskusi</td>
                                            <td>Diskusi dengan warga</td>
                                            <td v-if="subTab==='harian'">2026-02-03</td>
                                            <td><span class="badge bg-info">JPG</span></td>
                                            <td>
                                                <button class="btn btn-sm btn-warning text-white" @click="showDetail=true">
                                                    Detail
                                                </button>
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
    
        <!-- MODAL -->
        <div v-if="showDetail" class="modal-backdrop-custom">
            <div class="modal-card">
                <div class="modal-header-custom">
                    <h5 class="fw-bold mb-0">Detail Aktivitas</h5>
                    <button class="btn-close" @click="showDetail=false"></button>
                </div>
                <div class="modal-body-custom">
                    <p><b>Judul:</b> Observasi</p>
                    <p><b>Deskripsi:</b> Kunjungan lapangan</p>
                    <p><b>Tanggal:</b> 2026-02-01</p>
                    <p><b>File:</b> observasi.pdf</p>
                </div>
                <div class="modal-footer-custom">
                    <button class="btn btn-danger" @click="showDetail=false">Close</button>
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
        aktivitas: Object
    });
    
    const activeTab = ref('detail')
    const subTab = ref('harian')
    const showDetail = ref(false)
    </script>
    
    <style scoped>
    .card{border-radius:12px;}
    .tab-button{text-align:left;font-weight:600;transition:.3s;}
    .tab-button:hover{transform:translateX(5px);}
    .modal-backdrop-custom{
        position:fixed;inset:0;background:rgba(0,0,0,.45);
        display:flex;justify-content:center;align-items:center;z-index:9999;
    }
    .modal-card{
        width:600px;max-height:90vh;background:white;
        border-radius:12px;display:flex;flex-direction:column;
    }
    .modal-header-custom{
        padding:16px 20px;border-bottom:1px solid #e5e7eb;
        display:flex;justify-content:space-between;align-items:center;
    }
    .modal-body-custom{flex:1;padding:18px 20px;overflow-y:auto;}
    .modal-footer-custom{
        padding:16px 20px;border-top:1px solid #e5e7eb;
        display:flex;justify-content:flex-end;gap:10px;
    }
    </style>
    