<script setup>
import { ref } from 'vue';

const activeView = ref('manager');
const isSidebarExpanded = ref(true);
const isPIMDropdownOpen = ref(false);

const toggleDropdown = () => {
    isPIMDropdownOpen.value = !isPIMDropdownOpen.value;
};


</script>

<template>
    <section class="sidebar__section--main">
        <div class=""
             :class="['sidebar__button-container', { 'sidebar__button-container--expanded': isSidebarExpanded }]">
            <button class="sidebar__button" @click="toggleDropdown" :disabled="!isSidebarExpanded">
                <div class="sidebar__logo-container">
                    <img class="sidebar__logo"
                         src="/images/pim/mini-pim-logo-wit.png"
                         alt="EZ PIM Logo"
                    />
                </div>
                <div class="sidebar__text-container">
                    <span class="sidebar__text">
                        {{ activeView === 'manager' ? 'Manager' : 'PIM' }}
                    </span>
                </div>
                <i class="fas sidebar__chevron"
                   :class="isPIMDropdownOpen ? 'fa-chevron-up' : 'fa-chevron-down'">
                </i>
            </button>
        </div>
        <div v-if="isPIMDropdownOpen" class="sidebar__pim-dropdown">
            <button class="sidebar__button" @click="switchView('pim')" :disabled="!isSidebarExpanded">
                <span v-if="isSidebarExpanded">PIM</span>
            </button>
            <button class="sidebar__button" @click="switchView('manager')" :disabled="!isSidebarExpanded">
                <span v-if="isSidebarExpanded">Manager</span>
            </button>
        </div>
    </section>
</template>
