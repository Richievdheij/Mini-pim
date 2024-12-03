<script setup>
import { usePage } from '@inertiajs/vue3';

const { products } = usePage().props;

function goToCreate() {
    window.location.href = route('products.create');
}

function editProduct(id) {
    window.location.href = route('products.edit', id);
}

function deleteProduct(id) {
    if (confirm('Are you sure you want to delete this product?')) {
        window.location.href = route('products.destroy', id);
    }
}
</script>
<template>
    <div>
        <h1>Products</h1>
        <button @click="goToCreate">+ New Product</button>
        <table>
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
                    <button @click="editProduct(product.id)">Edit</button>
                    <button @click="deleteProduct(product.id)">Delete</button>
                </td>
            </tr>
            </tbody>
        </table>
    </div>
</template>


