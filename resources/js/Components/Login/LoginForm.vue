<script setup>
import { useForm } from '@inertiajs/vue3';
import Input from '@/Components/General/Input.vue';
import Checkbox from '@/Components/General/Checkbox.vue';
import Button from '@/Components/General/Button.vue';
import ForgotPassword from '@/Components/Login/ForgotPassword.vue';

const form = useForm({
    email: '',
    password: '',
    remember: false,
});

const submit = () => {
    form.post(route('login'), {
        onFinish: () => form.reset('password'),
        data: { // Ensure to include remember token in the post request
            remember: form.remember,
        },
    });
};
</script>

<template>
    <div class="login-form">
      <div class="login-form__box">
        <!-- Add logo in back-end -->
        <img src="/images/pim/mini-pim-logo.png" alt="logo" class="login-form__logo">
        <h1 class="login-form__title">INLOGGEN</h1>
        <form class="login-form__form" @submit.prevent="submit">
          <div>
            <Input type="label" label="E-mailadres" />
            <Input type="field"
              input-type="text"
              placeholder="Vul hier uw bestaande e-mailadres in"
              v-model="form.email"
            />
            <Input type="error" :message="form.errors.email" />

            <Input type="label" label="Wachtwoord" />
            <Input type="field"
              input-type="password"
              placeholder="Wachtwoord"
              v-model="form.password"
            />
            <Input type="error" :message="form.errors.password" />

            <div class="login-form__links">
            <Checkbox
              label="Onthoud mij"
              v-model="form.remember"
              extra-class="checkbox--agreement"
            />
            <ForgotPassword />
            </div>
            <Button label="Inloggen" type="submit" />
          </div>
        </form>
      </div>
    </div>
</template>
