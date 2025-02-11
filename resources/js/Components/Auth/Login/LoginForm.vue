<script setup>
import { useForm } from '@inertiajs/vue3';
import { onMounted, onUnmounted } from 'vue';
import LoginFormInput from '@/Components/Auth/Login/LoginFormInput.vue';
import Checkbox from '@/Components/General/Checkbox.vue';
import PrimaryButton from '@/Components/General/PrimaryButton.vue';
import ForgotPasswordLink from '@/Components/Auth/Login/ForgotPasswordLink.vue';

/**
 * Lifecycle hook to add the CookieDeclaration script when the component is mounted.
 */
onMounted(() => {
    const script = document.createElement('script');
    script.id = 'CookieDeclaration';
    script.src = 'https://consent.cookiebot.com/eb5a8a84-458d-49ac-ba40-eee70b46fe14/cd.js';
    script.type = 'text/javascript';
    script.async = true;
    document.body.appendChild(script);
});

/**
 * Lifecycle hook to remove the CookieDeclaration script when the component is unmounted.
 */
onUnmounted(() => {
    const script = document.getElementById('CookieDeclaration');
    if (script) {
        script.remove();
    }
});

/**
 * Form data and methods for handling login.
 * @property {String} email - The email address entered by the user.
 * @property {String} password - The password entered by the user.
 * @property {Boolean} remember - Indicates if the user wants to be remembered.
 * @method submit - Function to handle form submission.
 */
const form = useForm({
    email: '',
    password: '',
    remember: false,
});

/**
 * Function to handle form submission.
 * Sends a POST request to the login route and resets the password field on finish.
 */
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
