<script setup>
import { ref, computed } from "vue";
import { Head, usePage } from "@inertiajs/vue3";
import ProductCreateModal from "@/Components/Admin/Data/Products/ProductCreateModal.vue";
import ProductEditModal from "@/Components/Admin/Data/Products/ProductEditModal.vue";
import ProductDeleteModal from "@/Components/Admin/Data/Products/ProductDeleteModal.vue";
import PIMLayout from "@/Layouts/PIMLayout.vue";
import PrimaryButton from "@/Components/General/PrimaryButton.vue";
import SecondaryButton from "@/Components/General/SecondaryButton.vue";
import Searchbar from "@/Components/General/Searchbar.vue";
import Filter from "@/Components/General/Filter.vue";

const props = defineProps({
    canCreateProduct: Boolean,
    canEditProduct: Boolean,
    canDeleteProduct: Boolean,
});

const { products, types } = usePage().props;
const attributes = ref([]);

const showCreateModal = ref(false);
const showEditModal = ref(false);
const showDeleteModal = ref(false);
const productToDelete = ref(null);
const selectedProduct = ref(null);
const searchQuery = ref("");

// Sort configuration state
const sortConfig = ref({
    column: null,
    direction: "none", // 'none', 'asc', or 'desc'
});

// Open modal for create/edit/delete
function openModal(modalType, product = null) {
    if (modalType === 'edit') {
        selectedProduct.value = product;
        showEditModal.value = true;
    } else if (modalType === 'delete') {
        productToDelete.value = product; // Fix: Set productToDelete
        showDeleteModal.value = true;
    } else if (modalType === 'create') {
        showCreateModal.value = true;
    }
}

// Close modal for create/edit/delete
function closeModal(modalType) {
    selectedProduct.value = null;

    if (modalType === "edit") {
        showEditModal.value = false;
    } else if (modalType === "delete") {
        showDeleteModal.value = false;
    } else if (modalType === "create") {
        showCreateModal.value = false;
    }
}

// Search and Sorting
const filteredProducts = computed(() => {
    return products
        .filter((product) => product && product.name) // Ensure product and product.name exist
        .filter((product) =>
            product.name.toLowerCase().includes(searchQuery.value.toLowerCase())
        );
});

function sortColumn(column) {
    const { direction } = sortConfig.value;
    let newDirection = "asc";

    if (direction === "asc") {
        newDirection = "desc";
    } else if (direction === "desc") {
        newDirection = "none";
    }

    sortConfig.value = {
        column,
        direction: newDirection,
    };
}

const sortedProducts = computed(() => {
    const { column, direction } = sortConfig.value;
    let productsToSort = [...filteredProducts.value];

    if (column && direction !== "none") {
        productsToSort.sort((a, b) => {
            const aValue = column === "type" ? a[column].name : a[column];
            const bValue = column === "type" ? b[column].name : b[column];

            if (direction === "asc") {
                return aValue.localeCompare(bValue);
            } else {
                return bValue.localeCompare(aValue);
            }
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
                    <div class="products__create-button" v-if="props.canCreateProduct">
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
                        <th
                            class="products__table-header-cell"
                            @click="sortColumn('product_id')"
                        >
                            Product ID
                            <i :class="{
                                    'fas fa-sort-up': sortConfig.column === 'product_id' && sortConfig.direction === 'asc',
                                    'fas fa-sort-down': sortConfig.column === 'product_id' && sortConfig.direction === 'desc'}">
                            </i>
                        </th>
                        <th
                            class="products__table-header-cell"
                            @click="sortColumn('name')"
                        >
                            Name
                            <i :class="{
                                    'fas fa-sort-up': sortConfig.column === 'name' && sortConfig.direction === 'asc',
                                    'fas fa-sort-down': sortConfig.column === 'name' && sortConfig.direction === 'desc'}">
                            </i>
                        </th>
                        <th
                            class="products__table-header-cell"
                            @click="sortColumn('type')"
                        >
                            Type
                            <i :class="{
                                    'fas fa-sort-up': sortConfig.column === 'type' && sortConfig.direction === 'asc',
                                    'fas fa-sort-down': sortConfig.column === 'type' && sortConfig.direction === 'desc'}">
                            </i>
                        </th>
                        <th v-if="props.canEditProduct || props.canDeleteProduct" class="products__table-header-cell"></th>
                    </tr>
                    </thead>
                    <tbody class="products__table-body">
                    <tr v-for="product in sortedProducts" :key="product.id" class="products__table-row">
                        <td class="products__table-cell">{{ product.product_id }}</td>
                        <td class="products__table-cell">{{ product.name }}</td>
                        <td class="products__table-cell">{{ product.type.name }}</td>
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
                :isOpen="showCreateModal"
                :types="types"
                @close="closeModal('create')"
            />
            <ProductEditModal
                :isOpen="showEditModal"
                :product="selectedProduct"
                :types="types"
                :attributes="attributes"
                @close="closeModal('edit')"
            />
            <ProductDeleteModal
                :isOpen="showDeleteModal"
                :product="productToDelete"
                @close="closeModal('delete')"
            />
        </div>
    </PIMLayout>
</template>
