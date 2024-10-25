<script setup>
import { Link, router } from '@inertiajs/vue3'; // Import the Link and router components
import Button from '@/Components/General/Button.vue'; // Import your custom button component

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
        <h1 class="text-2xl font-semibold mb-6">User List</h1>
        <table class="w-full table-auto">
            <thead>
            <tr>
                <th class="border px-4 py-2">Name</th>
                <th class="border px-4 py-2">Email</th>
                <th class="border px-4 py-2">Roles</th>
                <th class="border px-4 py-2">Actions</th>
            </tr>
            </thead>
            <tbody>
            <tr v-for="user in users" :key="user.id">
                <td class="border px-4 py-2">{{ user.name }}</td>
                <td class="border px-4 py-2">{{ user.email }}</td>
                <td class="border px-4 py-2">
                    <ul>
                        <li v-for="role in user.roles" :key="role.id">{{ role.name }}</li>
                    </ul>
                </td>
                <td class="border px-4 py-2">
                    <Link :href="route('users.edit', user.id)">
                        <Button label="Edit" type="submit" class="mr-2" />
                    </Link>
                    <form :action="route('users.destroy', user.id)" method="POST" @submit.prevent="deleteUser(user.id)" class="inline">
                        <input type="hidden" name="_method" value="DELETE">
                        <Button label="Delete" type="delete" />
                    </form>
                </td>
            </tr>
            </tbody>
        </table>

        <div class="mt-6">
            <!-- Corrected route for creating a new user -->
            <Link :href="route('users.create')">
                <Button label="Create New User" type="submit" class="bg-blue-500 text-white px-4 py-2 rounded" />
            </Link>
        </div>
    </div>
</template>

<style scoped>
/* Add any additional styling as needed */
</style>
