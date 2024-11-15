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
    options: {
        type: Array,
        default: () => [],
    },
    modelValue: [String, Array],
    error: String,
    success: String,
    multiple: Boolean,
});

const emit = defineEmits(['update:modelValue']);

// Compute the input class based on the type and status
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
    if (props.type === 'select') {
        type += ' input__body--select';
    }

    return type;
});
</script>

<template>
    <div :class="inputClass">
        <label v-if="label">
            {{ label }}
        </label>

        <!-- Input or Select Field -->
        <select
            v-if="type === 'select'"
            class="input__select"
            :multiple="multiple"
            :value="modelValue"
            @change="$emit('update:modelValue', Array.from($event.target.selectedOptions, option => option.value))"
        >
            <option
                v-for="option in options"
                :key="option.id || option"
                :value="option.id || option"
            >
                {{ option.name || option }}
            </option>
        </select>

        <input
            v-else
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
