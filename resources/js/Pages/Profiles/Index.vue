<script setup>
import { Head } from '@inertiajs/vue3';
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import CreateProfileModal from '@/Components/Admin/Profiles/CreateProfileModal.vue';
import EditProfileModal from '@/Components/Admin/Profiles/EditProfileModal.vue';
import DeleteProfileModal from '@/Components/Admin/Profiles/DeleteProfileModal.vue';
import ProfilesSection from '@/Pages/Profiles/ProfilesSection.vue';
import ProfilesTable from '@/Pages/Profiles/ProfilesTable.vue';
import useEntityTable from '@/composables/useEntityTable';

/**
 * Props passed to the component.
 * @property {Boolean} canCreateProfile - Indicates if the user can create a new profile.
 * @property {Boolean} canEditProfile - Indicates if the user can edit a profile.
 * @property {Boolean} canDeleteProfile - Indicates if the user can delete a profile.
 */
const props = defineProps({
    canCreateProfile: Boolean,
    canEditProfile: Boolean,
    canDeleteProfile: Boolean,
});

/**
 * Destructure properties and methods from the useEntityTable composable.
 * @property {Ref<Boolean>} showCreateModal - Reactive reference for the visibility of the create modal.
 * @property {Ref<Boolean>} showEditModal - Reactive reference for the visibility of the edit modal.
 * @property {Ref<Boolean>} showDeleteModal - Reactive reference for the visibility of the delete modal.
 * @property {Ref<Object|null>} itemToEdit - Reactive reference for the item to edit.
 * @property {Ref<Object|null>} itemToDelete - Reactive reference for the item to delete.
 * @property {Ref<String>} searchQuery - Reactive reference for the search query.
 * @property {Ref<Object>} sortConfig - Reactive reference for the sorting configuration.
 * @property {Function} openModal - Function to open a modal.
 * @property {Function} closeModal - Function to close a modal.
 * @property {ComputedRef<Array>} sortedItems - Computed reference for the sorted profiles.
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
    sortedItems: sortedProfiles,
    sortColumn,
} = useEntityTable('profiles');
</script>

<template>
    <!-- Set the page title -->
    <Head title="Mini-Pim | Profiles"/>

    <!-- Main layout component -->
    <AuthenticatedLayout>
        <div class="profiles">
            <div class="profiles__header">
                <h1 class="profiles__title">Profiles</h1>
            </div>

            <!-- Section for profile creation and search -->
            <ProfilesSection
                :canCreateProfile="props.canCreateProfile"
                v-model:searchQuery="searchQuery"
                :openModal="openModal"
            />

            <!-- Table displaying the profiles -->
            <ProfilesTable
                :profiles="sortedProfiles"
                :sortConfig="sortConfig"
                :canEditProfile="props.canEditProfile"
                :canDeleteProfile="props.canDeleteProfile"
                :sortColumn="sortColumn"
                :openModal="openModal"
            />

            <!-- Modal for creating a new profile -->
            <CreateProfileModal
                :isOpen="showCreateModal"
                @close="closeModal('create')"
            />
            <!-- Modal for editing an existing profile -->
            <EditProfileModal
                :isOpen="showEditModal"
                :profile="itemToEdit"
                @close="closeModal('edit')"
            />
            <!-- Modal for deleting a profile -->
            <DeleteProfileModal
                :isOpen="showDeleteModal"
                :profile="itemToDelete"
                @close="closeModal('delete')"
            />
        </div>
    </AuthenticatedLayout>
</template>
