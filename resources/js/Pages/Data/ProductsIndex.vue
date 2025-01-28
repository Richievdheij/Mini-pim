<script setup>
import { ref, computed } from "vue";
import {Head, router, usePage } from "@inertiajs/vue3";
import ProductCreateModal from "@/Components/Admin/Data/Products/ProductCreateModal.vue";
import ProductEditModal from "@/Components/Admin/Data/Products/ProductEditModal.vue";
import ProductDeleteModal from "@/Components/Admin/Data/Products/ProductDeleteModal.vue";
import PIMLayout from "@/Layouts/PIMLayout.vue";
import PrimaryButton from "@/Components/General/PrimaryButton.vue";
import SecondaryButton from "@/Components/General/SecondaryButton.vue";
import Searchbar from "@/Components/General/Searchbar.vue";
import Filter from "@/Components/General/Filter.vue";

// Props and context
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

// Sort function
function sortColumn(column) {
    const {direction} = sortConfig.value;
    let newDirection = direction === "asc" ? "desc" : direction === "desc" ? "none" : "asc";

    sortConfig.value = {
        column,
        direction: newDirection,
    };
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
            <div class="products__section">
                <div class="products__top-bar">
                    <!-- Create Button -->
                    <div v-if="props.canCreateProduct" class="products__create-button">
                        <PrimaryButton
                            label="Create New Product"
                            icon="fas fa-plus"
                            type="cancel"
                            @click="openModal('create')"
                        />
                    </div>

                    <!-- Search Bar -->
                    <div class="products__search-bar">
                        <Searchbar
                            id="search"
                            placeholder="Search..."
                            v-model="searchQuery"
                        />
                    </div>

                    <!-- Filter -->
                    <div class="products__filter">
                        <Filter/>
                    </div>
                </div>

                <!-- Table -->
                <table class="products__table">
                    <thead>
                    <tr class="products__table-header">
                        <th class="products__table-header-cell" @click="sortColumn('product_id')">
                            Product ID
                            <i :class="{
                                    'fas fa-sort-up': sortConfig.column === 'product_id' && sortConfig.direction === 'asc',
                                    'fas fa-sort-down': sortConfig.column === 'product_id' && sortConfig.direction === 'desc'}">
                            </i>
                        </th>
                        <th class="products__table-header-cell" @click="sortColumn('name')">
                            Name
                            <i :class="{
                                    'fas fa-sort-up': sortConfig.column === 'name' && sortConfig.direction === 'asc',
                                    'fas fa-sort-down': sortConfig.column === 'name' && sortConfig.direction === 'desc'}">
                            </i>
                        </th>
                        <th class="products__table-header-cell" @click="sortColumn('type')">
                            Type
                            <i :class="{
                                    'fas fa-sort-up': sortConfig.column === 'type' && sortConfig.direction === 'asc',
                                    'fas fa-sort-down': sortConfig.column === 'type' && sortConfig.direction === 'desc'}">
                            </i>
                        </th>
                        <th v-if="props.canEditProduct || props.canDeleteProduct"
                            class="products__table-header-cell"></th>
                    </tr>
                    </thead>
                    <tbody class="products__table-body">
                    <tr v-for="product in sortedProducts" :key="product.id" class="products__table-row">
                        <td class="products__table-cell">{{ product.product_id }}</td>
                        <td class="products__table-cell">{{ product.name }}</td>
                        <td class="products__table-cell">{{ product.type ? product.type.name : 'No Type' }}</td>
                        <td v-if="props.canEditProduct || props.canDeleteProduct" class="products__table-cell">
                            <div class="products__actions">
                                <SecondaryButton
                                    v-if="props.canEditProduct"
                                    label=""
                                    type="submit"
                                    icon="fas fa-edit"
                                    @click="openModal('edit', product)"
                                />
                                <SecondaryButton
                                    v-if="props.canDeleteProduct"
                                    label=""
                                    type="delete"
                                    icon="fas fa-trash"
                                    @click="openModal('delete', product)"
                                />
                            </div>
                        </td>
                    </tr>
                    </tbody>
                </table>

                <!-- Show message if no Products match the search -->
                <div v-if="filteredProducts.length === 0" class="products__no-results">
                    <p>No results found</p>
                </div>
            </div>

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
