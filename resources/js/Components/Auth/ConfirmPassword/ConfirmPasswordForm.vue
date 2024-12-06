<script setup>
import { useForm } from '@inertiajs/vue3';
import ConfirmPasswordFormInput from '@/Components/Auth/ConfirmPassword/ConfirmPasswordFormInput.vue';
import PrimaryButton from '@/Components/General/PrimaryButton.vue';
import GoBackLoginLink from "@/Components/Auth/GoBackLoginLink.vue";
import { useNotifications } from "@/plugins/notificationPlugin";

const { success, error } = useNotifications();

// Props for email and token
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

// Initialize the form
const form = useForm({
    email: props.email,
    token: props.token,
    password: '',
    password_confirmation: '',
});

// Handle form submission
const submit = () => {
    form.post(route('password.store'), {
        onSuccess: () => {
            success('Password reset successfully! 🎉');
        },
        onError: () => {
            error('Failed to reset password. Please try again.');
        },
        onFinish: () => form.reset('password', 'password_confirmation'),
    });
};
</script>

<template>
    <div class="confirm-password-form">
        <div class="confirm-password-form__box">
            <!-- Logo -->
            <img src="/images/pim/mini-pim-logo.png" alt="logo" class="confirm-password-form__logo" />
            <h1 class="confirm-password-form__title">RESET PASSWORD</h1>

            <!-- Form -->
            <form class="confirm-password-form__form" @submit.prevent="submit">
                <!-- New Password Input Group -->
                <ConfirmPasswordFormInput
                    :password="form.password"
                    :passwordError="form.errors.password"
                    :passwordConfirmation="form.password_confirmation"
                    :passwordConfirmationError="form.errors.password_confirmation"
                    @update:password="form.password = $event"
                    @update:passwordConfirmation="form.password_confirmation = $event"
                />

                <!-- Reset Password Button -->
                <PrimaryButton
                    label="Reset Password"
                    :class="{ 'opacity-25': form.processing }"
                    :disabled="form.processing"
                    type="submit"
                />

                <!-- Go back to login -->
                <div class="confirm-password-form__links">
                    <GoBackLoginLink />
                </div>
            </form>
        </div>

        <!-- Image Box -->
        <div class="confirm-password-form__image-box">
            <img src="/images/pim/authenticationImage.png" alt="Confirm Password Image" class="confirm-password-form__image" />
        </div>
    </div>
</template>
