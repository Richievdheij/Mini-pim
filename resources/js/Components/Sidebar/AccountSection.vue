<script setup>
import { defineProps, defineEmits } from 'vue';
import { useForm, Link } from '@inertiajs/vue3';

const form = useForm({});
const props = defineProps(['isAccountExpanded', 'isSidebarExpanded']);
const emit = defineEmits(['toggle-section', 'logout']);

function logout() {
    form.post(route('logout'));
}
</script>

<template>
    <div class="sidebar-account-section">
        <h3 class="sidebar-account-section__title" @click="$emit('toggle-section', 'account')"
            :class="{ 'sidebar-account-section__title--disabled': !isSidebarExpanded }">
            <span class="sidebar-general-section-title">Account</span>
            <i class="sidebar-account-section__chevron fas"
               :class="isAccountExpanded ? 'fa-chevron-down' : 'fa-chevron-right'"></i>
        </h3>
        <div class="sidebar-account-section__button-container" v-if="isAccountExpanded">
            <Link :href="route('account.edit')" class="sidebar-account-section__button">
                <div class="sidebar-account-section__icon-container">
                    <i class="sidebar-account-section__icon fas fa-user-edit"></i>
                </div>
                <span>Account settings</span>
            </Link>
            <Link class="sidebar-account-section__button" @click="logout">
                <div class="sidebar-manage-section__icon-container">
                    <i class="sidebar-account-section__icon fas fa-sign-out-alt"></i>
                </div>
                <span>Logout</span>
            </Link>
        </div>
    </div>
</template>
