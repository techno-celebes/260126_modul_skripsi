<template>
    <div class="container-fluid py-4">
    
        <!-- HEADER -->
        <div class="d-flex justify-content-between align-items-center mb-4">
            <div>
                <h1 class="h3 fw-bold text-dark mb-1">Tugas Akhir</h1>
                <p class="text-muted mb-0">Tambahkan Permintaan Anda</p>
            </div>
            <button class="btn btn-warning text-white" @click="showModal = true">
                Tambah Permintaan
            </button>
        </div>
    
        <!-- TABLE -->
        <div class="card mb-4">
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-hover align-middle">
                        <thead class="table-light">
                            <tr>
                                <th>No</th>
                                <th>Nama</th>
                                <th>NIM</th>
                                <th>Type</th>
                                <th>Judul</th>
                                <th>Status</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr v-for="(item, index) in dataPermintaan" :key="index">
                                <td>{{ index + 1 }}</td>
                                <td>{{ item.nama }}</td>
                                <td>{{ item.nim }}</td>
                                <td>{{ item.type }}</td>
                                <td>{{ item.judul }}</td>
                                <td>
                                    <span class="badge bg-warning">Pending</span>
                                </td>
                                <td>
                                    <button class="btn btn-sm btn-warning text-white"
                                        @click="openDetail(item)">
                                        Detail
                                    </button>
                                </td>
                            </tr>
    
                            <tr v-if="dataPermintaan.length === 0">
                                <td colspan="7" class="text-center text-muted">
                                    Belum ada data permintaan
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    
        <!-- MODAL TAMBAH -->
        <div v-if="showModal" class="modal-backdrop-custom">
            <div class="modal-card">
    
                <div class="modal-header-custom">
                    <h5 class="fw-bold mb-0">Tambah Permintaan</h5>
                    <button class="btn-close" @click="closeModal"></button>
                </div>
    
                <div class="modal-body-custom">
    
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label>Nama Mahasiswa</label>
                            <input class="form-control" v-model="form.nama" disabled>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label>NIM</label>
                            <input class="form-control" v-model="form.nim" disabled>
                        </div>
                    </div>
    
                    <div class="mb-3">
                        <label>Type Permintaan</label>
                        <select class="form-select" v-model="form.type">
                            <option value="">---</option>
                            <option>Proposal-Skripsi</option>
                            <option>Proposal-Artikel</option>
                            <option>Komperehensif</option>
                            <option>Seminar Hasil-Skripsi</option>
                            <option>Seminar Hasil-Artikel</option>
                        </select>
                    </div>
    
                    <div class="mb-3">
                        <label>Periode Akademik</label>
                        <select class="form-select" v-model="form.periode">
                            <option value="">---</option>
                            <option>Periode Gasal</option>
                            <option>Periode Genap</option>
                        </select>
                    </div>
    
                    <div class="mb-3">
                        <label>Program Studi</label>
                        <input class="form-control" v-model="form.prodi" disabled>
                    </div>
    
                    <div class="mb-3">
                        <label>Judul Permintaan</label>
                        <input class="form-control" v-model="form.judul"
                            placeholder="Masukkan Judul">
                    </div>
    
                    <!-- MUNCUL SETELAH JUDUL -->
                    <div v-if="isStep1Valid">
                        <hr>
    
                        <div class="mb-3">
                            <label>No Telp</label>
                            <input class="form-control" v-model="form.telp" disabled>
                        </div>
    
                        <div class="mb-3">
                            <label>Email</label>
                            <input class="form-control" v-model="form.email" disabled>
                        </div>
    
                        <div class="mb-3">
                            <label>Alamat</label>
                            <input class="form-control" v-model="form.alamat" disabled>
                        </div>
                    </div>
    
                </div>
    
                <div class="modal-footer-custom">
                    <button class="btn btn-danger" @click="closeModal">
                        Close
                    </button>
                    <button class="btn btn-warning text-white"
                        :disabled="!isStep1Valid"
                        @click="submit">
                        Submit
                    </button>
                </div>
            </div>
        </div>
    
        <!-- MODAL DETAIL -->
        <div v-if="showDetail" class="modal-backdrop-custom">
            <div class="modal-card">
    
                <div class="modal-header-custom">
                    <h5 class="fw-bold mb-0">Detail Permintaan</h5>
                    <button class="btn-close" @click="showDetail=false"></button>
                </div>
    
                <div class="modal-body-custom">
                    <p><b>Nama:</b> {{ detail.nama }}</p>
                    <p><b>NIM:</b> {{ detail.nim }}</p>
                    <p><b>Type:</b> {{ detail.type }}</p>
                    <p><b>Periode:</b> {{ detail.periode }}</p>
                    <p><b>Prodi:</b> {{ detail.prodi }}</p>
                    <p><b>Judul:</b> {{ detail.judul }}</p>
                    <p><b>Status:</b> Pending</p>
                </div>
    
                <div class="modal-footer-custom">
                    <button class="btn btn-danger" @click="showDetail=false">
                        Close
                    </button>
                </div>
            </div>
        </div>
    
    </div>
    </template>
    
    <script setup>
    import { ref, computed } from 'vue'
    import PanelLayout from '@/Layouts/PanelLayout/FinancePanelLayout.vue'
    defineOptions({ layout: PanelLayout })
    
    const showModal = ref(false)
    const showDetail = ref(false)
    const detail = ref({})
    
    const form = ref({
        nama:'Andi frfr',
        nim:'123456789',
        type:'',
        periode:'',
        prodi:'Informatika',
        judul:'',
        telp:'0823BakalaeKitaDua',
        email:'test@example.com',
        alamat:'Jl. Contoh No. 123'
    })
    
    const dataPermintaan = ref([])
    
    const isStep1Valid = computed(() =>
        form.value.type &&
        form.value.periode &&
        form.value.judul
    )
    
    function closeModal(){
        showModal.value = false
    }
    
    function submit(){
        dataPermintaan.value.push({ ...form.value })
        showModal.value = false
    }
    
    function openDetail(item){
        detail.value = item
        showDetail.value = true
    }
    </script>
    
    <style scoped>
    .card{
        border-radius:12px;
    }
    
    .modal-backdrop-custom{
        position:fixed;
        inset:0;
        background:rgba(0,0,0,.45);
        display:flex;
        justify-content:center;
        align-items:center;
        z-index:9999;
    }
    
    .modal-card{
        width:700px;
        max-height:90vh;
        background:white;
        border-radius:12px;
        display:flex;
        flex-direction:column;
    }
    
    .modal-header-custom{
        padding:16px 20px;
        border-bottom:1px solid #e5e7eb;
        display:flex;
        justify-content:space-between;
        align-items:center;
    }
    
    .modal-body-custom{
        flex:1;
        padding:18px 20px;
        overflow-y:auto;
    }
    
    .modal-footer-custom{
        padding:16px 20px;
        border-top:1px solid #e5e7eb;
        display:flex;
        justify-content:flex-end;
        gap:10px;
    }
    
    input, select{
        border-radius:6px;
        font-size:14px;
    }
    </style>
    