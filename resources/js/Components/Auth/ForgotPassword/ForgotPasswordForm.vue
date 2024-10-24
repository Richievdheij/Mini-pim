<script setup>
import { useForm } from '@inertiajs/vue3';
import Input from '@/Components/General/Input.vue';
import Button from '@/Components/General/Button.vue';
import GoBackLogin from "@/Components/Auth/GoBackLogin.vue";

const form = useForm({
    email: '',
});

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
            <h1 class="forgot-password-form__title">WACHTWOORD VERGETEN</h1>
            <form class="forgot-password-form__form" @submit.prevent="submit">
                <div>
                    <Input type="label" label="E-mailadres" />
                    <Input type="field"
                           input-type="text"
                           placeholder="Vul hier uw e-mailadres in"
                           v-model="form.email"
                    />
                    <Input type="error" :message="form.errors.email" />
                    <Button label="Wachtwoord resetten" type="submit" />

                    <div class="forgot-password-form__links">
                        <GoBackLogin />
                    </div>
                </div>
            </form>
        </div>
        <div class="forgot-password-form__image-box">
            <img src="/images/pim/authenticationImage.png" alt="Forgot Password Image" class="forgot-password-form__image">
        </div>
    </div>
</template>
