<script setup>
import { useForm } from '@inertiajs/vue3';
import { useNotifications } from "@/plugins/notificationPlugin";
import Input from '@/Components/General/Input.vue';
import PrimaryButton from '@/Components/General/PrimaryButton.vue';

// Initialize notifications system
const { success, error } = useNotifications();

// Initialize form
const form = useForm({
    current_password: '',
    password: '',
    password_confirmation: '',
});

// Handle form submission (patch the form data)
const submit = () => {
    form.post(route('password.update'), {
        preserveScroll: true,
        onSuccess: () => {
            form.reset();
            success("Password updated successfully!"); // Notify success
        },
        onError: () => {
            error("Failed to update password."); // Notify failure
            if (form.errors.password) {
                form.reset('password', 'password_confirmation');
            }
            if (form.errors.current_password) {
                form.reset('current_password');
            }
        },
    });
};

</script>

<template>
    <div class="update-password-form">
        <h2 class="update-password-form__title">Update Password</h2>
        <p class="update-password-form__description">
            Ensure your account is using a long, random password to stay secure.
        </p>

        <!-- Update Password Form -->
        <form class="update-password-form__form" @submit.prevent="submit">
            <Input
                type="field"
                label="Current Password"
                input-type="password"
                placeholder="Current Password"
                v-model="form.current_password"
                :error="form.errors.current_password"
            />

            <!-- New Password Input Group -->
            <Input
                type="field"
                label="New Password"
                input-type="password"
                placeholder="Enter your new password"
                v-model="form.password"
                :error="form.errors.password"
            />

            <!-- Confirm Password Input Group with Success Message -->
            <Input
                type="field"
                label="Confirm Password"
                input-type="password"
                placeholder="Confirm your password"
                v-model="form.password_confirmation"
                :error="form.errors.password_confirmation"
            />

            <!-- Submit Button -->
            <PrimaryButton
                label="Save"
                type="submit"
                :disabled="form.processing"
            />
        </form>
    </div>
</template>
