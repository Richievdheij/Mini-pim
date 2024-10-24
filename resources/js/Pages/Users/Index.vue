<script setup>
import { Link, router } from '@inertiajs/vue3'; // Import the link and router components

defineProps({
    users: Array,
});

function deleteUser(id) {
    if (confirm('Are you sure you want to delete this user?')) {
        router.delete(route('users.destroy', id));
    }
}
</script>

<template>
    <div>
        <h1>User List</h1>
        <table>
            <thead>
            <tr>
                <th>Name</th>
                <th>Email</th>
                <th>Actions</th>
            </tr>
            </thead>
            <tbody>
            <tr v-for="user in users" :key="user.id">
                <td>{{ user.name }}</td>
                <td>{{ user.email }}</td>
                <td>
                    <Link :href="route('users.edit', user.id)">Edit</Link>
                    <form :action="route('users.destroy', user.id)" method="POST" @submit.prevent="deleteUser(user.id)">
                        <input type="hidden" name="_method" value="DELETE">
                        <button type="submit">Delete</button>
                    </form>
                </td>
            </tr>
            </tbody>
        </table>
    </div>
</template>

<style scoped>

</style>
