<template>
    <div class="container-fluid py-4">
        <!-- Header -->
        <div class="d-flex justify-content-between align-items-center mb-4">
            <div>
                <h1 class="h3 fw-bold text-dark mb-1">Kuliah Kerja Nyata (KKN)</h1>
                <br>
                <br>
                <from>
            <label>
                Nama Lengkap: <br>
                <input type="text" placeholder="Masukkan Nama">
            </label>
            <br>
            <br>
            <label>
                NIM: <br>
                <input type="text" placeholder="Masukkan Nim">
            </label>
            <br>
            <br>
            <label>
                Fakultas: <br>
                <input type="text" placeholder="Masukkan Nama Fakultas">
            </label>
            <br>
            <br>
            <label>
                Prodi: <br>
                <input type="text" placeholder="Masukkan Nama Prodi">
            </label>
            <br>
            <br>
            <label>
                Penempatan: <br>
                <select>
                    <option>Belum Ada</option>
                    <option>Sidera</option>
                    <option>Bora</option>
                    <option>Tinggede</option>
                    <option>Binangga</option>
                    <option>Kulawi</option>
                </select>
            </label>
            <br>
            <br>
            <input type="submit">
                </from>
            </div>
        </div>
    </div>
</template>

<script setup>
    import PanelLayout from '@/Layouts/PanelLayout/FinancePanelLayout.vue'

    defineOptions({ layout: PanelLayout })
    const props = defineProps({
        auth: Object
    });

</script>

<style scoped>
.card {
    border-radius: 12px;
}

.nav-tabs-custom .nav-link {
    border: none;
    color: #6c757d;
    font-weight: 500;
    padding: 0.75rem 1rem;
    border-radius: 8px;
    margin-right: 0.5rem;
}

.nav-tabs-custom .nav-link.active {
    background-color: #e7f1ff;
    color: #0d6efd;
}

.chart-container {
    height: 250px;
    position: relative;
}

.list-group-item:hover {
    background-color: #f8f9fa;
}
</style>
