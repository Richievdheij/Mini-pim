<script setup>
import { ref, computed } from "vue";
import { Head } from "@inertiajs/vue3";
import CreateUserModal from "@/Components/Admin/Users/CreateUserModal.vue";
import EditUserModal from "@/Components/Admin/Users/EditUserModal.vue";
import DeleteUserModal from "@/Components/Admin/Users/DeleteUserModal.vue";
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import PrimaryButton from "@/Components/General/PrimaryButton.vue";
import Input from "@/Components/General/Input.vue";

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

const filteredUsers = computed(() => {
    return (props.users || []).filter((user) =>
        user.name.toLowerCase().includes(searchQuery.value.toLowerCase()) ||
        user.email.toLowerCase().includes(searchQuery.value.toLowerCase())
    );
});
</script>

<template>
    <Head title="Users"/>
    <AuthenticatedLayout>
        <div class="users">
            <div class="users__header">
                <h1 class="users__title">Users</h1>
            </div>

            <div class="users__section">
                <div class="users__top-bar">
                    <!-- Create User Button -->
                    <div class="users__create-button" v-if="props.canCreateUser">
                        <PrimaryButton
                            v-if="props.canCreateUser"
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
                    <tr>
                        <th>Name</th>
                        <th>Email</th>
                        <th>Profiles</th>
                        <th v-if="props.canEditUser || props.canDeleteUser">Actions</th>
                    </tr>
                    </thead>
                    <tbody>
                    <tr
                        v-for="user in filteredUsers"
                        :key="user.id"
                    >
                        <td>{{ user.name }}</td>
                        <td>{{ user.email }}</td>
                        <td>
                            <ul>
                                <li
                                    v-for="profile in user.profiles"
                                    :key="profile.id"
                                >
                                    {{ profile.name }}
                                </li>
                            </ul>
                        </td>
                        <td>
                            <PrimaryButton
                                v-if="props.canEditUser"
                                type="submit"
                                label="Edit"
                                @click="openModal('edit', user)"
                                icon="fas fa-edit"
                            />
                            <PrimaryButton
                                v-if="props.canDeleteUser"
                                type="delete"
                                label="Delete"
                                @click="openModal('delete', user)"
                                icon="fas fa-trash"
                            />
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
