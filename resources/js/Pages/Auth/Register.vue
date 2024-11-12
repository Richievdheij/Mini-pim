<script setup>
import GuestLayout from '@/Layouts/GuestLayout.vue';
import RegisterForm from '@/Components/Register/RegisterForm.vue';
import { Head } from '@inertiajs/vue3';
</script>

<template>
    <GuestLayout>
        <Head title="Mini-pim | Register" />
        <RegisterForm />
    </GuestLayout>
</template>
