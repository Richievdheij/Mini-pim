<script setup>
import { ref } from 'vue';
import { usePage } from '@inertiajs/vue3';
import AttributeCreateModal from '@/Components/Admin/Data/Attributes/AttributeCreateModal.vue';

const showModal = ref(false);

// Fetching data safely
const page = usePage();
const attributes = page?.props?.value?.attributes || [];
const types = page?.props?.value?.types || [];

function toggleModal() {
    showModal.value = !showModal.value;
}
</script>

<template>
    <div>
        <h1>Attributes</h1>
        <button @click="toggleModal">Create Attribute</button>

        <!-- Modal -->
        <AttributeCreateModal v-if="showModal" :types="types" @close="toggleModal" />

        <table>
            <thead>
            <tr>
                <th>Name</th>
                <th>Type</th>
            </tr>
            </thead>
            <tbody>
            <tr v-for="attribute in attributes" :key="attribute.id">
                <td>{{ attribute.name }}</td>
                <td>{{ attribute.type?.name }}</td>
            </tr>
            </tbody>
        </table>
    </div>
</template>
