<script setup>
import { usePage } from '@inertiajs/vue3';

const { values, attribute } = usePage().props;

function goToCreate() {
    window.location.href = route('attribute-values.create', attribute.id);
}

function editValue(id) {
    window.location.href = route('attribute-values.edit', id);
}

function deleteValue(id) {
    if (confirm('Are you sure you want to delete this value?')) {
        window.location.href = route('attribute-values.destroy', id);
    }
}
</script>
<template>
    <div>
        <h1>Attribute Values for {{ attribute.name }}</h1>
        <button @click="goToCreate">+ New Value</button>
        <table>
            <thead>
            <tr>
                <th>Value</th>
                <th>Actions</th>
            </tr>
            </thead>
            <tbody>
            <tr v-for="value in values" :key="value.id">
                <td>{{ value.value }}</td>
                <td>
                    <button @click="editValue(value.id)">Edit</button>
                    <button @click="deleteValue(value.id)">Delete</button>
                </td>
            </tr>
            </tbody>
        </table>
    </div>
</template>


