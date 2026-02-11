<template>
    <div class="container-fluid py-4">
        <!-- HEADER -->
        <div class="d-flex justify-content-between align-items-center mb-4">
            <div>
                <h1 class="h3 fw-bold text-dark mb-1">Aktivitas</h1>
                <p class="text-muted mb-0">
                    Daftar aktivitas dan kegiatan mahasiswa
                </p>
            </div>
        </div>

        <!-- CARD ATAS -->
        <div class="row g-4 mb-4">
            <div class="col-md-6">
                <div class="card h-100 border-0 shadow-sm">
                    <div class="card-body p-4">
                        <div class="d-flex align-items-center mb-3">
                            <div
                                class="icon-box bg-primary bg-opacity-10 rounded-3 p-3 me-3"
                            >
                                <i class="fa fa-book text-primary fs-4"></i>
                            </div>
                            <h5 class="mb-0 fw-bold">Aktivitas Komprehensif</h5>
                        </div>
                        <p class="text-muted mb-3">
                            Kelola dan pantau aktivitas ujian komprehensif Anda
                        </p>
                        <Link :href="route('compre')" class="btn btn-primary">
                            Lihat Detail
                        </Link>
                    </div>
                </div>
            </div>

            <div class="col-md-6">
                <div class="card h-100 border-0 shadow-sm">
                    <div class="card-body p-4">
                        <div class="d-flex align-items-center mb-3">
                            <div
                                class="icon-box bg-success bg-opacity-10 rounded-3 p-3 me-3"
                            >
                                <i class="fa fa-list text-success fs-4"></i>
                            </div>
                            <h5 class="mb-0 fw-bold">Aktivitas Lainnya</h5>
                        </div>
                        <p class="text-muted mb-3">
                            Lihat aktivitas akademik lainnya seperti KKN
                        </p>
                        <Link :href="route('kkn')" class="btn btn-success">
                            Lihat Detail
                        </Link>
                    </div>
                </div>
            </div>
        </div>

        <!-- ================== -->
        <!-- TABEL BAWAH -->
        <!-- ================== -->

        <div class="card">
            <div class="card-body">
                <div
                    class="d-flex justify-content-between align-items-center mb-3"
                >
                    <h5 class="fw-bold mb-0">Daftar Aktivitas Mahasiswa</h5>
                    <button
                        class="btn btn-warning text-dark"
                        @click="showModal = true"
                    >
                        Tambah Aktivitas
                    </button>
                </div>

                <div class="table-responsive">
                    <table class="table table-hover">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Nama</th>
                                <th>NIM</th>
                                <th>Jenis Aktivitas</th>
                                <th>Keterangan</th>
                                <th>Status</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr
                                v-for="(item, index) in daftarAktivitas"
                                :key="item.id"
                            >
                                <td>{{ index + 1 }}</td>
                                <td>{{ item.nama }}</td>
                                <td>{{ item.nim }}</td>
                                <td>{{ item.jenis }}</td>
                                <td>{{ item.keterangan }}</td>
                                <td>
                                    <span class="badge bg-warning">
                                        {{ item.status }}
                                    </span>
                                </td>
                                <td>
                                    <Link
                                        :href="route('aktivitasd', item.id)"
                                        class="btn btn-sm btn-warning"
                                    >
                                        <i class="fa fa-pencil"></i>
                                    </Link>
                                </td>
                            </tr>

                            <tr v-if="daftarAktivitas.length === 0">
                                <td colspan="7" class="text-center text-muted">
                                    Belum ada data aktivitas
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <!-- ================== -->
        <!-- MODAL TAMBAH -->
        <!-- ================== -->

        <!-- MODAL TAMBAH AKTIVITAS (STYLE KKN) -->
        <div v-if="showModal" class="modal-backdrop-custom">
            <div class="modal-card">
                <div class="modal-header-custom">
                    <h5 class="fw-bold mb-0">Tambah Aktivitas</h5>
                    <button class="btn-close" @click="closeModal"></button>
                </div>

                <div class="modal-body-custom">
                    <div class="mb-3">
                        <label>Nama Mahasiswa</label>
                        <input
                            class="form-control"
                            v-model="form.nama"
                            disabled
                        />
                    </div>

                    <div class="mb-3">
                        <label>NIM</label>
                        <input
                            class="form-control"
                            v-model="form.nim"
                            disabled
                        />
                    </div>

                    <div class="mb-3">
                        <label>Jenis Aktivitas</label>
                        <select class="form-control" v-model="form.jenis">
                            <option value="">-- Pilih --</option>
                            <option value="KKN">KKN</option>
                            <option value="Magang">Magang</option>
                            <option value="Kompre">Komprehensif</option>
                        </select>
                    </div>

                    <div class="mb-3">
                        <label>Keterangan</label>
                        <input
                            class="form-control"
                            placeholder="Masukkan keterangan aktivitas"
                            v-model="form.keterangan"
                        />
                    </div>
                </div>

                <div class="modal-footer-custom">
                    <button
                        class="btn btn-danger text-white"
                        @click="closeModal"
                    >
                        Close
                    </button>
                    <button
                        class="btn btn-warning text-dark"
                        :disabled="!isFormValid"
                        @click="submitForm"
                    >
                        Submit
                    </button>
                </div>
            </div>
        </div>
    </div>
</template>

<script setup>
import PanelLayout from "@/Layouts/PanelLayout/FinancePanelLayout.vue";
import { ref, computed } from "vue";
import { Link } from "@inertiajs/vue3";

defineOptions({ layout: PanelLayout });

const showModal = ref(false);

const daftarAktivitas = ref([
    {
        id: 1,
        nama: "Admin",
        nim: "123456789",
        jenis: "Komperehensif",
        keterangan: "Aktivitas Tugas",
        status: "Pending",
    },
]);

const form = ref({
    nama: "Admin",
    nim: "123456789",
    jenis: "",
    keterangan: "",
});

const isFormValid = computed(() => {
    return form.value.jenis !== "" && form.value.keterangan.trim() !== "";
});

function closeModal() {
    showModal.value = false;
}

function submitForm() {
    daftarAktivitas.value.push({
        id: Date.now(),
        nama: form.value.nama,
        nim: form.value.nim,
        jenis: form.value.jenis,
        keterangan: form.value.keterangan,
        status: "Pending",
    });

    form.value = {
        nama: "Admin",
        nim: "123456789",
        jenis: "",
        keterangan: "",
    };

    showModal.value = false;
}
</script>

<style scoped>
.card {
    border-radius: 12px;
}

.table th {
    background-color: #f8f9fa;
    font-weight: 600;
}

.icon-box {
    width: 56px;
    height: 56px;
    display: flex;
    align-items: center;
    justify-content: center;
}

.modal-backdrop-custom {
    position: fixed;
    inset: 0;
    background: rgba(0, 0, 0, 0.45);
    display: flex;
    justify-content: center;
    align-items: center;
    z-index: 9999;
}

.modal-card {
    width: 520px;
    max-height: 90vh;
    background: white;
    border-radius: 12px;
    display: flex;
    flex-direction: column;
}

.modal-header-custom {
    padding: 16px 20px;
    border-bottom: 1px solid #e5e7eb;
    display: flex;
    justify-content: space-between;
    align-items: center;
}

.modal-body-custom {
    flex: 1;
    padding: 18px 20px;
    overflow-y: auto;
}

.modal-footer-custom {
    padding: 16px 20px;
    border-top: 1px solid #e5e7eb;
    display: flex;
    justify-content: flex-end;
    gap: 10px;
}
</style>
