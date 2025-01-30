<script setup>
import { Head } from '@inertiajs/vue3';
import PIMLayout from "@/Layouts/PIMLayout.vue";
import AttributeCreateModal from '@/Components/Admin/Data/Attributes/AttributeCreateModal.vue';
import AttributeEditModal from '@/Components/Admin/Data/Attributes/AttributeEditModal.vue';
import AttributeDeleteModal from '@/Components/Admin/Data/Attributes/AttributeDeleteModal.vue';
import AttributesSection from '@/Pages/Attributes/AttributesSection.vue';
import AttributesTable from '@/Pages/Attributes/AttributesTable.vue';
import useEntityTable from '@/composables/useEntityTable';

/**
 * Props passed to the component.
 * @property {Boolean} canCreateAttribute - Indicates if the user can create a new attribute.
 * @property {Boolean} canEditAttribute - Indicates if the user can edit an attribute.
 * @property {Boolean} canDeleteAttribute - Indicates if the user can delete an attribute.
 */
const props = defineProps({
    canCreateAttribute: Boolean,
    canEditAttribute: Boolean,
    canDeleteAttribute: Boolean,
});

/**
 * Destructure properties and methods from the useEntityTable composable.
 * @property {Ref<Boolean>} showCreateModal - Reactive reference for the visibility of the create modal.
 * @property {Ref<Boolean>} showEditModal - Reactive reference for the visibility of the edit modal.
 * @property {Ref<Boolean>} showDeleteModal - Reactive reference for the visibility of the delete modal.
 * @property {Ref<Object|null>} itemToEdit - Reactive reference for the item to edit.
 * @property {Ref<Object|null>} itemToDelete - Reactive reference for the item to delete.
 * @property {Ref<String>} searchQuery - Reactive reference for the search query.
 * @property {Ref<Array>} types - Reactive reference for the types of attributes.
 * @property {Ref<Object>} sortConfig - Reactive reference for the sorting configuration.
 * @property {Function} openModal - Function to open a modal.
 * @property {Function} closeModal - Function to close a modal.
 * @property {ComputedRef<Array>} sortedItems - Computed reference for the sorted attributes.
 * @property {Function} sortColumn - Function to sort the table by a specified column.
 */
const {
    showCreateModal,
    showEditModal,
    showDeleteModal,
    itemToEdit,
    itemToDelete,
    searchQuery,
    types,
    sortConfig,
    openModal,
    closeModal,
    sortedItems: sortedAttributes,
    sortColumn,
} = useEntityTable('attributes');
</script>

<template>
    <!-- Set the page title -->
    <Head title="Mini-Pim | Attributes"/>

    <!-- Main layout component -->
    <PIMLayout>
        <div class="attributes">
            <div class="attributes__header">
                <h1 class="attributes__title">Attributes</h1>
            </div>

            <!-- Section for attribute creation and search -->
            <AttributesSection
                :canCreateAttribute="props.canCreateAttribute"
                v-model:searchQuery="searchQuery"
                :openModal="openModal"
            />

            <!-- Table displaying the attributes -->
            <AttributesTable
                :attributes="sortedAttributes"
                :sortConfig="sortConfig"
                :canEditAttribute="props.canEditAttribute"
                :canDeleteAttribute="props.canDeleteAttribute"
                :sortColumn="sortColumn"
                :openModal="openModal"
            />

            <!-- Modal for creating a new attribute -->
            <AttributeCreateModal
                :isOpen="showCreateModal"
                :types="types"
                @close="closeModal('create')"
            />
            <!-- Modal for editing an existing attribute -->
            <AttributeEditModal
                :isOpen="showEditModal"
                :attribute="itemToEdit"
                :types="types"
                @close="closeModal('edit')"
            />
            <!-- Modal for deleting an attribute -->
            <AttributeDeleteModal
                :isOpen="showDeleteModal"
                :attribute="itemToDelete"
                @close="closeModal('delete')"
            />
        </div>
    </PIMLayout>
</template>
