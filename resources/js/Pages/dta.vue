<template>
    <div class="container-fluid py-4">
        <div class="row">

            <!-- SIDEBAR -->
            <div class="col-md-3">
                <div class="card sidebar">
                    <ul class="list-group list-group-flush">
                        <li class="list-group-item" :class="{active: activeMenu==='data'}" @click="activeMenu='data'">
                            Data Tugas Akhir
                        </li>
                        <li class="list-group-item" :class="{active: activeMenu==='bimbingan'}" @click="activeMenu='bimbingan'">
                            Bimbingan Tugas Akhir
                        </li>
                        <li class="list-group-item" :class="{active: activeMenu==='syarat'}" @click="activeMenu='syarat'">
                            Syarat Ujian
                        </li>
                        <li class="list-group-item" :class="{active: activeMenu==='jadwal'}" @click="activeMenu='jadwal'">
                            Jadwal Ujian
                        </li>
                        <li class="list-group-item" :class="{active: activeMenu==='nilai'}" @click="activeMenu='nilai'">
                            Nilai Ujian
                        </li>
                    </ul>
                </div>
            </div>

            <!-- KONTEN -->
            <div class="col-md-9">
                <div class="d-flex justify-content-between mb-3">
                    <h4 class="fw-bold">{{ title }}</h4>
                    <button class="btn btn-primary" @click="back">← Kembali</button>
                </div>

                <div class="card content-card">
                    <div class="card-body">

<!-- ================== DATA TA ================== -->
<div v-if="activeMenu==='data'" class="ta-wrapper">

    <div class="row">
        <!-- KIRI -->
        <div class="col-md-6">
            <div class="ta-row">
                <div class="ta-label">Nama</div>
                <div class="ta-value">{{ data.nama ?? '-' }}</div>
            </div>
            <div class="ta-row">
                <div class="ta-label">NIM</div>
                <div class="ta-value">{{ data.nim ?? '-' }}</div>
            </div>
            <div class="ta-row">
                <div class="ta-label">Fakultas</div>
                <div class="ta-value">{{ data.fakultas ?? 'For Temporary' }}</div>
            </div>
            <div class="ta-row">
                <div class="ta-label">Jurusan</div>
                <div class="ta-value">{{ data.prodi ?? '-' }}</div>
            </div>
        </div>

        <!-- KANAN -->
        <div class="col-md-6">
            <div class="ta-row">
                <div class="ta-label">Topik</div>
                <div class="ta-value">{{ data.topik ?? '-' }}</div>
            </div>
            <div class="ta-row">
                <div class="ta-label">Tanggal Penginputan</div>
                <div class="ta-value">{{ tanggalFix }}</div>
            </div>
            <div class="ta-row">
                <div class="ta-label">Judul</div>
                <div class="ta-value ta-long">{{ data.judul ?? '-' }}</div>
            </div>
            <div class="ta-row">
                <div class="ta-label">Status</div>
                <div class="ta-value">{{ data.status ?? 'Pending' }}</div>
            </div>
        </div>
    </div>

    <!-- ABSTRAK -->
    <div class="ta-row mt-3">
        <div class="ta-label">Abstrak</div>
        <div class="ta-value ta-long">
            {{ data.abstrak ?? '-' }}
        </div>
    </div>

</div>
<!-- ================== END DATA TA ================== -->

<!-- BIMBINGAN -->
<div v-if="activeMenu==='bimbingan'">
    <h5>Dosen Pembimbing</h5>
    <table class="table table-bordered mt-2">
        <thead class="table-purple">
            <tr>
                <th>No</th>
                <th>Nama Dosen</th>
                <th>Urutan</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td>1</td>
                <td>Muhammad Syafaat</td>
                <td>Pembimbing 1</td>
            </tr>
            <tr>
                <td>2</td>
                <td>Jafar Sadik</td>
                <td>Pembimbing 2</td>
            </tr>
        </tbody>
    </table>
</div>

<!-- SYARAT -->
<div v-if="activeMenu==='syarat'">
    <ul>
        <li>Upload Proposal</li>
        <li>Minimal 120 SKS</li>
        <li>Lunas UKT</li>
    </ul>
</div>

<!-- JADWAL -->
<div v-if="activeMenu==='jadwal'">
    <p>Belum ada jadwal ujian.</p>
</div>

<!-- NILAI -->
<div v-if="activeMenu==='nilai'">
    <p>Nilai belum tersedia.</p>
</div>

                    </div>
                </div>
            </div>

        </div>
    </div>
</template>

<script setup>
import { ref, onMounted, computed } from 'vue'
import PanelLayout from '@/Layouts/PanelLayout/FinancePanelLayout.vue'
defineOptions({ layout: PanelLayout })

const activeMenu = ref('data')
const data = ref({})

onMounted(() => {
    const saved = localStorage.getItem('detailPermintaan')
    data.value = saved ? JSON.parse(saved) : {}
})

const title = computed(() => {
    if(activeMenu.value==='data') return 'Data Tugas Akhir'
    if(activeMenu.value==='bimbingan') return 'Bimbingan Tugas Akhir'
    if(activeMenu.value==='syarat') return 'Syarat Ujian'
    if(activeMenu.value==='jadwal') return 'Jadwal Ujian'
    if(activeMenu.value==='nilai') return 'Nilai Ujian'
})

// ===== FORMAT TANGGAL INDONESIA =====
function formatTanggal(date){
    const bulan = [
        'Januari','Februari','Maret','April','Mei','Juni',
        'Juli','Agustus','September','Oktober','November','Desember'
    ]
    const d = new Date(date)
    return `${d.getDate()} ${bulan[d.getMonth()]} ${d.getFullYear()}`
}

// Prioritas tanggal:
// 1. tanggal_penginputan
// 2. created_at
// 3. hari ini
const tanggalFix = computed(() => {
    const raw = 
        data.value.tanggal_penginputan ||
        data.value.created_at ||
        new Date()
    return formatTanggal(raw)
})

function back(){
    window.history.back()
}
</script>

<style scoped>
.sidebar{
    border-radius:12px;
    overflow:hidden;
}

.sidebar .list-group-item{
    border:none;
    padding:14px 18px;
    cursor:pointer;
}

.sidebar .active{
    background:#9a6218;
    color:white;
    font-weight:bold;
}

.content-card{
    border-radius:12px;
    min-height:300px;
}

/* ====== DATA TA ====== */
.ta-wrapper{
    padding:10px;
}

.ta-row{
    display:flex;
    border-bottom:1px solid #eee;
    padding:12px 0;
}

.ta-label{
    width:220px;
    font-weight:600;
    color:#333;
}

.ta-value{
    flex:1;
    color:#555;
}

.ta-long{
    line-height:1.7;
}

/* TABLE */
.table-purple{
    background:#5a189a;
    color:white;
}
</style>
