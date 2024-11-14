<script setup>
import { useForm } from '@inertiajs/vue3';

const form = useForm({
    name: '',
});

function submit() {
    form.post(route('profiles.store'));
}
</script>

<template>
    <div>
        <h1>Create Profile</h1>
        <form @submit.prevent="submit">
            <div>
                <label for="name">Profile Name:</label>
                <input type="text" v-model="form.name" required />
            </div>
            <button type="submit">Create Profile</button>
        </form>
    </div>
</template>

<style scoped>

</style>
