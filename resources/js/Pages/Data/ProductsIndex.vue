<script setup>
import { ref, computed } from "vue";
import { Head, router, usePage } from "@inertiajs/vue3";
import ProductCreateModal from "@/Components/Admin/Data/Products/ProductCreateModal.vue";
import ProductEditModal from "@/Components/Admin/Data/Products/ProductEditModal.vue";
import ProductDeleteModal from "@/Components/Admin/Data/Products/ProductDeleteModal.vue";
import PIMLayout from "@/Layouts/PIMLayout.vue";
import ProductsSection from '@/Pages/Data/ProductsSection.vue';
import ProductsTable from '@/Pages/Data/ProductsTable.vue';

const props = defineProps({
    canCreateProduct: Boolean,
    canEditProduct: Boolean,
    canDeleteProduct: Boolean,
});

const { products, types } = usePage().props;
const attributes = ref([]);

// Modal visibility states
const modalState = ref({
    create: false,
    edit: false,
    delete: false,
});

// Target product for actions
const selectedProduct = ref(null);
const productToDelete = ref(null);

// Search and sorting configuration
const searchQuery = ref("");
const sortConfig = ref({
    column: null,
    direction: "none", // 'none', 'asc', or 'desc'
});

// Open and close modals using a switch-case
function openModal(modalType, product = null) {
    switch (modalType) {
        case 'create':
            modalState.value.create = true;
            break;
        case 'edit':
            selectedProduct.value = product;
            modalState.value.edit = true;
            break;
        case 'delete':
            productToDelete.value = product;
            modalState.value.delete = true;
            break;
    }
}

function closeModal(modalType) {
    // Reset values before closing the modal
    selectedProduct.value = null;
    productToDelete.value = null;

    switch (modalType) {
        case 'create':
            modalState.value.create = false;
            break;
        case 'edit':
            modalState.value.edit = false;
            break;
        case 'delete':
            modalState.value.delete = false;
            break;
    }

    // Reload the products data after closing the modal
    try {
        router.reload({ only: ["products"] });
    } catch (error) {
        console.error("Error reloading products:", error);
    }
}

// Search filtering
const filteredProducts = computed(() => {
    return products
        .filter((product) => product && product.name) // Ensure product and product.name exist
        .filter((product) =>
            product.name.toLowerCase().includes(searchQuery.value.toLowerCase())
        );
});

// Sorting function
function sortColumn(column) {
    const { direction } = sortConfig.value;
    const newDirection = direction === "asc" ? "desc" : direction === "desc" ? "none" : "asc";

    sortConfig.value = { column, direction: newDirection };
}

// Sort products based on the sort configuration
const sortedProducts = computed(() => {
    const {column, direction} = sortConfig.value;
    let productsToSort = [...filteredProducts.value];

    if (column && direction !== "none") {
        productsToSort.sort((a, b) => {
            const aValue = column === "type" ? (a[column] ? a[column].name : '') : a[column];
            const bValue = column === "type" ? (b[column] ? b[column].name : '') : b[column];

            return direction === "asc" ? aValue > bValue ? 1 : -1 : aValue < bValue ? 1 : -1;
        });
    }

    return productsToSort;
});
</script>

<template>
    <Head title="Mini-Pim | Products"/>

    <PIMLayout>
        <div class="products">
            <!-- Header -->
            <div class="products__header">
                <h1 class="products__title">Products</h1>
            </div>

            <!-- Section -->
            <ProductsSection
                :canCreateProduct="props.canCreateProduct"
                v-model:searchQuery="searchQuery"
                :openModal="openModal"
            />

            <!-- Products Table -->
            <ProductsTable
                :products="sortedProducts"
                :sortConfig="sortConfig"
                :canEditProduct="props.canEditProduct"
                :canDeleteProduct="props.canDeleteProduct"
                :sortColumn="sortColumn"
                :openModal="openModal"
            />

            <!-- Modals -->
            <ProductCreateModal
                :isOpen="modalState.create"
                :types="types"
                @close="closeModal('create')"
            />
            <ProductEditModal
                :isOpen="modalState.edit"
                :product="selectedProduct"
                :types="types"
                :attributes="attributes"
                @close="closeModal('edit')"
            />
            <ProductDeleteModal
                :isOpen="modalState.delete"
                :product="productToDelete"
                @close="closeModal('delete')"
            />
        </div>
    </PIMLayout>
</template>
