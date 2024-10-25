<script setup>
import { usePage } from '@inertiajs/vue3';

const { props } = usePage();
const users = props.users; // Get users passed from the controller
</script>

<template>
    <div>
        <h1>Manage Users</h1>
        <table>
            <thead>
            <tr>
                <th>Name</th>
                <th>Email</th>
            </tr>
            </thead>
            <tbody>
            <tr v-for="user in users" :key="user.id">
                <td>{{ user.name }}</td>
                <td>{{ user.email }}</td>
            </tr>
            </tbody>
        </table>
    </div>
</template>

<style scoped>

</style>
