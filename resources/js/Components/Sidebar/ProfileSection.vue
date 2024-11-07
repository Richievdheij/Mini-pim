<script setup>
import { defineProps } from 'vue';

const props = defineProps(['isSidebarExpanded']);
</script>

<template>
    <div class="sidebar__profile">
        <div class="sidebar__profile-divider"></div>
        <div class="sidebar__profile-content">
            <div class="sidebar__profile-image">
                <i class="fas fa-user sidebar__profile-icon"></i>
            </div>
            <div class="sidebar__profile-info">
                <span class="sidebar__profile-name" v-if="isSidebarExpanded">test</span>
                <span class="sidebar__profile-rank" v-if="isSidebarExpanded">test</span>
                <span class="sidebar__profile-status" v-if="isSidebarExpanded">test</span>
            </div>
        </div>
    </div>
</template>
