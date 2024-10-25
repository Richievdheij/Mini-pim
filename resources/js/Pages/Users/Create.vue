<script setup>
import { useForm } from '@inertiajs/vue3';
import { usePage } from '@inertiajs/vue3';

// Grab roles passed to the page
const { props } = usePage();
const roles = props.roles;

// Initialize form
const form = useForm({
    name: '',
    email: '',
    password: '',
    roles: [], // This will hold the selected roles
});

function submit() {
    form.post('/users'); // Submit the form
}
</script>

<template>
    <form @submit.prevent="submit">
        <label for="name">Name:</label>
        <input type="text" v-model="form.name" />

        <label for="email">Email:</label>
        <input type="email" v-model="form.email" />

        <label for="password">Password:</label>
        <input type="password" v-model="form.password" />

        <label for="roles">Assign Roles:</label>
        <select v-model="form.roles" multiple>
            <option v-for="role in roles" :value="role.id" :key="role.id">
                {{ role.name }}
            </option>
        </select>

        <button type="submit">Create</button>
    </form>
</template>

<style scoped>

</style>
