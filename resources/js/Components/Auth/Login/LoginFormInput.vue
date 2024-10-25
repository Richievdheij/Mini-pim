<script setup>
import { defineProps, toRefs } from 'vue';
import Input from '@/Components/General/Input.vue';

const props = defineProps({
    email: String,
    emailError: String,
    password: String,
    passwordError: String,
});

const { email, emailError, password, passwordError } = toRefs(props);
</script>

<template>
    <div class="login-form-inputs">
        <!-- Email Input Group -->
        <div class="login-form-inputs__group">
            <Input type="label" label="E-mailadres" />
            <Input type="field"
                input-type="text"
                placeholder="Vul hier uw e-mailadres in"
                v-model="email"
            />
            <!-- Error input -->
            <Input type="error" :message="emailError" />
        </div>

        <!-- Password Input Group -->
        <div class="login-form-inputs__group">
            <Input type="label" label="Wachtwoord" />
            <Input type="field"
                input-type="password"
                placeholder="Wachtwoord"
                v-model="password"
            />
            <!-- Error input -->
            <Input type="error" :message="passwordError" />
        </div>
    </div>
</template>
