<script setup>
import { ref } from 'vue';
import { usePage } from '@inertiajs/vue3';
import AttributeCreateModal from '@/Components/Admin/Data/Attributes/AttributeCreateModal.vue';
import AttributeEditModal from '@/Components/Admin/Data/Attributes/AttributeEditModal.vue';

const showCreateModal = ref(false);
const showEditModal = ref(false);
const attributeToEdit = ref(null);

const page = usePage();
const attributes = ref(page?.props?.attributes || []);
const types = ref(page?.props?.types || []);

function toggleCreateModal() {
    showCreateModal.value = !showCreateModal.value;
}

function toggleEditModal(attribute = null) {
    attributeToEdit.value = attribute;
    showEditModal.value = !showEditModal.value;
}
</script>

<template>
    <div>
        <h1>Attributes</h1>
        <button @click="toggleCreateModal">Create Attribute</button>

        <!-- Table -->
        <table>
            <thead>
            <tr>
                <th>Name</th>
                <th>Type</th>
                <th>Actions</th>
            </tr>
            </thead>
            <tbody>
            <tr v-if="!attributes.length">
                <td colspan="3">No attributes found.</td>
            </tr>
            <tr v-for="(attribute, index) in attributes" :key="attribute.id">
                <td>{{ attribute.name }}</td>
                <td>{{ attribute.type?.name || 'N/A' }}</td>
                <td>
                    <button class="btn btn-secondary" @click="toggleEditModal(attribute)">Edit</button>
                    <button class="btn btn-danger" @click="() => $inertia.delete(route('attributes.destroy', attribute.id))">Delete</button>
                </td>
            </tr>
            </tbody>
        </table>

        <!-- Modals -->
        <AttributeCreateModal v-if="showCreateModal" :types="types" @close="toggleCreateModal" />
        <AttributeEditModal v-if="showEditModal" :attribute="attributeToEdit" :types="types" @close="toggleEditModal" />
    </div>
</template>
<style scoped>
table {
    width: 100%;
    border-collapse: collapse;
    margin-top: 20px;
}
table th,
table td {
    padding: 10px;
    border: 1px solid #ddd;
}
table th {
    background-color: #f4f4f4;
}
.btn {
    margin: 0 5px;
    padding: 5px 10px;
    border: none;
    cursor: pointer;
    border-radius: 3px;
}
.btn-secondary {
    background-color: #007bff;
    color: white;
}
.btn-danger {
    background-color: #dc3545;
    color: white;
}
</style>
