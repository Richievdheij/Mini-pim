<script setup>
import GuestLayout from '@/Layouts/GuestLayout.vue';
import ConfirmPasswordForm from "@/Components/Auth/ForgotPassword/ForgotPasswordForm.vue";
import { Head } from '@inertiajs/vue3';
</script>

<template>
    <GuestLayout>
        <Head title="Mini-pim | Confirm password" />
        <ConfirmPasswordForm/>
    </GuestLayout>
</template>
