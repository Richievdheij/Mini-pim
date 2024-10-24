<script setup>
import GuestLayout from '@/Layouts/GuestLayout.vue';
import ForgotPasswordForm from "@/Components/Auth/ForgotPassword/ForgotPasswordForm.vue";
import { Head, useForm } from '@inertiajs/vue3';

defineProps({
    status: {
        type: String,
    },
});

const form = useForm({
    email: '',
});

const submit = () => {
    form.post(route('password.email'));
};
</script>

<template>
    <GuestLayout>
        <Head title="Mini-pim | Wachtwoord vergeten" />
        <ForgotPasswordForm/>
    </GuestLayout>
</template>
