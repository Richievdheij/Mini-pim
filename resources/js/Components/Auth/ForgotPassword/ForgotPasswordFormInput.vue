<script setup>
import { defineProps, toRefs } from 'vue';
import Input from '@/Components/General/Input.vue';

const props = defineProps({
    email: String,
    emailError: String,
});

const { email, emailError } = toRefs(props);
</script>

<template>
    <div class="forgot-password-inputs">
        <!-- Email Input Group -->
        <Input type="label" label="E-mailadres" />
        <Input type="field"
            input-type="text"
            placeholder="Vul hier uw e-mailadres in"
            v-model="email"
        />
        <!-- Error input -->
        <Input type="error" :message="emailError" />
    </div>
</template>
