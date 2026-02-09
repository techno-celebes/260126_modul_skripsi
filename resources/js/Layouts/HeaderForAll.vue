<template>
    <div class="top-header">
        <!-- Top Bar -->
        <div class="top-bar">
            <div class="container">
                <div class="d-flex justify-content-between align-items-center">
                    <!-- Left: Quick Actions -->
                    <div class="topbar-left">
                        <a href="#" class="topbar-link ignore-color">
                            <i class="bi bi-envelope"></i>
                            support@uinpalu.ac.id
                        </a>
                        <a href="#" class="topbar-link ignore-color">
                            <i class="bi bi-telephone"></i>
                            +62 451 123 456
                        </a>
                    </div>

                    <!-- Right: User Menu -->
                    <div class="topbar-right">
                        <div class="dropdown user-dropdown" ref="userDropdown">
                            <a href="#" class="user-profile ignore-color" @click.prevent="toggleUserDropdown">
                                <div class="avatar">
                                    <img src="/assets/img/avatar.png" alt="Admin" />
                                </div>
                                <span class="user-name ignore-color">{{ auth.user.name }}</span>
                                <i class="bi bi-chevron-down dropdown-arrow"></i>
                            </a>
                            <div class="dropdown-menu user-menu" :class="{ 'show': userDropdownOpen }">
                                <a href="#" class="dropdown-item ignore-color">
                                    <i class="bi bi-person"></i>
                                    Profile
                                </a>
                                <a :href="'#'" class="dropdown-item ignore-color">
                                    <i class="bi bi-gear"></i>
                                    Modul
                                </a>
                                <div class="dropdown-divider"></div>
                                <a
                                    :href="route('logout')"
                                    class="dropdown-item text-danger ignore-color"
                                >
                                    <i class="bi bi-box-arrow-right"></i>
                                    Logout
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Main Navigation -->
        <nav class="main-navbar">
            <div class="container">
                <div class="navbar-content">
                    <!-- Logo Brand -->
                    <div class="navbar-brand">
                        <div class="brand-logo">
                            <img src="/assets/img/logo-transparant.png" alt="UIN Datokarama Palu" />
                        </div>
                        <div class="brand-text d-none d-md-block">
                            <h1 class="university-name ignore-color">UIN Datokarama Palu</h1>
                            <p class="system-name ignore-color">{{ app_tagline }}</p>
                        </div>
                    </div>

                    <!-- Navigation Controls -->
                    <div class="navbar-controls">
                        <!-- Mobile Toggle -->
                        <button class="nav-toggle" data-bs-toggle="offcanvas" data-bs-target="#offcanvasNavbar">
                            <span></span>
                            <span></span>
                            <span></span>
                        </button>

                        <!-- Quick Actions -->
                        <div class="nav-actions">
                            <button class="nav-action-btn" title="Notifications">
                                <i class="bi bi-bell"></i>
                                <span class="notification-badge ignore-color">3</span>
                            </button>
                            <button class="nav-action-btn" title="Messages">
                                <i class="bi bi-chat"></i>
                            </button>
                            <button class="nav-action-btn d-none d-sm-block" title="Search">
                                <i class="bi bi-search"></i>
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </nav>
    </div>
</template>

<script setup>
import { Link, usePage } from '@inertiajs/vue3';
import { ref, onMounted, onBeforeUnmount } from 'vue';

const props = defineProps({
    app_tagline: String,
});

const { props: pageProps } = usePage()
const auth = pageProps.auth

const userDropdownOpen = ref(false);
const userDropdown = ref(null);

const toggleUserDropdown = (event) => {
    event.stopPropagation();
    userDropdownOpen.value = !userDropdownOpen.value;
};

const closeUserDropdown = () => {
    userDropdownOpen.value = false;
};

const handleClickOutside = (event) => {
    if (userDropdown.value && !userDropdown.value.contains(event.target)) {
        closeUserDropdown();
    }
};

const toggleSidebar = () => {
    const event = new CustomEvent('toggle-sidebar');
    document.dispatchEvent(event);
};

