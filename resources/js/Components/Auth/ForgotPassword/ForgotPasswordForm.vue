<script setup>
import { useForm } from '@inertiajs/vue3';
import ForgotPasswordFormInput from '@/Components/Auth/ForgotPassword/ForgotPasswordFormInput.vue';
import PrimaryButton from '@/Components/General/PrimaryButton.vue';
import GoBackLoginLink from "@/Components/Auth/GoBackLoginLink.vue";

const form = useForm({
    email: '',
});

// Function to handle form submission
const submit = () => {
    form.post(route('password.email'), {
        onFinish: () => form.reset(),
    });
};
</script>

<template>
    <div class="forgot-password-form">
        <div class="forgot-password-form__box">
            <!-- Add logo in back-end -->
            <img src="/images/pim/mini-pim-logo.png" alt="logo" class="forgot-password-form__logo">
            <h1 class="forgot-password-form__title">FORGOT<br>PASSWORD</h1>
            <form class="forgot-password-form__form" @submit.prevent="submit">
                <ForgotPasswordFormInput
                    :email="form.email"
                    :emailError="form.errors.email"
                    @update:email="form.email = $event"
                />
                <PrimaryButton label="Reset password" type="submit"/>

                <div class="forgot-password-form__links">
                    <GoBackLoginLink/>
                </div>
            </form>
        </div>
        <div class="forgot-password-form__image-box">
            <img src="/images/pim/authenticationImage.png" alt="Forgot Password Image" class="forgot-password-form__image">
        </div>
    </div>
</template>
