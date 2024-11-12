<script setup>
import { useForm } from '@inertiajs/vue3';
import ConfirmPasswordFormInput from '@/Components/Auth/ConfirmPassword/ConfirmPasswordFormInput.vue';
import PrimaryButton from '@/Components/General/PrimaryButton.vue';
import GoBackLoginLink from "@/Components/Auth/GoBackLoginLink.vue";

const form = useForm({
    password: '',
    password_confirmation: '',
});

// Function to handle form submission
const submit = () => {
    form.post(route('password.confirm'), {
        onFinish: () => form.reset(),
    });
};
</script>

<template>
    <div class="confirm-password-form">
        <div class="confirm-password-form__box">
            <!-- Add logo in back-end -->
            <img src="/images/pim/mini-pim-logo.png" alt="logo" class="confirm-password-form__logo">
            <h1 class="confirm-password-form__title">CONFIRM PASSWORD</h1>
            <form class="confirm-password-form__form" @submit.prevent="submit">
                <!-- Password Input Group -->
                <ConfirmPasswordFormInput
                    :password="form.password"
                    :passwordError="form.errors.password"
                    :passwordConfirmation="form.password_confirmation"
                    :passwordConfirmationError="form.errors.password_confirmation"
                    @update:password="form.password = $event"
                    @update:passwordConfirmation="form.password_confirmation = $event"
                />
                <!-- Confirm password -->
                <PrimaryButton
                    label="Confirm password"
                    type="submit"
                />

                <!-- Go back to login -->
                <div class="confirm-password-form__links">
                    <GoBackLoginLink/>
                </div>
            </form>
        </div>
        <div class="confirm-password-form__image-box">
            <img src="/images/pim/authenticationImage.png" alt="Confirm Password Image" class="confirm-password-form__image">
        </div>
    </div>
</template>
