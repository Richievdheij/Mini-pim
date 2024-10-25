<script setup>
import { useForm } from '@inertiajs/vue3';
import { usePage } from '@inertiajs/vue3';

// Grab user, roles, and user's current roles passed to the page
const { props } = usePage();
const roles = props.roles;
const userRoles = props.userRoles;

// Initialize form with user data and selected roles
const form = useForm({
    name: props.user.name,
    email: props.user.email,
    password: '',
    roles: userRoles, // Set the initially selected roles
});

function submit() {
    form.put(`/users/${props.user.id}`); // Submit the form
}
</script>

<template>
    <form @submit.prevent="submit">
        <label for="name">Name:</label>
        <input type="text" v-model="form.name" />

        <label for="email">Email:</label>
        <input type="email" v-model="form.email" />

        <label for="password">Password (Leave blank to keep current):</label>
        <input type="password" v-model="form.password" />

        <label for="roles">Assign Roles:</label>
        <select v-model="form.roles" multiple>
            <option v-for="role in roles" :value="role.id" :key="role.id">
                {{ role.name }}
            </option>
        </select>

        <button type="submit">Update</button>
    </form>
</template>

<style scoped>

</style>
