<script setup>
import { ref } from 'vue';
import { useForm, usePage } from '@inertiajs/vue3';

// Sidebar expansion state
const isSidebarExpanded = ref(true);

// Track the active view ('manager' or 'pim')
const activeView = ref('manager');

// State to manage each section's expansion
const isAlgemeenExpanded = ref(true);
const isBeheerExpanded = ref(true);
const isAccountExpanded = ref(true);
const isPIMDropdownOpen = ref(false); // State for PIM dropdown visibility

// Use form for logout functionality
const form = useForm({});

// Toggle sidebar state
const toggleSidebar = () => {
    isSidebarExpanded.value = !isSidebarExpanded.value;
};

const toggleDropdown = () => {
    isPIMDropdownOpen.value = !isPIMDropdownOpen.value;
};

const switchView = (view) => {
    activeView.value = view;
    isPIMDropdownOpen.value = false; // Close dropdown when switching views
};

// Toggle section state
const toggleSection = (section) => {
    if (section === 'algemeen') {
        isAlgemeenExpanded.value = !isAlgemeenExpanded.value;
    } else if (section === 'beheer') {
        isBeheerExpanded.value = !isBeheerExpanded.value;
    } else if (section === 'account') {
        isAccountExpanded.value = !isAccountExpanded.value;
    } else if (section === 'pim') {
        isPIMDropdownOpen.value = !isPIMDropdownOpen.value; // Toggle PIM dropdown
    }
};

// Logout function
function logout() {
    form.post(route('logout'));
}

// Get the user and roles from Inertia's props
const { props } = usePage();
const user = props.user;
</script>

<template>
    <aside :class="['sidebar', { 'sidebar--collapsed': !isSidebarExpanded }]">
        <!-- Main Section with Manager Dropdown -->
        <section class="sidebar__section--main">
            <div class="sidebar__button-container" :class="{ 'sidebar__button-container--expanded': isSidebarExpanded }">
                <button class="sidebar__button" @click="toggleDropdown">
                    <div class="sidebar__logo-container">
                        <img class="sidebar__logo" src="/images/pim/mini-pim-logo-wit.png" alt="EZ PIM Logo"/>
                    </div>
                    <div class="sidebar__text-container">
                        <span class="sidebar__text">{{ activeView === 'manager' ? 'Manager' : 'PIM' }}</span>
                    </div>
                    <i class="fas sidebar__chevron" :class="isPIMDropdownOpen ? 'fa-chevron-up' : 'fa-chevron-down'"></i>
                </button>
            </div>
            <div v-if="isPIMDropdownOpen" class="sidebar__pim-dropdown">
                <button class="sidebar__button" @click="switchView('pim')">
                    <span v-if="isSidebarExpanded">PIM</span>
                </button>
                <button class="sidebar__button" @click="switchView('manager')">
                    <span v-if="isSidebarExpanded">Manager</span>
                </button>
            </div>
        </section>

        <!-- Sidebar Toggle Button -->
        <div class="sidebar__toggle" @click="toggleSidebar">
            <i class="sidebar__icon fas" :class="isSidebarExpanded ? 'fa-angle-left' : 'fa-angle-right'"></i>
        </div>

        <!-- Conditional Sections Based on Active View -->
        <div v-if="activeView === 'manager'">
            <section class="sidebar__section">
                <h3 class="sidebar__title" @click="toggleSection('algemeen')">
                    <span v-if="isSidebarExpanded">Algemeen</span>
                    <i class="forgot-password__icon fas fa-chevron-down" v-if="isAlgemeenExpanded"></i>
                    <i class="forgot-password__icon fas fa-chevron-right" v-else></i>
                </h3>
                <div class="sidebar__divider"></div>
                <div class="sidebar__button-container" v-if="isAlgemeenExpanded">
                    <button class="sidebar__button">
                        <i class="sidebar__icon fas fa-users"></i>
                        <span v-if="isSidebarExpanded">Gebruikers</span>
                    </button>
                    <button class="sidebar__button">
                        <i class="sidebar__icon fas fa-user-circle"></i>
                        <span v-if="isSidebarExpanded">Profielen</span>
                    </button>
                    <button class="sidebar__button">
                        <i class="sidebar__icon fas fa-user-shield"></i>
                        <span v-if="isSidebarExpanded">Gebruikersrechten</span>
                    </button>
                </div>
            </section>

            <section class="sidebar__section">
                <h3 class="sidebar__title" @click="toggleSection('beheer')">
                    <span v-if="isSidebarExpanded">Beheer</span>
                    <i class="forgot-password__icon fas fa-chevron-down" v-if="isBeheerExpanded"></i>
                    <i class="forgot-password__icon fas fa-chevron-right" v-else></i>
                </h3>
                <div class="sidebar__divider"></div>
                <div class="sidebar__button-container" v-if="isBeheerExpanded">
                    <button class="sidebar__button">
                        <i class="sidebar__icon fas fa-file-alt"></i>
                        <span v-if="isSidebarExpanded">Logs</span>
                    </button>
                    <button class="sidebar__button">
                        <i class="sidebar__icon fas fa-cogs"></i>
                        <span v-if="isSidebarExpanded">Instellingen</span>
                    </button>
                </div>
            </section>
        </div>

        <!-- Account Section (Visible in Both Views, Positioned Above Profile) -->
        <div class="sidebar__section">
            <h3 class="sidebar__title" @click="toggleSection('account')">
                <span v-if="isSidebarExpanded">Account</span>
                <i class="forgot-password__icon fas fa-chevron-down" v-if="isAccountExpanded"></i>
                <i class="forgot-password__icon fas fa-chevron-right" v-else></i>
            </h3>
            <div class="sidebar__divider"></div>
            <div class="sidebar__button-container" v-if="isAccountExpanded">
                <a :href="route('profile.edit')" class="sidebar__button">
                    <i class="sidebar__icon fas fa-user"></i>
                    <span v-if="isSidebarExpanded">Account instellingen</span>
                </a>
                <button class="sidebar__button" @click.prevent="logout">
                    <i class="sidebar__icon fas fa-sign-out-alt"></i>
                    <span v-if="isSidebarExpanded">Uitloggen</span>
                </button>
            </div>
        </div>

        <!-- Profile Section at the Bottom (Visible in Both Views) -->
        <div class="sidebar__profile">
            <div class="sidebar__profile-divider"></div>
            <div class="sidebar__profile-image"></div>
            <div class="sidebar__profile-info">
                <span v-if="isSidebarExpanded" class="sidebar__profile-name">{{ user.name }}</span>
                <span v-if="isSidebarExpanded" class="sidebar__profile-rank">Role</span>
                <span v-if="isSidebarExpanded" class="sidebar__profile-status">Test</span>
            </div>
        </div>
    </aside>
</template>
