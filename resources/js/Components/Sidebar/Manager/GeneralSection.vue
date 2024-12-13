<script setup>
import { defineProps, defineEmits } from 'vue';
import { Link } from '@inertiajs/vue3';

// Define props and emit
const props = defineProps(['isGeneralExpanded', 'isSidebarExpanded']);
const emit = defineEmits(['toggle-section']);
</script>

<template>
    <div :class="['sidebar-general-section', { open: isGeneralExpanded }]">
        <h3
            class="sidebar-general-section__title"
            @click="$emit('toggle-section', 'general')"
            :class="{ 'sidebar-general-section__title--disabled': !isSidebarExpanded }"
        >
            <span class="sidebar-general-section-title">General</span>
            <i class="sidebar-general-section__chevron fas fa-chevron-down"></i>
        </h3>

        <div :class="['sidebar-general-section__button-container', { open: isGeneralExpanded }]">
            <!-- USERS LINK -->
            <Link
                class="sidebar-general-section__button"
                :class="{ 'active': route().current('users.index') }"
                :href="route('users.index')"
            >
                <div class="sidebar-general-section__icon-container">
                    <i class="sidebar-general-section__icon fas fa-users"></i>
                </div>
                <span>Users</span>
            </Link>

            <!-- PROFILES LINK -->
            <Link
                class="sidebar-general-section__button"
                :class="{ 'active': route().current('profiles.index') }"
                :href="route('profiles.index')"
            >
                <div class="sidebar-general-section__icon-container">
                    <i class="sidebar-general-section__icon fas fa-user-circle"></i>
                </div>
                <span>Profiles</span>
            </Link>

            <!-- USER RIGHTS LINK -->
            <Link
                class="sidebar-general-section__button"
                :class="{ 'active': route().current('user-rights.index') }"
                :href="route('user-rights.index')"
            >
                <div class="sidebar-general-section__icon-container">
                    <i class="sidebar-general-section__icon fas fa-user-shield"></i>
                </div>
                <span>User rights</span>
            </Link>
        </div>
    </div>
</template>
