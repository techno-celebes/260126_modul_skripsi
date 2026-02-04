<template>
<div class="container-fluid py-4" style="padding-left: 0 !important; padding-right: 0 !important;">
    <div class="d-flex justify-content-between align-items-center mb-4" style="padding-left: 15px; padding-right: 15px;">
        <div>
            <h1 class="h3 fw-bold text-dark mb-1">Detail KKN</h1>
            <p class="text-muted mb-0">{{ kknData.nama }}</p>
        </div>
        <button class="btn btn-secondary" @click="$inertia.visit('/kkn')">
            Kembali
        </button>
    </div>

    <div class="row g-3" style="margin-left: 0; margin-right: 0; padding-left: 15px; padding-right: 15px;">
        <div class="col-md-3">
            <div class="card">
                <div class="card-body p-2">
                    <button
                        class="btn w-100 mb-2 text-dark"
                        style="text-align: left; padding-left: 8px;"
                        :class="activeTab === 'detail' ? 'btn-warning' : 'btn-outline-warning'"
                        @click="activeTab = 'detail'">
                        Detail KKN
                    </button>
                    <button
                        class="btn w-100 mb-2 text-dark"
                        style="text-align: left; padding-left: 8px;"
                        :class="activeTab === 'aktivitas' ? 'btn-warning' : 'btn-outline-warning'"
                        @click="activeTab = 'aktivitas'">
                        Upload Aktivitas
                    </button>
                    <button
                        class="btn w-100 text-dark"
                        style="text-align: left; padding-left: 8px;"
                        :class="activeTab === 'penilaian' ? 'btn-warning' : 'btn-outline-warning'"
                        @click="activeTab = 'penilaian'">
                        Penilaian
                    </button>
                </div>
            </div>
        </div>

        <div class="col-md-9">
            <div class="card">
                <div class="card-body">
                    <div v-if="activeTab === 'detail'">
                        <h5 class="fw-bold mb-3">Detail KKN</h5>
                        <div class="mb-3">
                            <label class="fw-bold text-dark">Nama</label>
                            <p class="text-dark">{{ kknData.nama }}</p>
                        </div>
                        <div class="mb-3">
                            <label class="fw-bold text-dark">NIM</label>
                            <p class="text-dark">{{ kknData.nim }}</p>
                        </div>
                        <div class="mb-3">
                            <label class="fw-bold text-dark">Alamat KKN</label>
                            <p class="text-dark">{{ kknData.alamat }}</p>
                        </div>
                        <div class="mb-3">
                            <label class="fw-bold text-dark">Penanggung Jawab</label>
                            <p class="text-dark">{{ kknData.penanggung_jawab }}</p>
                        </div>
                        <div class="mb-3">
                            <label class="fw-bold text-dark">Durasi</label>
                            <p class="text-dark">{{ kknData.durasi }}</p>
                        </div>
                        <div class="mb-3">
                            <label class="fw-bold text-dark">Status</label>
                            <p><span class="badge bg-warning">{{ kknData.status }}</span></p>
                        </div>
                    </div>

                    <div v-if="activeTab === 'aktivitas'">
                        <h5 class="fw-bold mb-3">Upload Aktivitas</h5>
                        <div class="mb-3">
                            <label>Judul Aktivitas</label>
                            <input class="form-control" placeholder="Masukkan Judul" v-model="aktivitasForm.judul">
                        </div>
                        <div class="mb-3">
                            <label>Deskripsi</label>
                            <textarea class="form-control" rows="4" placeholder="Masukkan Deskripsi" v-model="aktivitasForm.deskripsi"></textarea>
                        </div>
                        <div class="mb-3">
                            <label>Tanggal</label>
                            <input type="date" class="form-control" v-model="aktivitasForm.tanggal">
                        </div>
                        <div class="mb-3">
                            <label>Dokumentasi (Maks 2MB dengan format JPG/PNG)</label>
                            <input type="file" class="form-control" @change="e=>aktivitasForm.file=e.target.files[0]" accept="image/*">
                        </div>
                        <button class="btn btn-warning text-dark" :disabled="!isAktivitasValid" @click="uploadAktivitas">Upload Aktivitas</button>
                    </div>

                    <div v-if="activeTab === 'penilaian'">
                        <h5 class="fw-bold mb-3">Penilaian</h5>
                        <div class="alert alert-info">
                            Penilaian akan ditampilkan setelah dosen pembimbing memberikan nilai.
                        </div>
                        <div class="mb-3">
                            <label class="fw-bold">Nilai Akhir</label>
                            <p class="fs-4">-</p>
                        </div>
                        <div class="mb-3">
                            <label class="fw-bold">Catatan Pembimbing</label>
                            <p>Belum ada catatan</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
</template>

<script setup>
import { ref, computed } from 'vue'
import PanelLayout from '@/Layouts/PanelLayout/FinancePanelLayout.vue'

defineOptions({ layout: PanelLayout })

const props = defineProps({
    kknData: Object
})

const activeTab = ref('detail')

const aktivitasForm = ref({
    judul: '',
    deskripsi: '',
    tanggal: '',
    file: null
})

const isAktivitasValid = computed(() =>
    aktivitasForm.value.judul &&
    aktivitasForm.value.deskripsi &&
    aktivitasForm.value.tanggal &&
    aktivitasForm.value.file
)

function uploadAktivitas(){
    alert('Aktivitas berhasil diupload!')
    aktivitasForm.value = {
        judul: '',
        deskripsi: '',
        tanggal: '',
        file: null
    }
}
</script>

<style scoped>
.card{
    border-radius:12px;
}

input, select, textarea{
    border-radius:6px;
    font-size:14px;
}
</style>
