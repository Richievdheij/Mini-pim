<script setup>
import { useForm } from '@inertiajs/vue3';
import LoginFormInput from '@/Components/Auth/Login/LoginFormInput.vue';
import Checkbox from '@/Components/General/Checkbox.vue';
import PrimaryButton from '@/Components/General/PrimaryButton.vue';
import ForgotPasswordLink from '@/Components/Auth/Login/ForgotPasswordLink.vue';

const form = useForm({
    email: '',
    password: '',
    remember: false,
});

// Function to handle form submission
const submit = () => {
    form.post(route('login'), {
        onFinish: () => form.reset('password'),
    });
};

</script>

<template>
    <div class="login-form">
        <div class="login-form__box">
            <!-- Add logo in back-end -->
            <img src="/images/pim/mini-pim-logo.png" alt="logo" class="login-form__logo">
            <h1 class="login-form__title">LOGIN</h1>
            <form class="login-form__form" @submit.prevent="submit">
                <LoginFormInput
                    :email="form.email"
                    :emailError="form.errors.email"
                    :password="form.password"
                    :passwordError="form.errors.password"
                    @update:email="form.email = $event"
                    @update:password="form.password = $event"
                />
                <div class="login-form__links">
                    <Checkbox
                        label="Remember me"
                        v-model="form.remember"
                        extra-class="checkbox--agreement"
                    />
                    <ForgotPasswordLink />
                </div>
                <PrimaryButton
                    label="Login"
                    type="submit"
                />
            </form>
        </div>
        <div class="login-form__image-box">
            <img src="/images/pim/authenticationImage.png" alt="Login Image" class="login-form__image">
        </div>
    </div>
</template>
