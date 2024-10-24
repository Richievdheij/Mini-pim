<script setup>
import { useForm } from '@inertiajs/vue3';
import Input from '@/Components/General/Input.vue';
import Button from '@/Components/General/Button.vue';
import GoBackLogin from "@/Components/Auth/GoBackLogin.vue";

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
                <div>
                    <Input type="label" label="Nieuw Wachtwoord" />
                    <Input type="field"
                           input-type="password"
                           placeholder="Vul hier uw nieuwe wachtwoord in"
                           v-model="form.password"
                    />
                    <Input type="error" :message="form.errors.password" />

                    <Input type="label" label="Bevestig Wachtwoord" />
                    <Input type="field"
                           input-type="password"
                           placeholder="Bevestig uw nieuwe wachtwoord"
                           v-model="form.password_confirmation"
                    />
                    <Input type="error" :message="form.errors.password_confirmation" />

                    <Button label="Wachtwoord bevestigen" type="submit" />

                    <div class="confirm-password-form__links">
                        <GoBackLogin />
                    </div>
                </div>
            </form>
        </div>
        <div class="confirm-password-form__image-box">
            <img src="/images/pim/authenticationImage.png" alt="Confirm Password Image" class="confirm-password-form__image">
        </div>
    </div>
</template>
