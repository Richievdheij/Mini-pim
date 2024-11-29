<script setup>
import { defineProps, ref, watch, defineEmits } from 'vue';
import Input from '@/Components/General/Input.vue';

// Props
const props = defineProps({
    password: String,
    passwordError: String,
    passwordConfirmation: String,
    passwordConfirmationError: String,
});

// Local states
const localPassword = ref(props.password || '');
const localPasswordConfirmation = ref(props.passwordConfirmation || '');

// Emit events
const emit = defineEmits(['update:password', 'update:passwordConfirmation']);

// Watch for prop changes
watch(() => props.password, (newPassword) => {
    localPassword.value = newPassword;
});
watch(() => props.passwordConfirmation, (newPasswordConfirmation) => {
    localPasswordConfirmation.value = newPasswordConfirmation;
});

// Emit local changes
watch(localPassword, (newVal) => {
    emit('update:password', newVal);
});
watch(localPasswordConfirmation, (newVal) => {
    emit('update:passwordConfirmation', newVal);
});
</script>

<template>
    <div class="confirm-password-inputs">
        <!-- Password Input -->
        <Input
            type="field"
            label="New password"
            input-type="password"
            placeholder="Enter your new password here"
            v-model="localPassword"
            :error="passwordError"
        />

        <!-- Password Confirmation Input -->
        <Input
            type="field"
            label="Confirm password"
            input-type="password"
            placeholder="Confirm your new password"
            v-model="localPasswordConfirmation"
            :error="passwordConfirmationError"
        />
    </div>
</template>
