<script setup>
import { ref, computed } from "vue";
import { Head, router } from "@inertiajs/vue3";
import CreateUserModal from "@/Components/Admin/Users/CreateUserModal.vue";
import EditUserModal from "@/Components/Admin/Users/EditUserModal.vue";
import DeleteUserModal from "@/Components/Admin/Users/DeleteUserModal.vue";
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import UsersSection from '@/Pages/Users/UsersSection.vue';
import UsersTable from '@/Pages/Users/UsersTable.vue';

const props = defineProps({
    users: Array,
    profiles: Array,
    canEditUser: Boolean,
    canDeleteUser: Boolean,
    canCreateUser: Boolean,
});

// Modals state
const isEditModalOpen = ref(false);
const isDeleteModalOpen = ref(false);
const isCreateModalOpen = ref(false);
const selectedUser = ref(null);
const searchQuery = ref("");

// Sort configuration state
const sortConfig = ref({
    column: null,
    direction: 'none',
});

// Open modal for create/edit/delete
function openModal(modalType, user = null) {
    selectedUser.value = user;

    switch (modalType) {
        case "edit":
            isEditModalOpen.value = true;
            break;
        case "delete":
            isDeleteModalOpen.value = true;
            break;
        case "create":
            isCreateModalOpen.value = true;
            break;
    }
}

// Close modal for create/edit/delete and reload users
function closeModal(modalType) {
    selectedUser.value = null;

    switch (modalType) {
        case "edit":
            isEditModalOpen.value = false;
            break;
        case "delete":
            isDeleteModalOpen.value = false;
            break;
        case "create":
            isCreateModalOpen.value = false;
            break;
    }

    // Reload users
    try {
        router.reload({ only: ['users'] });
    } catch (error) {
        console.error("Error reloading users:", error);
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
    const { direction } = sortConfig.value;
    const newDirection = direction === "asc" ? "desc" : direction === "desc" ? "none" : "asc";

    sortConfig.value = { column, direction: newDirection };
}

// Sorted users
const sortedUsers = computed(() => {
    const { column, direction } = sortConfig.value;
    let usersToSort = [...filteredUsers.value];

    if (column && direction !== 'none') {
        usersToSort.sort((a, b) => {
            let aValue = a[column];
            let bValue = b[column];

            if (column === "profiles") {
                aValue = a.profiles && a.profiles.length > 0 ? a.profiles[0].name : "";
                bValue = b.profiles && b.profiles.length > 0 ? b.profiles[0].name : "";
            }

            return direction === 'asc' ? aValue.localeCompare(bValue) : bValue.localeCompare(aValue);
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
            <UsersSection
                :canCreateUser="props.canCreateUser"
                v-model:searchQuery="searchQuery"
                :openModal="openModal"
            />

            <!-- Users Table -->
            <UsersTable
                :users="sortedUsers"
                :sortConfig="sortConfig"
                :canEditUser="props.canEditUser"
                :canDeleteUser="props.canDeleteUser"
                :sortColumn="sortColumn"
                :openModal="openModal"
            />

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
