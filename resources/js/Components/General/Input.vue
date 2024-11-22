<script setup>
import { defineProps, computed } from 'vue';

const props = defineProps({
    error: String,
    inputType: String,
    label: String,
    message: String,
    modelValue: [String, Array],
    multiple: Boolean,
    options: {
        type: Array,
        default: () => [],
    },
    placeholder: String,
    type: {
        type: String,
        required: true,
    },
    icon: String,
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
    if (props.type === 'select') {
        type += ' input__body--select';
    }
    if (props.type === 'search') {
        type += ' input__body--search';
    }

    return type;
});
</script>

<template>
    <div :class="inputClass">
        <label v-if="label">
            {{ label }}
        </label>

        <!-- Select Field -->
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

        <!-- Search Field -->
        <input
            v-if="type === 'search'"
            :type="inputType"
            :placeholder="placeholder"
            class="input__search"
            :value="modelValue"
            @input="$emit('update:modelValue', $event.target.value)"
        />

        <!-- Field Input -->
        <input
            v-if="type === 'field'"
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
        </div>
    </div>
</template>
