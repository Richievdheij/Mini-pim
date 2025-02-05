<script setup>
import { Head } from '@inertiajs/vue3';
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import CreateUserModal from '@/Components/Admin/Users/CreateUserModal.vue';
import EditUserModal from '@/Components/Admin/Users/EditUserModal.vue';
import DeleteUserModal from '@/Components/Admin/Users/DeleteUserModal.vue';
import UsersSection from '@/Pages/Users/UsersSection.vue';
import UsersTable from '@/Pages/Users/UsersTable.vue';
import useEntityTable from '@/composables/useEntityTable';

/**
 * Props passed to the component.
 * @property {Boolean} canCreateUser - Indicates if the user can create a new user.
 * @property {Boolean} canEditUser - Indicates if the user can edit a user.
 * @property {Boolean} canDeleteUser - Indicates if the user can delete a user.
 * @property {Array} profiles - List of profiles to be used in the modals.
 */
const props = defineProps({
    canCreateUser: Boolean,
    canEditUser: Boolean,
    canDeleteUser: Boolean,
    profiles: Array,
});

/**
 * Destructure properties and methods from useEntityTable composable.
 * @property {Boolean} showCreateModal - Indicates if the create user modal is visible.
 * @property {Boolean} showEditModal - Indicates if the edit user modal is visible.
 * @property {Boolean} showDeleteModal - Indicates if the delete user modal is visible.
 * @property {Object} itemToEdit - The user item to be edited.
 * @property {Object} itemToDelete - The user item to be deleted.
 * @property {String} searchQuery - The current search query.
 * @property {Object} sortConfig - Configuration object for sorting the table columns.
 * @property {Function} openModal - Function to open a modal.
 * @property {Function} closeModal - Function to close a modal.
 * @property {Array} sortedUsers - List of sorted users.
 * @property {Function} sortColumn - Function to sort the table by a specified column.
 */
const {
    showCreateModal,
    showEditModal,
    showDeleteModal,
    itemToEdit,
    itemToDelete,
    searchQuery,
    sortConfig,
    openModal,
    closeModal,
    sortedItems: sortedUsers,
    sortColumn,
} = useEntityTable('users');
</script>

<template>
    <!-- Set the page title -->
    <Head title="Mini-Pim | Users"/>

    <AuthenticatedLayout>
        <div class="users">
            <div class="users__header">
                <h1 class="users__title">Users</h1>
            </div>

            <!-- Users section with search and create functionality -->
            <UsersSection
                :canCreateUser="props.canCreateUser"
                v-model:searchQuery="searchQuery"
                :openModal="openModal"
            />

            <!-- Users table displaying the list of users -->
            <UsersTable
                :users="sortedUsers"
                :sortConfig="sortConfig"
                :canEditUser="props.canEditUser"
                :canDeleteUser="props.canDeleteUser"
                :sortColumn="sortColumn"
                :openModal="openModal"
            />

            <!-- Modal for creating a new user -->
            <CreateUserModal
                :isOpen="showCreateModal"
                :profiles="props.profiles"
                @close="closeModal('create')"
            />
            <!-- Modal for editing an existing user -->
            <EditUserModal
                :isOpen="showEditModal"
                :user="itemToEdit"
                :profiles="props.profiles"
                @close="closeModal('edit')"
            />
            <!-- Modal for deleting an existing user -->
            <DeleteUserModal
                :isOpen="showDeleteModal"
                :user="itemToDelete"
                @close="closeModal('delete')"
            />
        </div>
    </AuthenticatedLayout>
</template>
