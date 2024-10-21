<script setup>
import GuestLayout from '@/Layouts/GuestLayout.vue';
import RegisterForm from '@/Components/Register/RegisterForm.vue';
import { Head } from '@inertiajs/vue3';

defineProps({
    status: {
        type: String,
    },
});
</script>

<template>
    <GuestLayout>
        <Head title="Registreer" />
        <RegisterForm />
    </GuestLayout>
</template>