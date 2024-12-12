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
                :class="{ 'active': route().current('pim.products.index') }"
                :href="route('pim.products.index')"
            >
                <div class="sidebar-data-section__icon-container">
                    <i class="sidebar-data-section__icon fas fa-layer-group"></i>
                </div>
                <span>Products</span>
            </Link>

            <!-- Types -->
            <Link
                class="sidebar-data-section__button"
                :class="{ 'active': route().current('pim.types.index') }"
                :href="route('pim.types.index')"
            >
                <div class="sidebar-data-section__icon-container">
                    <i class="sidebar-data-section__icon fas fa-th-list"></i>
                </div>
                <span>Types</span>
            </Link>

            <!-- Attributes -->
            <Link
                class="sidebar-data-section__button"
                :class="{ 'active': route().current('pim.attributes.index') }"
                :href="route('pim.attributes.index')"
            >
                <div class="sidebar-data-section__icon-container">
                    <i class="sidebar-data-section__icon fas fa-list"></i>
                </div>
                <span>Attributes</span>
            </Link>
        </div>
    </div>
</template>
