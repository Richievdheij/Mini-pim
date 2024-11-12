<script setup>
import { defineProps, computed } from 'vue';
const props = defineProps({
    label: String,
    placeholder: String,
    inputType: String,
    message: String,
    type: {
        type: String,
        required: true,
    },
    modelValue: String,
    error: String,
    success: String, // New prop for success message
});

const emit = defineEmits(['update:modelValue']);

const inputClass = computed(() => {
    let type = 'input input__body';
    if (props.error) {
        type += ' input__body--error';
    }
    if (props.success) {
        type += ' input__body--success';
    }
    if (props.type === 'field') {
        type += ' input__body--field';
    }
    if (props.label === 'label') {
        type += ' input__body--label';
    }

    return type;
});
</script>

<template>
    <div :class="inputClass">
        <label v-if="label">
            {{ label }}
        </label>

        <input
            :type="inputType"
            :placeholder="placeholder"
            class="input__field"
            :class="{ 'has-value': modelValue }"
            :value="modelValue"
            @input="$emit('update:modelValue', $event.target.value)"
        />

        <!-- Error or Success Message Container -->
        <div class="input__message-container">
            <p class="input__error" v-if="error">{{ error }}</p>
            <p class="input__success" v-if="success">{{ success }}</p>
        </div>
    </div>
</template>
