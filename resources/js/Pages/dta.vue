<template>
    <div class="container-fluid py-4">
        <div class="row">
            <!-- SIDEBAR -->
            <div class="col-md-3">
                <div class="card sidebar">
                    <ul class="list-group list-group-flush">
                        <li
                            class="list-group-item"
                            :class="{ active: activeMenu === 'data' }"
                            @click="activeMenu = 'data'"
                        >
                            Data Tugas Akhir
                        </li>

                        <div class="divider"></div>

                        <li
                            class="list-group-item"
                            :class="{ active: activeMenu === 'bimbingan' }"
                            @click="activeMenu = 'bimbingan'"
                        >
                            Bimbingan Tugas Akhir
                        </li>

                        <div class="divider"></div>

                        <li
                            class="list-group-item"
                            :class="{ active: activeMenu === 'syarat' }"
                            @click="activeMenu = 'syarat'"
                        >
                            Syarat Ujian
                        </li>

                        <div class="divider"></div>

                        <li
                            class="list-group-item"
                            :class="{ active: activeMenu === 'jadwal' }"
                            @click="activeMenu = 'jadwal'"
                        >
                            Jadwal Ujian
                        </li>

                        <div class="divider"></div>

                        <li
                            class="list-group-item"
                            :class="{ active: activeMenu === 'nilai' }"
                            @click="activeMenu = 'nilai'"
                        >
                            Nilai Ujian
                        </li>
                    </ul>
                </div>
            </div>

            <!-- KONTEN -->
            <div class="col-md-9">
                <div class="d-flex justify-content-between mb-3">
                    <h4 class="fw-bold">{{ title }}</h4>
                    <button class="btn btn-success" @click="back">
                        ← Kembali
                    </button>
                </div>

                <div class="card content-card">
                    <div class="card-body">
                        <!-- DATA -->
                        <div v-if="activeMenu === 'data'" class="ta-wrapper">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="ta-row">
                                        <div class="ta-label">Nama</div>
                                        <div class="ta-value">
                                            {{ data.nama ?? "-" }}
                                        </div>
                                    </div>
                                    <div class="ta-row">
                                        <div class="ta-label">NIM</div>
                                        <div class="ta-value">
                                            {{ data.nim ?? "-" }}
                                        </div>
                                    </div>
                                    <div class="ta-row">
                                        <div class="ta-label">Fakultas</div>
                                        <div class="ta-value">
                                            {{
                                                data.fakultas ?? "For Temporary"
                                            }}
                                        </div>
                                    </div>
                                    <div class="ta-row">
                                        <div class="ta-label">Jurusan</div>
                                        <div class="ta-value">
                                            {{ data.prodi ?? "-" }}
                                        </div>
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="ta-row">
                                        <div class="ta-label">Topik</div>
                                        <div class="ta-value">
                                            {{ data.topik ?? "-" }}
                                        </div>
                                    </div>
                                    <div class="ta-row">
                                        <div class="ta-label">Tanggal</div>
                                        <div class="ta-value">
                                            {{ tanggalFix }}
                                        </div>
                                    </div>
                                    <div class="ta-row">
                                        <div class="ta-label">Judul</div>
                                        <div class="ta-value ta-long">
                                            {{ data.judul ?? "-" }}
                                        </div>
                                    </div>
                                    <div class="ta-row">
                                        <div class="ta-label">Status</div>
                                        <div class="ta-value">
                                            {{ data.status ?? "Pending" }}
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="ta-row mt-3">
                                <div class="ta-label">Abstrak</div>
                                <div class="ta-value ta-long">
                                    {{ data.abstrak ?? "-" }}
                                </div>
                            </div>
                        </div>

                        <!-- BIMBINGAN -->
                        <div v-if="activeMenu === 'bimbingan'">
                            <!-- DATA RINGKAS -->
                            <div class="ta-wrapper mb-4">
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="ta-row">
                                            <div class="ta-label">Nama</div>
                                            <div class="ta-value">
                                                {{ data.nama ?? "-" }}
                                            </div>
                                        </div>
                                        <div class="ta-row">
                                            <div class="ta-label">NIM</div>
                                            <div class="ta-value">
                                                {{ data.nim ?? "-" }}
                                            </div>
                                        </div>
                                        <div class="ta-row">
                                            <div class="ta-label">Fakultas</div>
                                            <div class="ta-value">
                                                {{
                                                    data.fakultas ??
                                                    "For Temporary"
                                                }}
                                            </div>
                                        </div>
                                        <div class="ta-row">
                                            <div class="ta-label">Jurusan</div>
                                            <div class="ta-value">
                                                {{ data.prodi ?? "-" }}
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-md-6">
                                        <div class="ta-row">
                                            <div class="ta-label">Topik</div>
                                            <div class="ta-value">
                                                {{ data.topik ?? "-" }}
                                            </div>
                                        </div>
                                        <div class="ta-row">
                                            <div class="ta-label">Tanggal</div>
                                            <div class="ta-value">
                                                {{ tanggalFix }}
                                            </div>
                                        </div>
                                        <div class="ta-row">
                                            <div class="ta-label">Judul</div>
                                            <div class="ta-value ta-long">
                                                {{ data.judul ?? "-" }}
                                            </div>
                                        </div>
                                        <div class="ta-row">
                                            <div class="ta-label">Status</div>
                                            <div class="ta-value">
                                                {{ data.status ?? "Pending" }}
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- TOMBOL TAMBAH BIMBINGAN (POSISI SESUAI GAMBAR) -->
                            <div class="d-flex justify-content-end mb-4">
                                <button class="btn btn-primary">
                                    + Tambah Bimbingan
                                </button>
                            </div>

                            <!-- STATUS DOSEN -->
                            <h5 class="fw-bold text-purple mb-3">
                                Status Bimbingan Dosen Pembimbing
                            </h5>

                            <div class="mb-3">
                                <div
                                    class="d-flex align-items-center gap-2 mb-2"
                                >
                                    <b>Muhammad Syafaat, S.E., M.S.A., Ak.</b>
                                    <span class="badge bg-warning text-dark">
                                        Masih proses pembimbingan
                                    </span>
                                </div>
                                <div class="d-flex align-items-center gap-2">
                                    <b>Jafar Sadik, S.Kom., M.T.I.</b>
                                    <span class="badge bg-warning text-dark">
                                        Masih proses pembimbingan
                                    </span>
                                </div>
                            </div>

                            <!-- CATATAN -->
                            <h5 class="fw-bold text-purple mb-3 mt-4">
                                Catatan Pembimbingan
                            </h5>

                            <table class="table table-bordered">
                                <thead
                                    style="background: #5b0892; color: white"
                                >
                                    <tr>
                                        <th>No</th>
                                        <th>Judul</th>
                                        <th>Catatan</th>
                                        <th>Tanggal Bimbingan</th>
                                        <th>Status</th>
                                        <th>Dosen</th>
                                        <th>Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td>1</td>
                                        <td>Deskripsi penelitian dikurangi</td>
                                        <td>Tambah pembahasan penelitian</td>
                                        <td>23 Juni 2025</td>
                                        <td>Masih perlu bimbingan</td>
                                        <td>Muhammad Syafaat</td>
                                        <td>
                                            <button
                                                class="btn btn-sm btn-primary"
                                            >
                                                ✏️
                                            </button>
                                            <button
                                                class="btn btn-sm btn-danger"
                                            >
                                                🗑️
                                            </button>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>2</td>
                                        <td>Acc</td>
                                        <td>Acc</td>
                                        <td>01 Juli 2025</td>
                                        <td>Masih perlu bimbingan</td>
                                        <td>Jafar Sadik</td>
                                        <td>
                                            <button
                                                class="btn btn-sm btn-primary"
                                            >
                                                ✏️
                                            </button>
                                            <button
                                                class="btn btn-sm btn-danger"
                                            >
                                                🗑️
                                            </button>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>

                        <div v-if="activeMenu === 'syarat'">
                            <!-- SYARAT UJIAN -->
                            <div class="ta-wrapper mb-4">
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="ta-row">
                                            <div class="ta-label">Nama</div>
                                            <div class="ta-value">
                                                {{ data.nama ?? "-" }}
                                            </div>
                                        </div>
                                        <div class="ta-row">
                                            <div class="ta-label">NIM</div>
                                            <div class="ta-value">
                                                {{ data.nim ?? "-" }}
                                            </div>
                                        </div>
                                        <div class="ta-row">
                                            <div class="ta-label">
                                                Tanggal Pengajuan
                                            </div>
                                            <div class="ta-value">
                                                {{ tanggalFix }}
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-md-6">
                                        <div class="ta-row">
                                            <div class="ta-label">
                                                Tahun Kurikulum
                                            </div>
                                            <div class="ta-value">2020</div>
                                        </div>
                                        <div class="ta-row">
                                            <div class="ta-label">
                                                Program Studi
                                            </div>
                                            <div class="ta-value">
                                                {{ data.prodi ?? "-" }}
                                            </div>
                                        </div>
                                        <div class="ta-row">
                                            <div class="ta-label">Judul</div>
                                            <div class="ta-value ta-long">
                                                {{ data.judul ?? "-" }}
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- TOMBOL EDIT -->
                            <div class="d-flex justify-content-end mb-3">
                                <button class="btn btn-primary">✏️ Edit</button>
                            </div>

                            <!-- TABEL SYARAT -->
                            <table class="table table-bordered">
                                <thead class="thead-purple">
                                    <tr>
                                        <th>No</th>
                                        <th>Syarat Ujian</th>
                                        <th>Wajib</th>
                                        <th>Terpenuhi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td>1</td>
                                        <td>Kartu Bimbingan</td>
                                        <td>Ya</td>
                                        <td>
                                            <span class="badge bg-success"
                                                >Sudah</span
                                            >
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>2</td>
                                        <td>Transkrip Nilai</td>
                                        <td>Ya</td>
                                        <td>
                                            <span class="badge bg-danger"
                                                >Belum</span
                                            >
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>3</td>
                                        <td>Bukti Pembayaran</td>
                                        <td>Ya</td>
                                        <td>
                                            <span class="badge bg-success"
                                                >Sudah</span
                                            >
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>

                        <div v-if="activeMenu === 'jadwal'">
                            <p>JADWAL</p>
                        </div>
                    <div v-if="activeMenu === 'nilai'">
                        <p>Konten nilai...</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script setup>
