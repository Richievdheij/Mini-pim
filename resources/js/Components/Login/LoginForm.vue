<script setup>
import { useForm } from '@inertiajs/vue3';
import Input from '@/Components/General/Input.vue';
import Checkbox from '@/Components/General/Checkbox.vue';
import Button from '@/Components/General/Button.vue';
import ForgotPassword from '@/Components/Login/ForgotPassword.vue';
import Register from '@/Components/Login/Register.vue';

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
        <h1 class="login-form__title">INLOGGEN</h1>
        <form class="login-form__form" @submit.prevent="submit">
          <div>
            <Input type="label" label="Gebruikersnaam" />
            <Input type="field"
              input-type="text" 
              placeholder="Gebruikersnaam" 
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
  
            <Checkbox
              label="Ja, ik ga akkoord met de privacyverklaring"
              v-model="form.remember"
              extra-class="checkbox--agreement"
            />
            <Button label="Inloggen" type="submit" />
            
            <div class="login-form__links">
              <ForgotPassword />
              <Register />
            </div>
          </div>
        </form>
      </div>
    </div>
</template>