onMounted(() => {
    document.addEventListener('click', handleClickOutside);
});

onBeforeUnmount(() => {
    document.removeEventListener('click', handleClickOutside);
});
</script>

<style scoped>
/* Top Bar */


.topbar-link {
    text-decoration: none;
    font-size: 0.85rem;
    margin-right: 20px;
    transition: color 0.3s ease;
    color: white;
}


.topbar-link i {
    margin-right: 5px;
}

/* User Dropdown */
.user-dropdown {
    position: relative;
}

.user-profile {
    display: flex;
    align-items: center;
    text-decoration: none;
    padding: 5px 10px;
    border-radius: 20px;
    transition: all 0.3s ease;
    cursor: pointer;
}

.user-profile:hover {
    background: rgba(255, 255, 255, 0.1);
}

.avatar {
    width: 32px;
    height: 32px;
    border-radius: 50%;
    overflow: hidden;
    margin-right: 8px;
    border: 2px solid rgba(255, 255, 255, 0.3);
}

.avatar img {
    width: 100%;
    height: 100%;
    object-fit: cover;
}

.user-name {
    font-size: 0.9rem;
    margin-right: 8px;
}

.dropdown-arrow {
    font-size: 0.7rem;
    transition: transform 0.3s ease;
}

.user-dropdown.show .dropdown-arrow {
    transform: rotate(180deg);
}

.user-menu {
    position: absolute;
    top: 100%;
    right: 0;
    margin-top: 10px;
    border: none;
    border-radius: 12px;
    box-shadow: 0 10px 30px rgba(166, 43, 43, 0.2);
    min-width: 200px;
    padding: 8px 0;
    opacity: 0;
    visibility: hidden;
    transform: translateY(-10px);
    transition: all 0.3s ease;
    z-index: 1000;
}

.user-menu.show {
    opacity: 1;
    visibility: visible;
    transform: translateY(0);
}

@media (max-width: 768px) {
    .user-menu {
        right: 10px;
        left: 10px;
        min-width: auto;
        width: 200px;
    }
}

.dropdown-item {
    display: flex;
    align-items: center;
    padding: 10px 16px;
    text-decoration: none;
    transition: all 0.3s ease;
    border: none;
    background: none;
    width: 100%;
    text-align: left;
    cursor: pointer;
}
.dropdown-item i {
    margin-right: 10px;
    width: 16px;
}


.navbar-content {
    display: flex;
    justify-content: space-between;
    align-items: center;
}

.navbar-brand {
    display: flex;
    align-items: center;
}

.brand-logo {
    width: 50px;
    height: 50px;
    margin-right: 15px;
    border-radius: 12px;
    padding: 5px;
    background: transparent;
}

.brand-logo img {
    width: 100%;
    height: 100%;
    object-fit: contain;
}

.system-name {
    font-size: 0.85rem;
    margin: 0;
    font-weight: 500;
}

/* Navigation Controls */
.navbar-controls {
    display: flex;
    align-items: center;
    gap: 15px;
}

.nav-toggle {
    display: none;
    flex-direction: column;
    background: none;
    border: none;
    padding: 5px;
    cursor: pointer;
}

.nav-actions {
    display: flex;
    gap: 10px;
}

.nav-action-btn {
    position: relative;
    border: none;
    width: 40px;
    height: 40px;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    transition: all 0.3s ease;
    cursor: pointer;
}

.nav-action-btn:hover {
    transform: translateY(-2px);
    box-shadow: 0 5px 15px rgba(166, 43, 43, 0.4);
}

.notification-badge {
    position: absolute;
    top: -2px;
    right: -2px;
    border-radius: 50%;
    width: 18px;
    height: 18px;
    font-size: 0.7rem;
    display: flex;
    align-items: center;
    justify-content: center;
}

/* Responsive */
@media (max-width: 768px) {
    .topbar-left {
        display: none;
    }

    .nav-toggle {
        display: flex;
    }

    .university-name {
        font-size: 1.1rem;
    }

    .system-name {
        font-size: 0.75rem;
    }

    .user-name {
        display: none;
    }
}
</style>
