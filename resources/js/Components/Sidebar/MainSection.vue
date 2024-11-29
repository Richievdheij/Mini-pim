<script setup>
import { ref } from 'vue';
import { Inertia } from '@inertiajs/inertia';

const activeView = ref('Manager'); // Current active tab
const isSidebarExpanded = ref(true); // Sidebar state (expanded or collapsed)
const isPIMDropdownOpen = ref(false); // Dropdown state (open or closed)

// Toggle the dropdown menu open/close
const toggleDropdown = () => {
    isPIMDropdownOpen.value = !isPIMDropdownOpen.value;
};

// Navigate to the PIM dashboard
const navigateToPim = () => {
    Inertia.visit(route('dashboard')); // FIX THIS
};
</script>

<template>
    <button class="sidebar-main-section">
        <div class="sidebar-main-section__button-container"
             :class="{ 'sidebar-main-section__button-container--collapsed': !isSidebarExpanded }"
        >
            <!-- Logo and title -->
            <button
                class="sidebar-main-section__button"
                @click="toggleDropdown"
            >
                <div class="sidebar-main-section__logo-container"
                     :class="{ 'sidebar-main-section__logo-container--collapsed': !isSidebarExpanded }"
                >
                    <img class="sidebar-main-section__logo"
                         src="/images/pim/mini-pim-logo.png"
                         alt="EZ PIM Logo"
                    />
                </div>
                <div class="sidebar-main-section__text-container">
                    <span
                        class="sidebar-main-section__text"
                        :class="{ 'sidebar-main-section__text--collapsed': !isSidebarExpanded }"
                    >
                        {{ activeView }}
                    </span>
                </div>
                <i class="fas sidebar-main-section__chevron"
                   :class="isPIMDropdownOpen ? 'fa-chevron-up' : 'fa-chevron-down'">
                </i>
            </button>
        </div>

        <!-- Dropdown-menu -->
        <div class="sidebar-main-section__dropdown" v-if="isPIMDropdownOpen">
            <button
                class="sidebar-main-section__dropdown-item"
                @click.prevent="navigateToPim"
            >
                <span>PIM</span>
            </button>
        </div>
    </button>
</template>
