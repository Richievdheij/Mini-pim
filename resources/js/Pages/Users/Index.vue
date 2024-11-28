<script setup>
import { ref, computed } from "vue";
import { Head } from "@inertiajs/vue3";
import CreateUserModal from "@/Components/Admin/Users/CreateUserModal.vue";
import EditUserModal from "@/Components/Admin/Users/EditUserModal.vue";
import DeleteUserModal from "@/Components/Admin/Users/DeleteUserModal.vue";
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import PrimaryButton from "@/Components/General/PrimaryButton.vue";
import Input from "@/Components/General/Input.vue";
import TertiaryButton from "@/Components/General/TertiaryButton.vue";
import SecondaryButton from "@/Components/General/SecondaryButton.vue";

const props = defineProps({
    users: Array,
    profiles: Array,
    canEditUser: Boolean,
    canDeleteUser: Boolean,
    canCreateUser: Boolean,
});

const isEditModalOpen = ref(false);
const isDeleteModalOpen = ref(false);
const isCreateModalOpen = ref(false);
const selectedUser = ref(null);
const searchQuery = ref("");

// Open modal for create/edit/delete
function openModal(modalType, user = null) {
    selectedUser.value = user;

    if (modalType === "edit") {
        isEditModalOpen.value = true;
    } else if (modalType === "delete") {
        isDeleteModalOpen.value = true;
    } else if (modalType === "create") {
        isCreateModalOpen.value = true;
    }
}

// Close modal for create/edit/delete
function closeModal(modalType) {
    selectedUser.value = null;

    if (modalType === "edit") {
        isEditModalOpen.value = false;
    } else if (modalType === "delete") {
        isDeleteModalOpen.value = false;
    } else if (modalType === "create") {
        isCreateModalOpen.value = false;
    }
}

// Filter users based on search query
const filteredUsers = computed(() => {
    return (props.users || []).filter((user) =>
        user.name.toLowerCase().includes(searchQuery.value.toLowerCase()) ||
        user.email.toLowerCase().includes(searchQuery.value.toLowerCase())
    );
});

// Add computed property to check if the profile is the current one
const isCurrentProfile = (profileId, userProfiles) => {
    return userProfiles.some(profile => profile.id === profileId);
};
</script>

<template>
    <Head title="Mini-Pim | Users"/>

    <AuthenticatedLayout>
        <div class="users">
            <!-- Header -->
            <div class="users__header">
                <h1 class="users__title">Users</h1>
            </div>

            <!-- Section -->
            <div class="users__section">
                <div class="users__top-bar">
                    <!-- Create User Button -->
                    <div class="users__create-button" v-if="props.canCreateUser">
                        <PrimaryButton
                            label="Create New User"
                            type="cancel"
                            icon="fas fa-plus"
                            @click="openModal('create')"
                        />
                    </div>

                    <!-- Search Bar -->
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
                    <thead>
                    <tr class="users__table-header">
                        <th class="users__table-header-cell">Name</th>
                        <th class="users__table-header-cell">Email</th>
                        <th class="users__table-header-cell">Profiles</th>
                        <th v-if="props.canEditUser || props.canDeleteUser" class="users__table-header-cell"></th>
                    </tr>
                    </thead>
                    <tbody class="users__table-body">
                    <tr v-for="user in filteredUsers" :key="user.id" class="users__table-row">
                        <td class="users__table-cell">{{ user.name }}</td>
                        <td class="users__table-cell">{{ user.email }}</td>
                        <td class="users__table-cell">
                            <ul class="users__table-profile">
                                <li
                                    v-for="profile in user.profiles"
                                    :key="profile.id"
                                    :class="['users__table-profile-item', { 'users__table-profile-item--current': isCurrentProfile(profile.id, user.profiles) }]"
                                >
                                    {{ profile.name }}
                                </li>
                            </ul>
                        </td>
                        <td v-if="props.canEditUser || props.canDeleteUser" class="users__table-cell">
                            <div class="users__table-actions">
                                <SecondaryButton
                                    v-if="props.canEditUser"
                                    type="submit"
                                    label=""
                                    @click="openModal('edit', user)"
                                    icon="fas fa-edit"
                                />
                                <SecondaryButton
                                    v-if="props.canDeleteUser"
                                    type="delete"
                                    label=""
                                    @click="openModal('delete', user)"
                                    icon="fas fa-trash"
                                />
                            </div>
                        </td>
                    </tr>
                    </tbody>
                </table>
            </div>

            <!-- Modals -->
            <CreateUserModal
                :profiles="props.profiles"
                :isOpen="isCreateModalOpen"
                @close="closeModal('create')"
            />
            <EditUserModal
                :user="selectedUser"
                :profiles="props.profiles"
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
