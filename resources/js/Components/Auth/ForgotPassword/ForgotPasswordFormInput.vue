<script setup>
import { defineProps, toRefs, ref, watch } from 'vue';
import Input from '@/Components/General/Input.vue';

const props = defineProps({
    email: String,
    emailError: String,
});

// Create a local state for the email input
const localEmail = ref(props.email);

// Emit changes back to the parent component
const emit = defineEmits(['update:email']);

// Watch for changes in props to sync with local state
watch(() => props.email, (newEmail) => {
    localEmail.value = newEmail;
});
</script>

<template>
    <div class="forgot-password-inputs">
        <!-- Email Input Group -->
        <Input type="label" label="Email address" />
        <Input type="field"
               input-type="text"
               placeholder="Enter your email address here"
               v-model="localEmail"
               @input="emit('update:email', localEmail)"
        />
        <!-- Error input -->
        <Input type="error" :message="emailError" />
    </div>
</template>
