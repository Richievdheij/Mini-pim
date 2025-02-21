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
                <!-- Display user name -->
                <span class="sidebar-profile-section__name">{{ user.name }}</span>
                <!-- Display profile names -->
                <span class="sidebar-profile-section__rank">
                    {{ user.profiles.length > 0
                    ? user.profiles.map(profile => profile.name).join(', ')
                    : 'No Profile Assigned' }}
                </span>
                <!-- Display version release -->
                <span class="sidebar-profile-section__version">v2.2.0</span>
            </div>
        </div>
    </div>
</template>
