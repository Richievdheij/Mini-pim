<script setup>
import { defineProps, defineEmits } from 'vue';

const props = defineProps(['isGeneralExpanded', 'isSidebarExpanded']);
const emit = defineEmits(['toggle-section']);
</script>

<template>
    <div class="sidebar__section">
        <h3 class="sidebar__title" @click="$emit('toggle-section', 'general')" :class="{ 'sidebar__title--disabled': !isSidebarExpanded }">
            <span v-if="isSidebarExpanded">General</span>
            <i class="forgot-password__icon fas" :class="isGeneralExpanded ? 'fa-chevron-down' : 'fa-chevron-right'"></i>
        </h3>
        <div class="sidebar__divider"></div>
        <div class="sidebar__button-container" v-if="isGeneralExpanded">
            <button class="sidebar__button">
                <i class="sidebar__icon fas fa-users"></i>
                <span>Users</span>
            </button>
            <button class="sidebar__button">
                <i class="sidebar__icon fas fa-user-circle"></i>
                <span>Profiles</span>
            </button>
            <button class="sidebar__button">
                <i class="sidebar__icon fas fa-user-shield"></i>
                <span>User rights</span>
            </button>
        </div>
    </div>
</template>
