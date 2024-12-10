<script setup>
import { useForm } from '@inertiajs/vue3';
import { usePage } from '@inertiajs/vue3';
import { ref } from 'vue';
import axios from 'axios';

const { product, types } = usePage().props;

const form = useForm({
    name: product.name,
    type_id: product.type_id,
    attributes: product.attributes || {}, // Populate existing attributes
    weight: product.weight,
    description: product.description,
    price: product.price,
    stock_quantity: product.stock_quantity,
});

const attributes = ref([]); // Store attributes for the selected type

async function fetchAttributes(typeId) {
    if (!typeId) {
        attributes.value = [];
        return;
    }
    const response = await axios.get(route('types.attributes', typeId));
    attributes.value = response.data.attributes;

    // Ensure all attributes exist in the form
    attributes.value.forEach(attr => {
        if (!form.attributes[attr.id]) {
            form.attributes[attr.id] = ''; // Initialize new attribute fields
        }
    });
}

// Fetch attributes for the current product type on load
fetchAttributes(form.type_id);

function submit() {
    form.put(route('products.update', product.id), {
        onSuccess: () => {
            alert('Product updated successfully!');
        },
    });
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
                <select v-model="form.type_id" @change="fetchAttributes(form.type_id)" required>
                    <option value="" disabled>Select Type</option>
                    <option v-for="type in types" :value="type.id" :key="type.id">
                        {{ type.name }}
                    </option>
                </select>
            </label>

            <!-- Dynamic Attributes -->
            <div v-if="attributes.length">
                <h3>Attributes</h3>
                <div v-for="attribute in attributes" :key="attribute.id">
                    <label>
                        {{ attribute.name }}:
                        <input v-model="form.attributes[attribute.id]" type="text" />
                    </label>
                </div>
            </div>

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
