<script setup>
import { ref } from 'vue';
import { usePage } from '@inertiajs/vue3';
import MainSection from '@/Components/Sidebar/Manager/MainSection.vue';
import GeneralSection from '@/Components/Sidebar/Manager/GeneralSection.vue';
import ManageSection from '@/Components/Sidebar/Manager/ManageSection.vue';
import AccountSection from '@/Components/Sidebar/Manager/AccountSection.vue';
import ProfileSection from '@/Components/Sidebar/ProfileSection.vue';

// Sidebar State
const isSidebarExpanded = ref(true);
const isGeneralExpanded = ref(true);
const isManageExpanded = ref(true);
const isAccountExpanded = ref(true);

// Get the user from the page props
const { props } = usePage();
const user = props.auth.user || {
    name: '',
    profiles: [],
};

// Toggle Sidebar
const toggleSidebar = () => {
    isSidebarExpanded.value = !isSidebarExpanded.value;
};

// Toggle Section
const toggleSection = (section) => {
    if (section === 'general') isGeneralExpanded.value = !isGeneralExpanded.value;
    if (section === 'manage') isManageExpanded.value = !isManageExpanded.value;
};
</script>

<template>
    <aside :class="['sidebar', { 'sidebar--collapsed': !isSidebarExpanded }]">
        <!-- Main Section with Manager Dropdown -->
        <MainSection
            :isSidebarExpanded="isSidebarExpanded"
        />

        <!-- General Section -->
        <GeneralSection
            :isGeneralExpanded="isGeneralExpanded"
            :isSidebarExpanded="isSidebarExpanded"
            @toggle-section="toggleSection"
        />

        <!-- Manage Section -->
        <ManageSection
            v-if="false"
            :isManageExpanded="isManageExpanded"
            :isSidebarExpanded="isSidebarExpanded"
            @toggle-section="toggleSection"
        />

        <!-- Sidebar Toggle Button -->
        <div class="sidebar__toggler">
            <div class="sidebar__toggle" @click="toggleSidebar">
                <div class="sidebar__toggle-circle">
                    <i class="sidebar__toggle-icon fas fa-angle-left"></i>
                </div>
            </div>
        </div>

        <!-- Account Section -->
        <AccountSection
            :isAccountExpanded="isAccountExpanded"
            :isSidebarExpanded="isSidebarExpanded"
            @toggle-section="toggleSection"
        />

        <!-- Profile Section -->
        <ProfileSection
            :isSidebarExpanded="isSidebarExpanded"
            :user="user" s
        />
    </aside>
</template>
