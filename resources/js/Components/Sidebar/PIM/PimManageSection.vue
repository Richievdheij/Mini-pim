<script setup>
import { defineProps, defineEmits } from 'vue';

const props = defineProps(['isManageExpanded', 'isSidebarExpanded']);
const emit = defineEmits(['toggle-section']);
</script>

<template>
    <div :class="['sidebar-manage-section', { open: isManageExpanded }]">
        <h3
            class="sidebar-manage-section__title"
            @click="$emit('toggle-section', 'manage')"
            :class="{ 'sidebar-manage-section__title--disabled': !isSidebarExpanded }"
        >
            <span class="sidebar-general-section-title">Manage</span>
            <i class="sidebar-manage-section__chevron fas fa-chevron-down"></i>
        </h3>

        <div :class="['sidebar-manage-section__button-container', { open: isManageExpanded }]">
            <button class="sidebar-manage-section__button">
                <div class="sidebar-manage-section__icon-container">
                    <i class="sidebar-manage-section__icon fas fa-file-alt"></i>
                </div>
                <span>Logs</span>
            </button>
            <button class="sidebar-manage-section__button">
                <div class="sidebar-manage-section__icon-container">
                    <i class="sidebar-manage-section__icon fas fa-cogs"></i>
                </div>
                <span>Settings</span>
            </button>
        </div>
    </div>
</template>

