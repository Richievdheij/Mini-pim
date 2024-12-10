<script setup>
import { ref } from "vue";
import { usePage } from "@inertiajs/vue3";
import ProductCreateModal from "@/Components/Admin/Data/Products/ProductCreateModal.vue";
import ProductEditModal from "@/Components/Admin/Data/Products/ProductEditModal.vue";

const { products } = usePage().props;

const showCreateModal = ref(false);
const showEditModal = ref(false);
const productToEdit = ref(null);

// Open create modal
function toggleCreateModal() {
    console.log("Toggle Create Modal triggered");
    showCreateModal.value = !showCreateModal.value;
    console.log("showCreateModal:", showCreateModal.value);
}

// Open edit modal with selected product
function toggleEditModal(product = null) {
    console.log("Toggle Edit Modal triggered with product:", product);
    productToEdit.value = product;
    showEditModal.value = !showEditModal.value;
    console.log("showEditModal:", showEditModal.value);
}

// Handle successful product creation
function handleProductCreated(newProduct) {
    products.push(newProduct); // Add the new product dynamically
}

// Handle successful product edit
function handleProductUpdated(updatedProduct) {
    const index = products.findIndex((p) => p.id === updatedProduct.id);
    if (index !== -1) {
        products[index] = updatedProduct;
    }
}
</script>

<template>
    <div>
        <h1 class="page-title">Products</h1>
        <div class="table-header">
            <button @click="toggleCreateModal" class="btn btn-primary">+ Create New Product</button>
        </div>
        <div class="table-container">
            <table class="styled-table">
                <thead>
                <tr>
                    <th>Product ID</th>
                    <th>Name</th>
                    <th>Type</th>
                    <th>Actions</th>
                </tr>
                </thead>
                <tbody>
                <tr v-for="product in products" :key="product.id">
                    <td>{{ product.product_id }}</td>
                    <td>{{ product.name }}</td>
                    <td>{{ product.type.name }}</td>
                    <td>
                        <button class="action-btn edit-btn" @click="toggleEditModal(product)">
                            <i class="fa fa-edit"></i>
                        </button>
                        <button class="action-btn delete-btn" @click="() => $inertia.delete(route('products.destroy', product.id))">
                            <i class="fa fa-trash"></i>
                        </button>
                    </td>
                </tr>
                </tbody>
            </table>
        </div>

        <!-- Modals -->
        <ProductCreateModal
            v-if="showCreateModal"
            @close="toggleCreateModal"
            @productCreated="handleProductCreated"
        />
        <ProductEditModal
            v-if="showEditModal"
            :product="productToEdit"
            @close="toggleEditModal"
            @productUpdated="handleProductUpdated"
        />
    </div>
</template>

<style scoped>
/* Page Title */
.page-title {
    font-size: 1.8rem;
    font-weight: bold;
    margin-bottom: 1.5rem;
    color: #333;
}

/* Table Header */
.table-header {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-bottom: 1rem;
}

.btn {
    padding: 0.6rem 1.2rem;
    font-size: 1rem;
    cursor: pointer;
    border: none;
    border-radius: 4px;
    transition: background-color 0.3s ease;
}

.btn-primary {
    background-color: #567AC5FF;
    color: #fff;
}

.btn-primary:hover {
    background-color: #0056b3;
}

/* Table Styles */
.table-container {
    overflow-x: auto;
}

.styled-table {
    width: 100%;
    border-collapse: collapse;
    font-size: 1rem;
    text-align: left;
    border: 1px solid #ddd;
    background-color: #fff;
}

.styled-table thead th {
    background-color: #567AC5FF;
    color: #fff;
    padding: 0.8rem;
    text-align: left;
    font-weight: bold;
}

.styled-table tbody td {
    padding: 0.8rem;
    border-top: 1px solid #ddd;
}

.styled-table tbody tr:nth-child(even) {
    background-color: #f9f9f9;
}

.styled-table tbody tr:hover {
    background-color: #f1f1f1;
}

/* Action Buttons */
.action-btn {
    display: inline-flex;
    align-items: center;
    justify-content: center;
    width: 2.5rem;
    height: 2.5rem;
    border: none;
    border-radius: 50%;
    margin: 0 0.2rem;
    font-size: 1.2rem;
    cursor: pointer;
    transition: background-color 0.3s ease;
}

.edit-btn {
    background-color: #6c757d;
    color: #fff;
}

.edit-btn:hover {
    background-color: #5a6268;
}

.delete-btn {
    background-color: #dc3545;
    color: #fff;
}

.delete-btn:hover {
    background-color: #c82333;
}
</style>
