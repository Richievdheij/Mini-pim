<script setup>
import GuestLayout from '@/Layouts/GuestLayout.vue';
import ForgotPasswordForm from "@/Components/Auth/ForgotPassword/ForgotPasswordForm.vue";
import { Head } from '@inertiajs/vue3';
</script>

<template>
    <GuestLayout>
        <Head title="Mini-pim | Forgot password" />
        <ForgotPasswordForm/>
    </GuestLayout>
</template>
