<script setup>
import { Head } from '@inertiajs/vue3';
import PIMLayout from "@/Layouts/PIMLayout.vue";
import TypeCreateModal from '@/Components/Admin/Data/Types/TypeCreateModal.vue';
import TypeEditModal from '@/Components/Admin/Data/Types/TypeEditModal.vue';
import TypeDeleteModal from '@/Components/Admin/Data/Types/TypeDeleteModal.vue';
import TypesSection from '@/Pages/Types/TypesSection.vue';
import TypesTable from '@/Pages/Types/TypesTable.vue';
import useEntityTable from '@/composables/useEntityTable';

/**
 * Props passed to the component.
 * @property {Boolean} canCreateType - Indicates if the user can create a new type.
 * @property {Boolean} canEditType - Indicates if the user can edit a type.
 * @property {Boolean} canDeleteType - Indicates if the user can delete a type.
 */
const props = defineProps({
    canCreateType: Boolean,
    canEditType: Boolean,
    canDeleteType: Boolean,
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
 * @property {ComputedRef<Array>} sortedItems - Computed reference for the sorted types.
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
    sortedItems: sortedTypes,
    sortColumn,
} = useEntityTable('types');
</script>

<template>
    <!-- Set the page title -->
    <Head title="Mini-Pim | Types"/>

    <!-- Main layout component -->
    <PIMLayout>
        <div class="types">
            <div class="types__header">
                <h1 class="types__title">Types</h1>
            </div>

            <!-- Section for type creation and search -->
            <TypesSection
                :canCreateType="props.canCreateType"
                v-model:searchQuery="searchQuery"
                :openModal="openModal"
            />

            <!-- Table displaying the types -->
            <TypesTable
                :types="sortedTypes"
                :sortConfig="sortConfig"
                :canEditType="props.canEditType"
                :canDeleteType="props.canDeleteType"
                :sortColumn="sortColumn"
                :openModal="openModal"
            />

            <!-- Modal for creating a new type -->
            <TypeCreateModal
                :isOpen="showCreateModal"
                @close="closeModal('create')"
            />
            <!-- Modal for editing an existing type -->
            <TypeEditModal
                :isOpen="showEditModal"
                :type="itemToEdit"
                @close="closeModal('edit')"
            />
            <!-- Modal for deleting a type -->
            <TypeDeleteModal
                :isOpen="showDeleteModal"
                :type="itemToDelete"
                @close="closeModal('delete')"
            />
        </div>
    </PIMLayout>
</template>
