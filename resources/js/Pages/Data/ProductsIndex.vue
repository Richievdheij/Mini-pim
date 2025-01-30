<script setup>
import { Head } from '@inertiajs/vue3';
import PIMLayout from "@/Layouts/PIMLayout.vue";
import ProductCreateModal from '@/Components/Admin/Data/Products/ProductCreateModal.vue';
import ProductEditModal from '@/Components/Admin/Data/Products/ProductEditModal.vue';
import ProductDeleteModal from '@/Components/Admin/Data/Products/ProductDeleteModal.vue';
import ProductsSection from '@/Pages/Data/ProductsSection.vue';
import ProductsTable from '@/Pages/Data/ProductsTable.vue';
import useEntityTable from '@/composables/useEntityTable';

/**
 * Props passed to the component.
 * @property {Boolean} canCreateProduct - Indicates if the user can create a new product.
 * @property {Boolean} canEditProduct - Indicates if the user can edit a product.
 * @property {Boolean} canDeleteProduct - Indicates if the user can delete a product.
 */
const props = defineProps({
    canCreateProduct: Boolean,
    canEditProduct: Boolean,
    canDeleteProduct: Boolean,
});

/**
 * Destructure properties and methods from the useEntityTable composable.
 * @property {Ref<Boolean>} showCreateModal - Reactive reference for the visibility of the create modal.
 * @property {Ref<Boolean>} showEditModal - Reactive reference for the visibility of the edit modal.
 * @property {Ref<Boolean>} showDeleteModal - Reactive reference for the visibility of the delete modal.
 * @property {Ref<Object|null>} itemToEdit - Reactive reference for the item to edit.
 * @property {Ref<Object|null>} itemToDelete - Reactive reference for the item to delete.
 * @property {Ref<String>} searchQuery - Reactive reference for the search query.
 * @property {Ref<Array>} types - Reactive reference for the types of products.
 * @property {Ref<Object>} sortConfig - Reactive reference for the sorting configuration.
 * @property {Function} openModal - Function to open a modal.
 * @property {Function} closeModal - Function to close a modal.
 * @property {ComputedRef<Array>} sortedItems - Computed reference for the sorted products.
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
    sortedItems: sortedProducts,
    sortColumn,
} = useEntityTable('products');
</script>

<template>
    <!-- Set the page title -->
    <Head title="Mini-Pim | Products"/>

    <!-- Main layout component -->
    <PIMLayout>
        <div class="products">
            <div class="products__header">
                <h1 class="products__title">Products</h1>
            </div>

            <!-- Section for product creation and search -->
            <ProductsSection
                :canCreateProduct="props.canCreateProduct"
                v-model:searchQuery="searchQuery"
                :openModal="openModal"
            />

            <!-- Table displaying the products -->
            <ProductsTable
                :products="sortedProducts"
                :sortConfig="sortConfig"
                :canEditProduct="props.canEditProduct"
                :canDeleteProduct="props.canDeleteProduct"
                :sortColumn="sortColumn"
                :openModal="openModal"
            />

            <!-- Modal for creating a new product -->
            <ProductCreateModal
                :isOpen="showCreateModal"
                :types="types"
                @close="closeModal('create')"
            />
            <!-- Modal for editing an existing product -->
            <ProductEditModal
                :isOpen="showEditModal"
                :product="itemToEdit"
                :types="types"
                @close="closeModal('edit')"
            />
            <!-- Modal for deleting a product -->
            <ProductDeleteModal
                :isOpen="showDeleteModal"
                :product="itemToDelete"
                @close="closeModal('delete')"
            />
        </div>
    </PIMLayout>
</template>
