<script setup>
import { ref } from 'vue';
import {Head, Link, router} from '@inertiajs/vue3';
import Button from '@/Components/General/PrimaryButton.vue';
import EditUserModal from '@/Components/Admin/EditUserModal.vue';
import DeleteUserModal from '@/Components/Admin/DeleteUserModal.vue';
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import PrimaryButton from "@/Components/General/PrimaryButton.vue";

defineProps({
    users: Array,
    profiles: Array,
    canEditUser: Boolean,
    canDeleteUser: Boolean,
    canCreateUser: Boolean,
});

const isEditModalOpen = ref(false);
const isDeleteModalOpen = ref(false);
const selectedUser = ref(null);

function openModal(modalType, user) {
    selectedUser.value = user;
    modalType === 'edit' ? (isEditModalOpen.value = true) : (isDeleteModalOpen.value = true);
}

function closeModal(modalType) {
    selectedUser.value = null;
    modalType === 'edit' ? (isEditModalOpen.value = false) : (isDeleteModalOpen.value = false);
}
</script>

<template>
    <Head title="Users" />
    <AuthenticatedLayout>
        <div class="users">
            <div class="users__header">
                <h1 class="users__title">Users</h1>
            </div>

            <div class="users__section">

                <div v-if="canCreateUser" class="users__create-button">
                    <Link :href="route('users.create')">
                        <PrimaryButton label="Create New User" type=""/>
                    </Link>
                </div>

                <table class="users__table">
                    <thead>
                    <tr>
                        <th>Name</th>
                        <th>Email</th>
                        <th>Profiles</th>
                        <th v-if="canEditUser || canDeleteUser">Actions</th>
                    </tr>
                    </thead>
                    <tbody>
                    <tr v-for="user in users" :key="user.id">
                        <td>{{ user.name }}</td>
                        <td>{{ user.email }}</td>
                        <td>
                            <ul>
                                <li v-for="profile in user.profiles" :key="profile.id">{{ profile.name }}</li>
                            </ul>
                        </td>
                        <td v-if="canEditUser || canDeleteUser">
                            <Button v-if="canEditUser" label="Edit" @click="openModal('edit', user)" />
                            <Button v-if="canDeleteUser" label="Delete" @click="openModal('delete', user)" />
                        </td>
                    </tr>
                    </tbody>
                </table>
            </div>

            <EditUserModal :user="selectedUser" :profiles="profiles" :isOpen="isEditModalOpen" @close="closeModal('edit')" />
            <DeleteUserModal :user="selectedUser" :isOpen="isDeleteModalOpen" @close="closeModal('delete')" />
        </div>
    </AuthenticatedLayout>
</template>
