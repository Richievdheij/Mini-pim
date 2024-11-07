<script setup>
import { defineProps, defineEmits } from 'vue';
import { useForm } from '@inertiajs/vue3';

const form = useForm({});

const props = defineProps(['isAccountExpanded', 'isSidebarExpanded']);
const emit = defineEmits(['toggle-section', 'logout']);

// Logout function
function logout() {
    form.post(route('logout'));
}

</script>

<template>
    <div class="sidebar__section">
        <h3 class="sidebar__title"
            @click="$emit('toggle-section', 'account')" :class="{ 'sidebar__title--disabled': !isSidebarExpanded }">
            <span v-if="isSidebarExpanded">Account</span>
            <i class="forgot-password__icon fas" :class="isAccountExpanded ? 'fa-chevron-down' : 'fa-chevron-right'"></i>
        </h3>
        <div class="sidebar__divider"></div>
        <div class="sidebar__button-container" v-if="isAccountExpanded">
            <a :href="route('profile.edit')" class="sidebar__button">
                <i class="sidebar__icon fas fa-user"></i>
                <span>Account settings</span>
            </a>
            <button class="sidebar__button" @click="logout">
                <i class="sidebar__icon fas fa-sign-out-alt"></i>
                <span>Logout</span>
            </button>
        </div>
    </div>
</template>
