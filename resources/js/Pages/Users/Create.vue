<script setup>
import { useForm } from '@inertiajs/vue3';
import { usePage } from '@inertiajs/vue3';

// Grab roles passed to the page
const { props } = usePage();
const profiles = props.profiles; // Make sure this matches the key used in the controller

// Initialize form
const form = useForm({
    name: '',
    email: '',
    password: '',
    profiles: [], // This will hold the selected profiles
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

        <label for="profiles">Assign Profiles:</label>
        <select v-model="form.profiles" multiple>
            <option v-for="profile in profiles" :value="profile.id" :key="profile.id">
                {{ profile.name }}
            </option>
        </select>

        <button type="submit">Create</button>
    </form>
</template>

<style scoped>

</style>
