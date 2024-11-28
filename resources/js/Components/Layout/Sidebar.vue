<script setup>
import { ref } from 'vue';
import { usePage } from '@inertiajs/vue3';

import MainSection from '@/Components/Sidebar/MainSection.vue';
import AccountSection from '@/Components/Sidebar/AccountSection.vue';
import GeneralSection from '@/Components/Sidebar/GeneralSection.vue';
import ManageSection from '@/Components/Sidebar/ManageSection.vue';
import ProfileSection from '@/Components/Sidebar/ProfileSection.vue';

const isSidebarExpanded = ref(true);
const isGeneralExpanded = ref(true);
const isManageExpanded = ref(true);
const isAccountExpanded = ref(true);

const {props} = usePage();
const user = props.user;

const toggleSidebar = () => {
    isSidebarExpanded.value = !isSidebarExpanded.value;
};

const toggleSection = (section) => {
    if (section === 'general') isGeneralExpanded.value = !isGeneralExpanded.value;
    if (section === 'manage') isManageExpanded.value = !isManageExpanded.value;
    if (section === 'account') isAccountExpanded.value = !isAccountExpanded.value;
};
</script>

<template>
    <aside :class="['sidebar', { 'sidebar--collapsed': !isSidebarExpanded }]">
        <!-- Main Section with Manager Dropdown -->
        <MainSection
            :isSidebarExpanded="isSidebarExpanded"
        />

        <!-- Sidebar Toggle Button -->
        <div class="sidebar__toggle" @click="toggleSidebar">
            <i class="sidebar__icon fas" :class="isSidebarExpanded ? 'fa-angle-left' : 'fa-angle-right'"></i>
        </div>

        <!-- General Section -->
        <GeneralSection
            :isGeneralExpanded="isGeneralExpanded"
            :isSidebarExpanded="isSidebarExpanded"
            @toggle-section="toggleSection"
        />

        <!-- Manage Section -->
        <ManageSection
            :isManageExpanded="isManageExpanded"
            :isSidebarExpanded="isSidebarExpanded"
            @toggle-section="toggleSection"
        />

        <!-- Account Section -->
        <AccountSection
            :isAccountExpanded="isAccountExpanded"
            :isSidebarExpanded="isSidebarExpanded"
            @toggle-section="toggleSection"
        />

        <!-- Profile Section -->
        <ProfileSection
            :isSidebarExpanded="isSidebarExpanded"
        />
    </aside>
</template>
