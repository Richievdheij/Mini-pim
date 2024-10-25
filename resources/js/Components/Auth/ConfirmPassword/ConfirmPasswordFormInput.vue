<script setup>
import { defineProps, toRefs } from 'vue';
import Input from '@/Components/General/Input.vue';

const props = defineProps({
    password: String,
    passwordError: String,
    passwordConfirmation: String,
    passwordConfirmationError: String,
});

const { password, passwordError, passwordConfirmation, passwordConfirmationError } = toRefs(props);
</script>

<template>
    <div class="confirm-password-inputs">
        <!-- Password Input Group -->
        <Input type="label" label="Nieuw Wachtwoord" />
        <Input type="field"
            input-type="password"
            placeholder="Vul hier uw nieuwe wachtwoord in"
            v-model="password"
        />
        <!-- Input error -->
        <Input type="error" :message="passwordError" />

        <!-- Password Confirmation Input Group -->
        <Input type="label" label="Bevestig Wachtwoord" />
        <Input type="field"
            input-type="password"
            placeholder="Bevestig uw nieuwe wachtwoord"
            v-model="passwordConfirmation"
        />
        <!-- Input error -->
        <Input type="error" :message="passwordConfirmationError" />
    </div>
</template>
