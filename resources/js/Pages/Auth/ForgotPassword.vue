<script setup>
import GuestLayout from '@/Layouts/GuestLayout.vue';
import ForgotPasswordForm from "@/Components/Auth/ForgotPassword/ForgotPasswordForm.vue";
import { ref } from 'vue';

const notification = ref({
    show: false,
    message: '',
    type: 'success', // Can be 'success' or 'error'
});

// Function to trigger the notification
const triggerNotification = (message, type) => {
    notification.value = {
        show: true,
        message,
        type,
    };

    // Automatically hide the notification after 5 seconds
    setTimeout(() => {
        notification.value.show = false;
    }, 5000);
};
</script>

<template>
    <GuestLayout>
        <!-- Notification -->
        <Notification
            v-if="notification.show"
            :message="notification.message"
            :type="notification.type"
        />

        <!-- Forgot Password Form -->
        <ForgotPasswordForm
            @success="triggerNotification($event, 'success')"
            @error="triggerNotification($event, 'error')"
        />
    </GuestLayout>
</template>
