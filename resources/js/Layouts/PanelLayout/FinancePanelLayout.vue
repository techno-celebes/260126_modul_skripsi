<template>
    <OneTimeLogoSplash />
    <PanelLayout :app_tagline="app_tagline">
        <!-- Sidebar khusus Apps -->
        <template #sidebar>
            <div class="sidebar offcanvas offcanvas-start" tabindex="-1" id="offcanvasNavbar">
                <div class="offcanvas-header border-bottom">
                    <span class="offcanvas-title">
                        <div class="d-flex caption-2">
                            <div class="logo shadow">
                                <img src="/assets/img/logo-transparant.png" alt="" />
                            </div>
                            <div class="title">
                                <h5>Sistem Informasi Akademik Kampus - Admin</h5>
                                <h4>Universitas Islam Negeri Datokarama Palu</h4>
                            </div>
                        </div>
                    </span>
                    <button type="button" class="btn-close" data-bs-dismiss="offcanvas"></button>
                </div>

                <div class="offcanvas-body">
                    <!-- Beranda -->
                    <div class="dropdown-s">
                        <Link :href="route('dashboard')" class="dropdown-toggle-s">
                            <i class="fa fa-home"></i> Beranda
                        </Link>
                    </div>

                    <!-- Menu untuk MAHASISWA saja -->
                    <template v-if="$page.props.auth.user.role === 'mahasiswa'">
                        <!-- Aktivitas -->
                        <div class="dropdown-s">
                            <Link :href="route('aktivitas')" class="dropdown-toggle-s">
                                <i class="fa fa-calendar"></i> Aktivitas
                            </Link>
                        </div>

                        <!-- Nilai -->
                        <div class="dropdown-s">
                            <Link :href="route('nilai')" class="dropdown-toggle-s">
                                <i class="fa fa-star"></i> Nilai Saya
                            </Link>
                        </div>

                        <!-- Magang/KKN -->
                        <div class="dropdown-s submenu-magang">
                            <a class="dropdown-toggle-s" @click.stop="toggleDropdown('magang')">
                                <i class="fa fa-briefcase"></i> Magang & KKN
                                <i class="ml-2 bi" :class="activeDropdown === 'magang' ? 'bi-caret-up-fill' : 'bi-caret-down-fill'"></i>
                            </a>
                            <div class="dropdown-menu-s" :class="{ 'show': activeDropdown === 'magang' }">
                                <Link :href="route('kkn')" class="span-title-menu not-default-size">KKN</Link>
                                <hr />
                            </div>
                        </div>
                        
                        <!-- Permintaan Akademik -->
                        <div class="dropdown-s submenu-laporan">
                            <Link href="/tugasakhir" class="dropdown-toggle-s">
                                <i class="fa fa-graduation-cap"></i> Permintaan Akademik
                            </Link>
                        </div>
                    </template>

                    <!-- Menu untuk ADMIN saja -->
                    <template v-if="$page.props.auth.user.role === 'admin'">
                        <!-- Kelola Mahasiswa -->
                        <div class="dropdown-s">
                            <Link :href="route('admin.mahasiswa')" class="dropdown-toggle-s">
                                <i class="fa fa-users"></i> Kelola Mahasiswa
                            </Link>
                        </div>

                        <!-- Validasi Permintaan -->
                        <div class="dropdown-s">
                            <Link :href="route('admin.validasi')" class="dropdown-toggle-s">
                                <i class="fa fa-check-square"></i> Validasi Permintaan
                            </Link>
                        </div>

                        <!-- Penilaian -->
                        <div class="dropdown-s">
                            <Link :href="route('admin.penilaian')" class="dropdown-toggle-s">
                                <i class="fa fa-star"></i> Penilaian
                            </Link>
                        </div>

                        <!-- Laporan -->
                        <div class="dropdown-s">
                            <Link :href="route('admin.laporan')" class="dropdown-toggle-s">
                                <i class="fa fa-file-text"></i> Laporan
                            </Link>
                        </div>
                    </template>
                </div>
            </div>
        </template>

        <!-- Konten halaman -->
        <slot />
    </PanelLayout>
</template>

