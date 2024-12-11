<script setup>
import { ref, computed } from "vue";
import { Head } from "@inertiajs/vue3";
import CreateUserModal from "@/Components/Admin/Users/CreateUserModal.vue";
import EditUserModal from "@/Components/Admin/Users/EditUserModal.vue";
import DeleteUserModal from "@/Components/Admin/Users/DeleteUserModal.vue";
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import PrimaryButton from "@/Components/General/PrimaryButton.vue";
import Filter from '@/Components/General/Filter.vue';
import SecondaryButton from "@/Components/General/SecondaryButton.vue";
import Searchbar from "@/Components/General/Searchbar.vue";

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

// Sort configuration state
const sortConfig = ref({
    column: null,
    direction: 'none',  // 'none', 'asc', or 'desc'
});

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

// Sorting function
function sortColumn(column) {
    const {direction} = sortConfig.value;
    let newDirection = 'asc';

    if (direction === 'asc') {
        newDirection = 'desc';
    } else if (direction === 'desc') {
        newDirection = 'none';
    }

    sortConfig.value = {
        column,
        direction: newDirection,
    };
}

// Sorted users
const sortedUsers = computed(() => {
    const {column, direction} = sortConfig.value;
    let usersToSort = [...filteredUsers.value];

    if (column && direction !== 'none') {
        usersToSort.sort((a, b) => {
            let aValue = a[column];
            let bValue = b[column];

            // Special handling for the 'profiles' column
            if (column === "profiles") {
                aValue = a.profiles && a.profiles.length > 0 ? a.profiles[0].name : ""; // Get the first profile name
                bValue = b.profiles && b.profiles.length > 0 ? b.profiles[0].name : "";
            }

            if (direction === 'asc') {
                return aValue > bValue ? 1 : -1;
            } else {
                return aValue < bValue ? 1 : -1;
            }
        });
    }

    return usersToSort;
});
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
                    <div class="users__create-button" v-if="props.canCreateUser">
                        <PrimaryButton
                            label="Create New User"
                            type="cancel"
                            icon="fas fa-plus"
                            @click="openModal('create')"
                        />
                    </div>

                    <div class="users__search-bar">
                        <Searchbar
                            id="search"
                            placeholder="Search..."
                            v-model="searchQuery"
                        />
                    </div>

                    <div class="users__filter">
                        <Filter/>
                    </div>
                </div>

                <!-- Table -->
                <table class="users__table">
                    <thead>
                    <tr class="users__table-header">
                        <th
                            class="users__table-header-cell"
                            @click="sortColumn('name')"
                        >
                            Name
                            <i :class="{'fas fa-sort-up'
                               :sortConfig.column === 'name' && sortConfig.direction === 'asc', 'fas fa-sort-down'
                               :sortConfig.column === 'name' && sortConfig.direction === 'desc'}">
                            </i>
                        </th>
                        <th
                            class="users__table-header-cell"
                            @click="sortColumn('email')"
                        >
                            Email
                            <i :class="{'fas fa-sort-up'
                               :sortConfig.column === 'email' && sortConfig.direction === 'asc', 'fas fa-sort-down'
                               :sortConfig.column === 'email' && sortConfig.direction === 'desc'}">
                            </i>
                        </th>
                        <th
                            class="users__table-header-cell"
                            @click="sortColumn('profiles')"
                        >
                            Profiles
                            <i
                                :class="{'fas fa-sort-up'
                                :sortConfig.column === 'profiles' && sortConfig.direction === 'asc', 'fas fa-sort-down'
                                :sortConfig.column === 'profiles' && sortConfig.direction === 'desc'}">
                            </i>
                        </th>
                        <th v-if="props.canEditUser || props.canDeleteUser" class="users__table-header-cell"></th>
                    </tr>
                    </thead>
                    <tbody class="users__table-body">
                    <tr v-for="user in sortedUsers" :key="user.id" class="users__table-row">
                        <td class="users__table-cell">{{ user.name }}</td>
                        <td class="users__table-cell">{{ user.email }}</td>
                        <td class="users__table-cell">{{ user.profiles.map(p => p.name).join(", ") }}</td>
                        <td v-if="props.canEditUser || props.canDeleteUser" class="users__table-cell">
                            <div class="users__actions">
                                <SecondaryButton
                                    v-if="props.canEditUser"
                                    type="submit"
                                    label=""
                                    icon="fas fa-edit"
                                    @click="openModal('edit', user)"
                                />
                                <SecondaryButton
                                    v-if="props.canDeleteUser"
                                    type="delete"
                                    label=""
                                    icon="fas fa-trash"
                                    @click="openModal('delete', user)"
                                />
                            </div>
                        </td>
                    </tr>
                    </tbody>
                </table>

                <!-- Show message if no users match the search -->
                <div v-if="filteredUsers.length === 0" class="users__no-results">
                    <p>No results found</p>
                </div>
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
