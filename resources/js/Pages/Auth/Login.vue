<script setup>
import GuestLayout from '@/Layouts/GuestLayout.vue';
import LoginForm from '@/Components/Auth/Login/LoginForm.vue';
import { Head } from '@inertiajs/vue3';
</script>

<template>
    <GuestLayout>
        <Head title="Mini-pim | Login" />
        <LoginForm/>
    </GuestLayout>
</template>
