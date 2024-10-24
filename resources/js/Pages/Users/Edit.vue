<script setup>
import { useForm } from '@inertiajs/vue3';
import { defineProps } from 'vue';

const props = defineProps({
    user: Object
});

const form = useForm({
    name: props.user.name,
    email: props.user.email,
    password: '',
});

function submit() {
    form.put(route('users.update', props.user.id));
}
</script>

<template>
    <div>
        <h1>Edit User</h1>
        <form @submit.prevent="submit">
            <div>
                <label for="name">Name:</label>
                <input v-model="form.name" type="text" id="name" required>
            </div>
            <div>
                <label for="email">Email:</label>
                <input v-model="form.email" type="email" id="email" required>
            </div>
            <div>
                <label for="password">Password:</label>
                <input v-model="form.password" type="password" id="password">
            </div>
            <button type="submit">Update User</button>
        </form>
    </div>
</template>

<style scoped>

</style>
