<script setup>
import { useForm } from '@inertiajs/vue3';
import { usePage } from '@inertiajs/vue3';
import { ref } from 'vue';
import axios from 'axios';

const { types } = usePage().props;

const form = useForm({
    product_id: '',
    name: '',
    type_id: '',
    attributes: {}, // Dynamic attributes object
    weight: '',
    description: '',
    price: '',
    stock_quantity: '',
});

const attributes = ref([]); // Store attributes based on the selected type

async function fetchAttributes(typeId) {
    if (!typeId) {
        attributes.value = [];
        return;
    }
    const response = await axios.get(route('types.attributes', typeId));
    attributes.value = response.data.attributes;

    // Initialize the attributes fields
    attributes.value.forEach(attr => {
        form.attributes[attr.id] = ''; // Create a field for each attribute
    });
}

function submit() {
    form.post(route('pim.products.store'), {
        onSuccess: () => {
            alert('Product created successfully!');
        },
    });
}
</script>

<template>
    <div>
        <h1>Create Product</h1>
        <form @submit.prevent="submit">
            <label>
                Product ID:
                <input v-model="form.product_id" type="text" required/>
            </label>
            <label>
                Name:
                <input v-model="form.name" type="text" required/>
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
                        <input v-model="form.attributes[attribute.id]" type="text"/>
                    </label>
                </div>
            </div>

            <label>
                Weight:
                <input v-model="form.weight" type="number"/>
            </label>
            <label>
                Description:
                <textarea v-model="form.description"></textarea>
            </label>
            <label>
                Price:
                <input v-model="form.price" type="number" required/>
            </label>
            <label>
                Stock Quantity:
                <input v-model="form.stock_quantity" type="number" required/>
            </label>
            <button type="submit">Save</button>
        </form>
    </div>
</template>
