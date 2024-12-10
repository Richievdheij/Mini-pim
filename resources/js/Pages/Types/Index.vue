<script setup>
import { ref } from 'vue';
import { usePage } from '@inertiajs/vue3';
import TypeCreateModal from '@/Components/Admin/Data/Types/TypeCreateModal.vue';
import TypeEditModal from '@/Components/Admin/Data/Types/TypeEditModal.vue';

const showCreateModal = ref(false); // Modal visibility state
const showEditModal = ref(false);
const typeToEdit = ref(null);

const page = usePage();
const types = ref(page?.props?.types || []); // Initialize types from props

function toggleCreateModal() {
    showCreateModal.value = !showCreateModal.value;
}

function toggleEditModal(type = null) {
    typeToEdit.value = type;
    showEditModal.value = !showEditModal.value;
}

function handleTypeCreated(newType) {
    types.value.push(newType); // Add the newly created type to the list
}
</script>

<template>
    <div>
        <h1 class="title">Product Types</h1>
        <button @click="toggleCreateModal" class="btn btn-primary">+ New Type</button>

        <table class="table">
            <thead>
            <tr>
                <th>#</th>
                <th>Type Name</th>
                <th>Actions</th>
            </tr>
            </thead>
            <tbody>
            <tr v-for="(type, index) in types" :key="type.id">
                <td>{{ index + 1 }}</td>
                <td>{{ type.name }}</td>
                <td>
                    <button class="btn btn-secondary" @click="toggleEditModal(type)">Edit</button>
                    <button
                        class="btn btn-danger"
                        @click="() => $inertia.delete(route('types.destroy', type.id))"
                    >
                        Delete
                    </button>
                </td>
            </tr>
            </tbody>
        </table>

        <!-- Modals -->
        <TypeCreateModal
            :isOpen="showCreateModal"
            @close="toggleCreateModal"
            @typeCreated="handleTypeCreated"
        />
        <TypeEditModal
            v-if="showEditModal"
            :type="typeToEdit"
            :isOpen="showEditModal"
            @close="toggleEditModal"
        />
    </div>
</template>
<style scoped>
/* Add some basic styles for table and buttons */
.title {
    font-size: 1.5rem;
    margin-bottom: 1rem;
}

.table {
    width: 100%;
    border-collapse: collapse;
    margin-top: 1rem;
    border: 1px solid #ccc;
}

.table th,
.table td {
    border: 1px solid #ccc;
    padding: 0.5rem;
    text-align: left;
}

.table th {
    background-color: #f8f8f8;
}

.btn {
    padding: 0.5rem 1rem;
    margin: 0 0.25rem;
    cursor: pointer;
    border: none;
    border-radius: 4px;
}

.btn-primary {
    background-color: #007bff;
    color: #fff;
}

.btn-secondary {
    background-color: #6c757d;
    color: #fff;
}

.btn-danger {
    background-color: #dc3545;
    color: #fff;
}
</style>
