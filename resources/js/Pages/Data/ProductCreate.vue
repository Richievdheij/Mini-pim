<script setup>
import { useForm } from '@inertiajs/vue3';
import { usePage } from '@inertiajs/vue3';

const { types } = usePage().props;

const form = useForm({
    product_id: '',
    name: '',
    type_id: '',
    weight: '',
    description: '',
    price: '',
    stock_quantity: '',
});

function submit() {
    form.post(route('products.store'));
}
</script>
<template>
    <div>
        <h1>Create Product</h1>
        <form @submit.prevent="submit">
            <label>
                Product ID:
                <input v-model="form.product_id" type="text" required />
            </label>
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
            <button type="submit">Save</button>
        </form>
    </div>
</template>


