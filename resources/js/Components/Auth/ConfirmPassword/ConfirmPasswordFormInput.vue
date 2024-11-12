<script setup>
import { defineProps, ref, watch } from 'vue';
import Input from '@/Components/General/Input.vue';

const props = defineProps({
    password: String,
    passwordError: String,
    passwordConfirmation: String,
    passwordConfirmationError: String,
});

// Create local states for password and password confirmation
const localPassword = ref(props.password);
const localPasswordConfirmation = ref(props.passwordConfirmation);

// Emit changes back to the parent component
const emit = defineEmits(['update:password', 'update:passwordConfirmation']);

// Watch for changes in props to sync with local states
watch(() => props.password, (newPassword) => {
    localPassword.value = newPassword;
});

watch(() => props.passwordConfirmation, (newPasswordConfirmation) => {
    localPasswordConfirmation.value = newPasswordConfirmation;
});
</script>

<template>
    <div class="confirm-password-inputs">
        <!-- Password Input Group -->
        <Input
            type="field"
            label="New password"
            input-type="password"
            placeholder="Enter your new password here"
            v-model="localPassword"
            :error="passwordError"
            @input="emit('update:password', localPassword)"
        />

        <!-- Password Confirmation Input Group -->
        <Input
            type="field"
            label="Confirm password"
            input-type="password"
            placeholder="Confirm your new password"
            v-model="localPasswordConfirmation"
            :error="passwordConfirmationError"
            @input="emit('update:passwordConfirmation', localPasswordConfirmation)"
        />
    </div>
</template>
