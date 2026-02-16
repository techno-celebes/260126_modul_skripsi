<template>
<div class="container-fluid py-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h1 class="h3 fw-bold text-dark mb-1">Kelola Mahasiswa</h1>
            <p class="text-muted mb-0">Daftar semua mahasiswa</p>
        </div>
    </div>

    <div class="card">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-hover">
                    <thead class="table-light">
                        <tr>
                            <th>No</th>
                            <th>Nama</th>
                            <th>NIM</th>
                            <th>Email</th>
                            <th>Aktivitas</th>
                            <th>Permintaan</th>
                            <th>KKN</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr v-for="(mhs, index) in mahasiswa" :key="mhs.id">
                            <td>{{ index + 1 }}</td>
                            <td>{{ mhs.name }}</td>
                            <td>{{ mhs.nim }}</td>
                            <td>{{ mhs.email }}</td>
                            <td><span class="badge bg-info">{{ mhs.aktivitas_count }}</span></td>
                            <td><span class="badge bg-warning text-dark">{{ mhs.permintaan_count }}</span></td>
                            <td><span class="badge bg-success">{{ mhs.kkn_count }}</span></td>
                        </tr>
                        <tr v-if="mahasiswa.length === 0">
                            <td colspan="7" class="text-center text-muted">Belum ada data mahasiswa</td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
</template>

<script setup>
import PanelLayout from '@/Layouts/PanelLayout/FinancePanelLayout.vue'

defineOptions({ layout: PanelLayout })

defineProps({
    mahasiswa: Array
})
</script>

<style scoped>
.card {
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
