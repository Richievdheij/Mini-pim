<script setup>
import {useForm} from '@inertiajs/vue3';
import {ref, computed} from 'vue';
import Input from '@/Components/General/Input.vue';
import PrimaryButton from '@/Components/General/PrimaryButton.vue';

const passwordInput = ref(null);
const currentPasswordInput = ref(null);

const form = useForm({
    current_password: '',
    password: '',
    password_confirmation: '',
});

// Computed property to check if passwords match
const passwordMatchSuccess = computed(() => {
    return form.password === form.password_confirmation && form.password_confirmation !== '';
});

const updatePassword = () => {
    form.put(route('password.update'), {
        preserveScroll: true,
        onSuccess: () => form.reset(),
        onError: () => {
            if (form.errors.password) {
                form.reset('password', 'password_confirmation');
                passwordInput.value.focus();
            }
            if (form.errors.current_password) {
                form.reset('current_password');
                currentPasswordInput.value.focus();
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
        <form class="update-password-form__form" @submit.prevent="updatePassword">
            <Input
                type="field"
                label="Current Password"
                input-type="password"
                placeholder="Current Password"
                v-model="form.current_password"
                ref="currentPasswordInput"
                :error="form.errors.current_password"
            />

            <!-- New Password Input Group -->
            <Input
                type="field"
                label="New Password"
                input-type="password"
                placeholder="Enter your new password"
                v-model="form.password"
                ref="passwordInput"
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
                :success="passwordMatchSuccess ? 'Passwords match!' : ''"
            />

            <!-- Submit Button -->
            <PrimaryButton label="Save" type="submit" :disabled="form.processing"/>
        </form>
    </div>
</template>
