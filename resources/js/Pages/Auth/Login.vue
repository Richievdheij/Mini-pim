<script setup>
import GuestLayout from '@/Layouts/GuestLayout.vue';
import LoginForm from '@/Components/Login/LoginForm.vue';
import { Head, Link, useForm } from '@inertiajs/vue3';

defineProps({
    canResetPassword: {
        type: Boolean,
    },
    status: {
        type: String,
    },
});

const form = useForm({
    email: '',
    password: '',
    remember: false,
});

const submit = () => {
    form.post(route('login'), {
        onFinish: () => form.reset('password'),
    });
};
</script>

<template>
    <GuestLayout>
        <Head title="Mini-pim - Log in" />
        <LoginForm/>
    </GuestLayout>
</template>
