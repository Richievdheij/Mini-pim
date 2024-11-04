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

// Toggle between 'manager' and 'pim' views
const toggleView = (view) => {
    activeView.value = view;
    isPIMDropdownOpen.value = false; // Close dropdown when switching views
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
        <div class="sidebar__section--main">
            <div class="sidebar__button-container">
                <button class="sidebar__button sidebar__button--manager" @click="toggleSection('pim')">
                    <img src="/images/pim/mini-pim-logo-wit.png" alt="EZ PIM Logo" class="sidebar__logo"/>
                    <span v-if="isSidebarExpanded">{{ activeView === 'manager' ? 'Manager' : 'PIM' }}</span>
                </button>
            </div>
            <div v-if="isPIMDropdownOpen" class="sidebar__pim-dropdown">
                <button class="sidebar__button" @click="toggleView('pim')">
                    <span v-if="isSidebarExpanded">PIM</span>
                </button>
                <button class="sidebar__button" @click="toggleView('manager')">
                    <span v-if="isSidebarExpanded">Manager</span>
                </button>
            </div>
        </div>

        <!-- Sidebar Toggle Button -->
        <div class="sidebar__toggle" @click="toggleSidebar">
            <i class="sidebar__icon fas" :class="isSidebarExpanded ? 'fa-angle-left' : 'fa-angle-right'"></i>
        </div>

        <!-- Conditional Sections Based on Active View -->
        <div v-if="activeView === 'manager'">
            <div class="sidebar__section">
                <h3 class="sidebar__title" @click="toggleSection('algemeen')">
                    Algemeen
                    <i class="forgot-password__icon fas fa-chevron-down" v-if="isAlgemeenExpanded"></i>
                    <i class="forgot-password__icon fas fa-chevron-right" v-else></i>
                </h3>
                <div class="sidebar__divider"></div>
                <div v-if="isAlgemeenExpanded">
                    <button class="sidebar__button" disabled>
                        <i class="sidebar__icon fas fa-users"></i>
                        <span v-if="isSidebarExpanded">Gebruikers</span>
                    </button>
                    <button class="sidebar__button" disabled>
                        <i class="sidebar__icon fas fa-user-circle"></i>
                        <span v-if="isSidebarExpanded">Profielen</span>
                    </button>
                    <button class="sidebar__button" disabled>
                        <i class="sidebar__icon fas fa-user-shield"></i>
                        <span v-if="isSidebarExpanded">Gebruikersrechten</span>
                    </button>
                </div>
            </div>

            <div class="sidebar__section">
                <h3 class="sidebar__title" @click="toggleSection('beheer')">
                    Beheer
                    <i class="forgot-password__icon fas fa-chevron-down" v-if="isBeheerExpanded"></i>
                    <i class="forgot-password__icon fas fa-chevron-right" v-else></i>
                </h3>
                <div class="sidebar__divider"></div>
                <div v-if="isBeheerExpanded">
                    <button class="sidebar__button" disabled>
                        <i class="sidebar__icon fas fa-file-alt"></i>
                        <span v-if="isSidebarExpanded">Logs</span>
                    </button>
                    <button class="sidebar__button" disabled>
                        <i class="sidebar__icon fas fa-cogs"></i>
                        <span v-if="isSidebarExpanded">Instellingen</span>
                    </button>
                </div>
            </div>
        </div>

        <div v-else>
            <div class="sidebar__section">
                <h3 class="sidebar__title" @click="toggleSection('beheer')">
                    PIM Options
                    <i class="forgot-password__icon fas fa-chevron-down" v-if="isBeheerExpanded"></i>
                    <i class="forgot-password__icon fas fa-chevron-right" v-else></i>
                </h3>
                <div class="sidebar__divider"></div>
                <div v-if="isBeheerExpanded">
                    <button class="sidebar__button" @click="route('pim.page1')">
                        <i class="sidebar__icon fas fa-database"></i>
                        <span v-if="isSidebarExpanded">PIM Page 1</span>
                    </button>
                    <button class="sidebar__button" @click="route('pim.page2')">
                        <i class="sidebar__icon fas fa-boxes"></i>
                        <span v-if="isSidebarExpanded">PIM Page 2</span>
                    </button>
                </div>
            </div>

            <div class="sidebar__section">
                <h3 class="sidebar__title" @click="toggleSection('beheer')">
                    Beheer
                    <i class="forgot-password__icon fas fa-chevron-down" v-if="isBeheerExpanded"></i>
                    <i class="forgot-password__icon fas fa-chevron-right" v-else></i>
                </h3>
                <div class="sidebar__divider"></div>
                <div v-if="isBeheerExpanded">
                    <button class="sidebar__button" disabled>
                        <i class="sidebar__icon fas fa-cog"></i>
                        <span v-if="isSidebarExpanded">Settings</span>
                    </button>
                    <button class="sidebar__button" disabled>
                        <i class="sidebar__icon fas fa-user-edit"></i>
                        <span v-if="isSidebarExpanded">Edit Profile</span>
                    </button>
                </div>
            </div>
        </div>

        <!-- Account Section (Visible in Both Views, Positioned Above Profile) -->
        <div class="sidebar__section">
            <h3 class="sidebar__title" @click="toggleSection('account')">
                Account
                <i class="forgot-password__icon fas fa-chevron-down" v-if="isAccountExpanded"></i>
                <i class="forgot-password__icon fas fa-chevron-right" v-else></i>
            </h3>
            <div class="sidebar__divider"></div>
            <div v-if="isAccountExpanded">
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
            <div class="sidebar__profile-image"></div>
            <div class="sidebar__profile-info">
                <span class="sidebar__profile-name">{{ user.name }}</span>
                <span class="sidebar__profile-rank">Role</span>
                <span class="sidebar__profile-status">Test</span>
            </div>
        </div>
    </aside>
</template>

<style scoped>
.sidebar__pim-dropdown {
    padding-left: 1rem; /* Aligns with other buttons */
    transition: max-height 0.2s ease-in-out; /* Smooth transition */
    overflow: hidden; /* Prevent overflow during transition */
}

/* Additional styles for the dropdown (if needed) */
</style>
