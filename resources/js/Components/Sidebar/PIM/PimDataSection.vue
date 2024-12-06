<script setup>
import { defineProps, defineEmits } from 'vue';
import { Link } from '@inertiajs/vue3';

const props = defineProps(['isDataExpanded', 'isSidebarExpanded']);
const emit = defineEmits(['toggle-section']);
</script>

<template>
    <div :class="['sidebar-data-section', { open: isDataExpanded }]">
        <h3
            class="sidebar-data-section__title"
            @click="$emit('toggle-section', 'data')"
            :class="{ 'sidebar-data-section__title--disabled': !isSidebarExpanded }"
        >
            <span class="sidebar-data-section__title-text">Data</span>
            <i class="sidebar-data-section__chevron fas fa-chevron-down"></i>
        </h3>

        <div :class="['sidebar-data-section__button-container', { open: isDataExpanded }]">
            <!-- Products -->
            <Link
                class="sidebar-data-section__button"
                :class="{ 'active': route().current('users.index') }"
                :href="route('users.index')"
            >
                <div class="sidebar-data-section__icon-container">
                    <i class="sidebar-data-section__icon fas fa-cogs"></i>
                </div>
                <span>Products</span>
            </Link>
        </div>
    </div>
</template>
