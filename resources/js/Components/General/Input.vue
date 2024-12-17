<script setup>
import { defineProps, computed } from 'vue';

// Define the props and emits
const props = defineProps({
    disabled: {
        type: Boolean,
        default: false,
    },
    error: String,
    inputType: String,
    label: String,
    message: String,
    modelValue: [
        String,
        Array
    ],
    multiple: Boolean,
    types: {
        type: Array,
        default: () => [],
    },
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
    if (props.type === 'field') {
        type += ' input__body--field';
    }
    if (props.type === 'select') {
        type += ' input__body--select';
    }
    if (props.type === 'search') {
        type += ' input__body--search';
    }
    if (props.type === 'selectType') {
        type += ' input__body--select';
    }

    return type;
});

// Compute placeholder text based on type
const computedPlaceholder = computed(() => {
    if (props.type === 'select') {
        return props.placeholder || 'Select a profile';  // Default placeholder for profile selection
    }
    if (props.type === 'selectType') {
        return props.placeholder || 'Select a type';  // Default placeholder for type selection
    }
    return props.placeholder || '';  // Default placeholder for other types
});
</script>

<template>
    <div :class="inputClass">
        <label v-if="label">
            {{ label }}
        </label>

        <!-- Select Field assign profiles -->
        <select
            v-if="type === 'select'"
            class="input__select"
            :multiple="false"
            :value="modelValue"
            @change="$emit('update:modelValue', Array.from($event.target.selectedOptions, option => option.value))"
        >
            <option value="" disabled selected>{{ computedPlaceholder }}</option>
            <option
                v-for="option in options"
                :key="option.id || option"
                :value="option.id || option"
            >
                {{ option.name || option }}
            </option>
        </select>

        <!-- Select Field for assigning types (SelectType) -->
        <select
            v-if="type === 'selectType'"
            class="input__select"
            :multiple="false"
            :value="modelValue"
            @change="$emit('update:modelValue',  $event.target.value)"
        >
            <option value="" disabled selected>{{ computedPlaceholder }}</option>
            <option
                v-for="option in types"
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
            :disabled="props.disabled"
            @input="$emit('update:modelValue', $event.target.value)"
        />

        <!-- Error or Success Message Container -->
        <div class="input__message-container">
            <p class="input__error" v-if="error">{{ error }}</p>
        </div>
    </div>
</template>


