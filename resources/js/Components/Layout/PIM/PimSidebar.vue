<script setup>
import { ref } from 'vue';
import { usePage } from '@inertiajs/vue3';

import PimMainSection from "@/Components/Sidebar/PIM/PimMainSection.vue";
import PimDataSection from "@/Components/Sidebar/PIM/PimDataSection.vue";
import PimManageSection from "@/Components/Sidebar/PIM/PimManageSection.vue";
import PimAccountSection from '@/Components/Sidebar/PIM/PimAccountSection.vue';
import ProfileSection from '@/Components/Sidebar/ProfileSection.vue';

// Sidebar State Management
const isSidebarExpanded = ref(true); //
const isDataExpanded = ref(true);
const isGeneralExpanded = ref(true);
const isManageExpanded = ref(true);
const isAccountExpanded = ref(true);

const { props } = usePage();
const user = props.auth.user || {
    name: '',
    profiles: [],
};

// Sidebar Toggle Function
const toggleSidebar = () => {
    isSidebarExpanded.value = !isSidebarExpanded.value;
};

// Toggle Section Function
const toggleSection = (section) => {
    if (section === 'data') isDataExpanded.value = !isDataExpanded.value;
    if (section === 'general') isGeneralExpanded.value = !isGeneralExpanded.value;
    if (section === 'manage') isManageExpanded.value = !isManageExpanded.value;
    if (section === 'account') isAccountExpanded.value = !isAccountExpanded.value;
};
</script>

<template>
    <aside :class="['sidebar', { 'sidebar--collapsed': !isSidebarExpanded }]">
        <!-- PIM Main Section with Dropdown -->
        <PimMainSection
            :isSidebarExpanded="isSidebarExpanded"
        />

        <!-- Data Section -->
        <PimDataSection
            :isDataExpanded="isDataExpanded"
            :isSidebarExpanded="isSidebarExpanded"
            @toggle-section="toggleSection"
        />

        <!-- Manage Section -->
        <PimManageSection
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
        <PimAccountSection
            :isAccountExpanded="isAccountExpanded"
            :isSidebarExpanded="isSidebarExpanded"
            @toggle-section="toggleSection"
        />

        <!-- Profile Section -->
        <ProfileSection
            :isSidebarExpanded="isSidebarExpanded"
            :user="user"
        />
    </aside>
</template>