<script setup>
    import '../../../css/master.css'
    import { Link, usePage } from '@inertiajs/vue3';
    import PanelLayout from "@/Layouts/PanelLayout.vue";
    import OneTimeLogoSplash from '@/Components/OneTimeLogoSplash.vue';
    import { ref, provide, onMounted, onBeforeUnmount, watch } from 'vue'

    const activeDropdown = ref(null)
    const activeSubDropdown = ref(null)
    const mode = ref("normal")
    const page = usePage();
    const props = defineProps({
        app_tagline: String,
    });

    const toggleDropdown = (dropdownName) => {
        if (activeDropdown.value === dropdownName) {
            activeDropdown.value = null;
            activeSubDropdown.value = null; // Reset subdropdown juga
        } else {
            activeDropdown.value = dropdownName;
            activeSubDropdown.value = null; // Reset subdropdown saat pindah menu utama
        }
    }

    const toggleSubDropdown = (subDropdownName) => {
        if (activeSubDropdown.value === subDropdownName) {
            activeSubDropdown.value = null;
        } else {
            activeSubDropdown.value = subDropdownName;
        }
    }

    const setMode = (newMode) => {
        mode.value = newMode
    }

    // Fungsi untuk menutup dropdown ketika klik di luar
    const handleClickOutside = (event) => {
        if (!event.target.closest('.dropdown-s')) {
            activeDropdown.value = null;
            activeSubDropdown.value = null;
        }
    }

    watch(() => page.url, () => {
        activeDropdown.value = null;
        activeSubDropdown.value = null;
    });

    onMounted(() => {
        document.addEventListener('click', handleClickOutside);
    })

    onBeforeUnmount(() => {
        document.removeEventListener('click', handleClickOutside);
    })

    provide('layoutMode', mode)
    provide('setLayoutMode', setMode)
</script>

<style scoped>
/* Base Nav Styles */

.nav-link {
    padding: 1rem 1.25rem;
    font-weight: 500;
    display: flex;
    align-items: center;
    transition: all 0.2s ease;
    border: none;
    background: none;
    width: 100%;
    text-align: left;
}

/* Dropdown utama */
.dropdown-menu-s {
    max-height: 0;
    overflow: hidden;
    transition: max-height 0.4s ease, opacity 0.4s ease, transform 0.4s ease;
    opacity: 0;
    transform: translateY(-10px);
    padding-left: 0;
}

.dropdown-menu-s.show {
    max-height: 800px; /* Tinggi lebih besar untuk nested content */
    opacity: 1;
    transform: translateY(0);
}

/* Submenu (tingkat 2) */
.dropdown-submenu {
    position: relative;
}

.dropdown-menu-sub {
    max-height: 0;
    overflow: hidden;
    transition: max-height 0.3s ease, opacity 0.3s ease;
    opacity: 0;
    padding-left: 1rem;
    border-left: 2px solid #e9ecef;
    margin-left: 0.5rem;
}

.dropdown-menu-sub.show {
    max-height: 500px;
    opacity: 1;
}

/* Styling untuk link menu */
.a-menu {
    display: block;
    padding: 0.5rem 1rem;
    text-decoration: none;
    transition: all 0.2s ease;
    border-radius: 0.25rem;
    margin: 0.25rem 0;
}



/* Toggle styles */
.dropdown-toggle-s {
    cursor: pointer;
    display: flex;
    align-items: center;
    justify-content: left;
    padding: 0.75rem 1rem;
    color: #2c3e50;
    text-decoration: none;
    transition: all 0.2s ease;
}

.submenu-magang .dropdown-toggle-s {
    color: white;
}

.submenu-magang .span-title-menu {
    color: white;
}

.dropdown-toggle-s:hover {
    background-color: #f8f9fa;
}

.submenu-toggle {
    padding-left: 1.5rem;
    font-size: 0.9em;
}

/* Icon transition */
.bi {
    transition: transform 0.3s ease;
    font-size: 0.8em;
}

.dropdown-s .bi-caret-up-fill {
    transition: transform 0.3s ease;
    margin-left: 9px;
}

.dropdown-s .bi-caret-down-fill {
    transition: transform 0.3s ease;
    margin-left: 9px;
}


/* Responsive adjustments */
@media (max-width: 991.98px) {
    .offcanvas-body {
        overflow-y: auto;
    }

    :deep(.nav-toggle){
        display: flex !important;
    }
    
    .dropdown-menu-sub {
        padding-left: 0.5rem;
        margin-left: 0.25rem;
    }
    
    .submenu-toggle {
        padding-left: 1rem;
    }
}

.span-title-menu {
    display: block;
    padding: 0.5rem 1rem;
    font-size: 0.8em;
    font-weight: 600;
    text-transform: uppercase;
    letter-spacing: 0.5px;
    color: white !important;
}
</style>