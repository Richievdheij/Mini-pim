<script setup>
import { ref } from 'vue';
import { Link } from '@inertiajs/vue3';

const isSidebarExpanded = ref(true); // Sidebar state (expanded or collapsed)
const isPIMDropdownOpen = ref(false); // Dropdown state (open or closed)

// Toggle the dropdown menu open/close
const toggleDropdown = () => {
    isPIMDropdownOpen.value = !isPIMDropdownOpen.value;
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
                :class="{ 'sidebar-main-section__button--collapsed': !isSidebarExpanded }"
                @click="toggleDropdown"
                :disabled="!isSidebarExpanded"
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
                        PIM
                    </span>
                </div>
                <i class="fas sidebar-main-section__chevron"
                   :class="isPIMDropdownOpen ? 'fa-chevron-up' : 'fa-chevron-down'">
                </i>
            </button>
        </div>

        <!-- Dropdown-menu -->
        <div class="sidebar-main-section__dropdown" v-if="isPIMDropdownOpen">
            <Link
                class="sidebar-main-section__dropdown-item"
                :href="route('dashboard')"
            >
                <span>Manager</span>
            </Link>
        </div>
    </button>
</template>
