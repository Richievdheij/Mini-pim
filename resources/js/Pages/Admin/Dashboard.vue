<script setup>
import { usePage } from '@inertiajs/vue3';

const { props } = usePage();
const user = props.auth.user; // Access the authenticated admin
</script>

<template>
    <div>
        <h1>Admin Dashboard</h1>
        <p>Welcome, admin!</p>
    </div>
</template>

<style scoped>

</style>
