<script setup>
import { useForm } from '@inertiajs/vue3';
import ConfirmPasswordFormInput from '@/Components/Auth/ConfirmPassword/ConfirmPasswordFormInput.vue';
import Button from '@/Components/General/Button.vue';
import GoBackLoginLink from "@/Components/Auth/GoBackLoginLink.vue";

const form = useForm({
    password: '',
    password_confirmation: '',
});

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
            <h1 class="confirm-password-form__title">WACHTWOORD BEVESTIGEN</h1>
            <form class="confirm-password-form__form" @submit.prevent="submit">
                <ConfirmPasswordFormInput
                    :password="form.password"
                    :passwordError="form.errors.password"
                    :passwordConfirmation="form.password_confirmation"
                    :passwordConfirmationError="form.errors.password_confirmation"
                />
                <Button label="Wachtwoord bevestigen" type="submit" />

                <div class="confirm-password-form__links">
                    <GoBackLoginLink />
                </div>
            </form>
        </div>
        <div class="confirm-password-form__image-box">
            <img src="/images/pim/authenticationImage.png" alt="Confirm Password Image" class="confirm-password-form__image">
        </div>
    </div>
</template>
