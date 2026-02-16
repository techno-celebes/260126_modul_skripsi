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

        <!-- ================== -->
        <!-- TABEL AKTIVITAS -->
        <!-- ================== -->

        <div class="card">
            <div class="card-body">
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
                                    <span class="badge" :class="getStatusBadgeClass(item.status)">
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
import { Link, router, usePage } from "@inertiajs/vue3";

defineOptions({ layout: PanelLayout });

const props = defineProps({
    daftarAktivitas: {
        type: Array,
        default: () => []
    }
});

const page = usePage();
const showModal = ref(false);

const form = ref({
    nama: page.props.auth?.user?.name || "Admin",
    nim: page.props.auth?.user?.nim || "123456789",
    jenis: "",
    keterangan: "",
});

const isFormValid = computed(() => {
    return form.value.jenis !== "" && form.value.keterangan.trim() !== "";
});

function closeModal() {
    showModal.value = false;
    form.value.jenis = "";
    form.value.keterangan = "";
}

function submitForm() {
    router.post(route('aktivitas.store'), form.value, {
        onSuccess: () => {
            closeModal();
        }
    });
}

function getStatusBadgeClass(status) {
    const map = {
        'Pending': 'bg-warning text-dark',
        'Menunggu': 'bg-warning text-dark',
        'Disetujui': 'bg-success text-white',
        'Divalidasi': 'bg-success text-white',
        'Ditolak': 'bg-danger text-white',
        'Selesai': 'bg-primary text-white',
        'Proses': 'bg-info text-white'
    }
    return map[status] || 'bg-secondary text-white'
}
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
