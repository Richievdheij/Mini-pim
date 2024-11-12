<script setup>
import { defineProps, ref, watch } from 'vue';
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
            <Input
                type="field"
                label="Email address"
                input-type="text"
                placeholder="Enter your email address here"
                :error="emailError"
                v-model="localEmail"
                @input="emit('update:email', localEmail)"
            />
        </div>

        <!-- Password Input Group -->
        <div class="login-form-inputs__group">
            <Input
                type="field"
                label="Password"
                input-type="password"
                placeholder="Password"
                :error="passwordError"
                v-model="localPassword"
                @input="emit('update:password', localPassword)"
            />
        </div>
    </div>
</template>
