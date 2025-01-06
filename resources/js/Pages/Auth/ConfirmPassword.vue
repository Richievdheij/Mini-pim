<script setup>
import GuestLayout from '@/Layouts/GuestLayout.vue';
import ConfirmPasswordForm from "@/Components/Auth/ConfirmPassword/ConfirmPasswordForm.vue";
import { Head } from '@inertiajs/vue3';

// Define props for email and token (passed from backend)
const props = defineProps({
    email: {
        type: String,
        required: true,
    },
    token: {
        type: String,
        required: true,
    },
});


</script>

<template>
    <GuestLayout>
        <Head title="Mini-pim | Reset Password" />

        <!-- Pass email and token to the form -->
        <ConfirmPasswordForm
            :email="props.email"
            :token="props.token"
        />
    </GuestLayout>
</template>
