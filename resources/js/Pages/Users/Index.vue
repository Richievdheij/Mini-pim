<script setup>
import { ref, computed } from 'vue';
import { Head, Link } from '@inertiajs/vue3';
import EditUserModal from '@/Components/Admin/EditUserModal.vue';
import DeleteUserModal from '@/Components/Admin/DeleteUserModal.vue';
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import PrimaryButton from "@/Components/General/PrimaryButton.vue";
import Input from "@/Components/General/Input.vue"

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
const searchQuery = ref('');  // Ref for search input

function openModal(modalType, user) {
    selectedUser.value = user;
    modalType === 'edit' ? (isEditModalOpen.value = true) : (isDeleteModalOpen.value = true);
}

function closeModal(modalType) {
    selectedUser.value = null;
    modalType === 'edit' ? (isEditModalOpen.value = false) : (isDeleteModalOpen.value = false);
}

// Ensure 'users' prop is available before filtering
computed(() => {
    return (users || []).filter(user =>
        user.name.toLowerCase().includes(searchQuery.value.toLowerCase()) ||
        user.email.toLowerCase().includes(searchQuery.value.toLowerCase())
    );
});
</script>

<template>
    <Head title="Users" />
    <AuthenticatedLayout>
        <div class="users">
            <div class="users__header">
                <h1 class="users__title">Users</h1>
            </div>

            <div class="users__section">
                <div class="users__top-bar">
                    <!-- Create User Button -->
                    <div class="users__create-button" v-if="canCreateUser">
                        <Link :href="route('users.create')">
                            <PrimaryButton
                                label="Create New User"
                                type="cancel"
                                icon="fas fa-plus"
                            />
                        </Link>
                    </div>

                    <!-- SearchBar component for filtering users -->
                    <div class="users__search-bar">
                        <Input
                            type="search"
                            id="search"
                            placeholder="Search..."
                            v-model="searchQuery"
                            icon="fas fa-search"
                        />
                    </div>
                </div>

                <table class="users__table">
                    <thead class="users__table-head">
                    <tr>
                        <th class="users__table-header">Name</th>
                        <th class="users__table-header">Email</th>
                        <th class="users__table-header">Profiles</th>
                        <th v-if="canEditUser || canDeleteUser" class="users__table-header">Actions</th>
                    </tr>
                    </thead>
                    <tbody>
                    <tr v-for="user in users" :key="user.id" class="users__table-row">
                        <td class="users__table-cell">{{ user.name }}</td>
                        <td class="users__table-cell">{{ user.email }}</td>
                        <td class="users__table-cell">
                            <ul class="users__table-profile-list">
                                <li
                                    v-for="profile in user.profiles" :key="profile.id" class="users__table-profile-item">
                                    {{ profile.name }}
                                </li>
                            </ul>
                        </td>
                        <td v-if="canEditUser || canDeleteUser" class="users__table-cell">
                            <PrimaryButton
                                type="submit"
                                v-if="canEditUser"
                                label="Edit"
                                @click="openModal('edit', user)"
                                icon="fas fa-edit"
                            />
                            <PrimaryButton
                                type="delete"
                                v-if="canDeleteUser"
                                label="Delete"
                                @click="openModal('delete', user)"
                                icon="fas fa-trash"
                            />
                        </td>
                    </tr>
                    </tbody>
                </table>
            </div>

            <EditUserModal
                :user="selectedUser"
                :profiles="profiles"
                :isOpen="isEditModalOpen"
                @close="closeModal('edit')"
            />
            <DeleteUserModal
                :user="selectedUser"
                :isOpen="isDeleteModalOpen"
                @close="closeModal('delete')"
            />
        </div>
    </AuthenticatedLayout>
</template>
