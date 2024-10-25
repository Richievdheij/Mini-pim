<script setup>
import { defineProps, toRefs, ref, watch } from 'vue';
import Input from '@/Components/General/Input.vue';

const props = defineProps({
    email: String,
    emailError: String,
    password: String,
    passwordError: String,
});

// Create local state for email and password
const localEmail = ref(props.email);
const localPassword = ref(props.password);

// Emit changes to the parent
const emit = defineEmits(['update:email', 'update:password']);

// Watch for changes in props to sync with local state
watch(() => props.email, (newEmail) => {
    localEmail.value = newEmail;
});
watch(() => props.password, (newPassword) => {
    localPassword.value = newPassword;
});
</script>

<template>
    <div class="login-form-inputs">
        <!-- Email Input Group -->
        <div class="login-form-inputs__group">
            <Input type="label" label="E-mailadres" />
            <Input type="field"
                   input-type="text"
                   placeholder="Vul hier uw e-mailadres in"
                   v-model="localEmail"
                   @input="emit('update:email', localEmail)"
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
                   v-model="localPassword"
                   @input="emit('update:password', localPassword)"
            />
            <!-- Error input -->
            <Input type="error" :message="passwordError" />
        </div>
    </div>
</template>
