<template>
    <div class="container-fluid py-4">
    
        <!-- Header -->
        <div class="d-flex justify-content-between align-items-center mb-4">
            <div>
                <h1 class="h3 fw-bold text-dark mb-1">Tugas Akhir</h1>
                <p class="text-muted mb-0">Tambahkan Permintaan Anda</p>
            </div>
            <button class="btn btn-warning text-white" @click="showModal = true">
                Tambah Permintaan
            </button>
        </div>
    
        <!-- MODAL -->
        <div v-if="showModal" class="modal-backdrop-custom">
            <div class="modal-card">
    
                <!-- Header -->
                <div class="modal-header-custom">
                    <h5 class="fw-bold mb-0">Tambah Permintaan</h5>
                    <button class="btn-close" @click="closeModal"></button>
                </div>
    
                <!-- Body -->
                <div class="modal-body-custom">
    
                    <!-- STEP 1 -->
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label>Nama Mahasiswa </label>
                            <input class="form-control" placeholder="Masukkan Nama" v-model="form.nama">
                        </div>
                        <div class="col-md-6 mb-3">
                            <label>NIM </label>
                            <input class="form-control" placeholder="Masukkan NIM" v-model="form.nim">
                        </div>
                    </div>
    
                    <div class="mb-3">
                        <label>Type Permintaan </label>
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
                        <label>Periode Akademik </label>
                        <select class="form-select" v-model="form.periode">
                            <option value="">---</option>
                            <option>Periode Gasal</option>
                            <option>Periode Genap</option>

                        </select>
                    </div>
    
                    <div class="mb-3">
                        <label>Program Studi </label>
                        <select class="form-select" placeholder="Pilih Program Studi" v-model="form.prodi">
                            <option value="">---</option>
                            <option>Informatika</option>
                            <option>Sistem Informasi</option>
                            <option>Teknik Arsitektur</option>
                            <option>Teknik Sipil</option>
                        </select>
                    </div>
    
                    <div class="mb-3">
                        <label>Judul Permintaan </label>
                        <input class="form-control" placeholder="Masukkan Judul" v-model="form.judul">
                    </div>
    
                    <!-- STEP 2 -->
                    <div v-if="isStep1Valid">
                        <hr>
    
                        <div class="mb-3">
                            <label>No Telp </label>
                            <input class="form-control" placeholder="Masukkan No. Telp" v-model="form.telp">
                        </div>
    
                        <div class="mb-3">
                            <label>Email </label>
                            <input class="form-control" placeholder="Masukkan Email" v-model="form.email">
                        </div>
    
                        <div class="mb-3">
                            <label>Alamat </label>
                            <input class="form-control" placeholder="Masukkan Alamat" v-model="form.alamat">
                        </div>
    
                        <hr>
    
                        <div class="mb-3">
                            <label>Bukti SPP (Maks 2MB dengan format PDF)</label>
                            <input type="file" class="form-control" @change="e=>form.spp=e.target.files[0]">
                        </div>
    
                        <div class="mb-3">
                            <label>Persetujuan Pembimbing (Maks 2MB dengan format PDF)</label>
                            <input type="file" class="form-control" @change="e=>form.persetujuan=e.target.files[0]">
                        </div>
    
                        <div class="mb-3">
                            <label>Pas Foto (Maks 2MB dengan format PDF)</label>
                            <input type="file" class="form-control" @change="e=>form.foto=e.target.files[0]">
                        </div>
    
                        <hr>
    
                        <div class="mb-3">
                            <label>Pembimbing 1 </label>
                            <input class="form-control" v-model="form.pembimbing1">
                        </div>
    
                        <div class="mb-3">
                            <label>Pembimbing 2 </label>
                            <input class="form-control" v-model="form.pembimbing2">
                        </div>
                    </div>
    
                </div>
    
                <!-- Footer -->
                <div class="modal-footer-custom">
                    <button class="btn btn-danger" @click="closeModal">Close</button>
                    <button class="btn btn-warning text-white"
                        :disabled="!isAllValid"
                        @click="submit">
                        Submit
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
    
    const form = ref({
        nama:'', nim:'', type:'', periode:'', prodi:'',
        judul:'', telp:'', email:'', alamat:'',
        spp:null, persetujuan:null, foto:null,
        pembimbing1:'', pembimbing2:''
    })
    
    const isStep1Valid = computed(() =>
        form.value.nama &&
        form.value.nim &&
        form.value.type &&
        form.value.periode &&
        form.value.prodi &&
        form.value.judul
    )
    
    const isAllValid = computed(() =>
        isStep1Valid.value &&
        form.value.telp &&
        form.value.email &&
        form.value.alamat &&
        form.value.spp &&
        form.value.persetujuan &&
        form.value.foto &&
        form.value.pembimbing1 &&
        form.value.pembimbing2
    )
    
    function closeModal(){
        showModal.value=false
    }
    
    function submit(){
        alert('Data valid, siap dikirim ke backend!')
    }
    </script>
    
    <style scoped>
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
        width:520px;
        height:90vh;
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
    