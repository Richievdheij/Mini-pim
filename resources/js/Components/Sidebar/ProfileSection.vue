<script setup>
import { defineProps } from 'vue';

const props = defineProps({
    isSidebarExpanded: Boolean,
    user: {
        type: Object,
        default: () => ({
            name: '',
            profiles: [],
        }),
    },
});
</script>

<template>
    <div class="sidebar-profile-section">
        <div class="sidebar-profile-section__divider"></div>
        <div class="sidebar-profile-section__content">
            <div class="sidebar-profile-section__icon-container">
                <i class="fas fa-user sidebar-profile-section__icon"></i>
            </div>
            <div class="sidebar-profile-section__info">
                <!-- Display user name & Profile name -->
                <span class="sidebar-profile-section__name">{{ user.name }}</span>
                <span class="sidebar-profile-section__rank">TEST</span>
            </div>
        </div>
    </div>
</template>
