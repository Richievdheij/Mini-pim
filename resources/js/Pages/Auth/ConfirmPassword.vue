<script setup>
import GuestLayout from '@/Layouts/GuestLayout.vue';
import ConfirmPasswordForm from "@/Components/Auth/ForgotPassword/ForgotPasswordForm.vue";
import { Head, useForm } from '@inertiajs/vue3';

const form = useForm({
    password: '',
});

const submit = () => {
    form.post(route('password.confirm'), {
        onFinish: () => form.reset(),
    });
};
</script>

<template>
    <GuestLayout>
        <Head title="Mini-pim | Wachtwoord bevestigen" />
        <ConfirmPasswordForm/>
    </GuestLayout>
</template>