import { ref, onMounted, computed } from "vue";
import PanelLayout from "@/Layouts/PanelLayout/FinancePanelLayout.vue";
defineOptions({ layout: PanelLayout });

const activeMenu = ref("data");
const data = ref({});

onMounted(() => {
    const saved = localStorage.getItem("detailPermintaan");
    data.value = saved ? JSON.parse(saved) : {};
});

const title = computed(() => {
    if (activeMenu.value === "data") return "Data Tugas Akhir";
    if (activeMenu.value === "bimbingan") return "Bimbingan Tugas Akhir";
    if (activeMenu.value === "syarat") return "Syarat Ujian";
    if (activeMenu.value === "jadwal") return "Jadwal Ujian";
    if (activeMenu.value === "nilai") return "Nilai Ujian";
});

function formatTanggal(date) {
    const bulan = [
        "Januari",
        "Februari",
        "Maret",
        "April",
        "Mei",
        "Juni",
        "Juli",
        "Agustus",
        "September",
        "Oktober",
        "November",
        "Desember",
    ];
    const d = new Date(date);
    return `${d.getDate()} ${bulan[d.getMonth()]} ${d.getFullYear()}`;
}

const tanggalFix = computed(() => {
    return formatTanggal(data.value.created_at || new Date());
});

function back() {
    window.history.back();
}
</script>

<style scoped>
.sidebar {
    border-radius: 16px;
    overflow: hidden;
    box-shadow: 0 6px 18px rgba(0, 0, 0, 0.08);
    background: white;
}

.sidebar .list-group {
    padding: 10px;
}

.sidebar .list-group-item {
    border: none;
    border-radius: 12px;
    padding: 12px 16px;
    cursor: pointer;
    margin-bottom: 10px;
    font-weight: 500;
    color: #2d3748;
    background: #f1f5f9;
    transition: 0.25s;
}

.sidebar .list-group-item:hover {
    background: #e6f4ee;
}

.sidebar .active {
    background: #2f855a !important;
    color: white !important;
    font-weight: 600;
    box-shadow: 0 4px 10px rgba(47, 133, 90, 0.35);
}

.content-card {
    border-radius: 14px;
    box-shadow: 0 4px 12px rgba(0, 0, 0, 0.05);
}

.ta-row {
    display: flex;
    border-bottom: 1px solid #eee;
    padding: 12px 0;
}

.ta-label {
    width: 200px;
    font-weight: 600;
}

.ta-value {
    flex: 1;
}

.ta-row:hover {
    background: #f8fdfb;
}

.text-purple {
    color: #5b0892;
}
</style>
