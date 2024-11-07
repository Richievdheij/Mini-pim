<script setup>
import { defineProps, defineEmits } from 'vue';

const props = defineProps(['isManageExpanded', 'isSidebarExpanded']);
const emit = defineEmits(['toggle-section']);
</script>

<template>
    <div class="sidebar__section">
        <h3 class="sidebar__title" @click="$emit('toggle-section', 'manage')" :class="{ 'sidebar__title--disabled': !isSidebarExpanded }">
            <span v-if="isSidebarExpanded">Manage</span>
            <i class="forgot-password__icon fas" :class="isManageExpanded ? 'fa-chevron-down' : 'fa-chevron-right'"></i>
        </h3>
        <div class="sidebar__divider"></div>
        <div class="sidebar__button-container" v-if="isManageExpanded">
            <button class="sidebar__button">
                <i class="sidebar__icon fas fa-file-alt"></i>
                <span>Logs</span>
            </button>
            <button class="sidebar__button">
                <i class="sidebar__icon fas fa-cogs"></i>
                <span>Settings</span>
            </button>
        </div>
    </div>
</template>
