<script setup>
import { useForm } from '@inertiajs/vue3';
import { usePage } from '@inertiajs/vue3';

const { product, types } = usePage().props;

const form = useForm({
    name: product.name,
    type_id: product.type_id,
    weight: product.weight,
    description: product.description,
    price: product.price,
    stock_quantity: product.stock_quantity,
});

function submit() {
    form.put(route('products.update', product.id));
}
</script>
<template>
    <div>
        <h1>Edit Product</h1>
        <form @submit.prevent="submit">
            <label>
                Name:
                <input v-model="form.name" type="text" required />
            </label>
            <label>
                Type:
                <select v-model="form.type_id" required>
                    <option v-for="type in types" :value="type.id" :key="type.id">
                        {{ type.name }}
                    </option>
                </select>
            </label>
            <label>
                Weight:
                <input v-model="form.weight" type="number" />
            </label>
            <label>
                Description:
                <textarea v-model="form.description"></textarea>
            </label>
            <label>
                Price:
                <input v-model="form.price" type="number" required />
            </label>
            <label>
                Stock Quantity:
                <input v-model="form.stock_quantity" type="number" required />
            </label>
            <button type="submit">Update</button>
        </form>
    </div>
</template>


