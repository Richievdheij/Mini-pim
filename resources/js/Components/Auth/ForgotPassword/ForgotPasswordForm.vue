<script setup>
import { useForm } from '@inertiajs/vue3';
import ForgotPasswordFormInput from '@/Components/Auth/ForgotPassword/ForgotPasswordFormInput.vue';
import PrimaryButton from '@/Components/General/PrimaryButton.vue';
import GoBackLoginLink from "@/Components/Auth/GoBackLoginLink.vue";

// Initialize the form with the email field
const form = useForm({
    email: '',
});

// Emit events to the parent
const emit = defineEmits(['success', 'error']);

// Function to handle form submission
const submit = () => {
    form.post(route('password.email'), {
        onSuccess: () => {
            emit('success', 'We have emailed your password reset link!'); // Notify parent of success
            form.reset();
        },
        onError: () => {
            emit('error', 'Unable to send the reset password link. Please check the email address.'); // Notify parent of error
        },
    });
};
</script>

<template>
    <div class="forgot-password-form">
        <div class="forgot-password-form__box">
            <!-- Logo -->
            <img src="/images/pim/mini-pim-logo.png" alt="logo" class="forgot-password-form__logo" />
            <h1 class="forgot-password-form__title">FORGOT<br />PASSWORD</h1>

            <form class="forgot-password-form__form" @submit.prevent="submit">
                <!-- Email Input Group -->
                <ForgotPasswordFormInput
                    :email="form.email"
                    :emailError="form.errors.email"
                    @update:email="form.email = $event"
                />

                <!-- Reset Password Button -->
                <PrimaryButton label="Reset password" type="submit" />

                <!-- Go back to login -->
                <div class="forgot-password-form__links">
                    <GoBackLoginLink />
                </div>
            </form>
        </div>

        <!-- Image Section -->
        <div class="forgot-password-form__image-box">
            <img src="/images/pim/authenticationImage.png" alt="Forgot Password Image" class="forgot-password-form__image" />
        </div>
    </div>
</template>
