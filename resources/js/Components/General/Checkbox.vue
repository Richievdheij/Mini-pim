<script setup>
import { defineProps, computed } from 'vue';

const props = defineProps({
  label: String,
  extraClass: String, // Add extraClass prop
  modelValue: Boolean, // Model value to bind with the parent form
});

const emit = defineEmits(['update:modelValue']);

// Computed property to generate the class string
const checkboxClass = computed(() => {
  return `checkbox checkbox__body ${props.extraClass || ''}`.trim(); // Trim to remove extra space
});
</script>

<template>
  <div :class="checkboxClass">
        <input
          class="checkbox__input"
          type="checkbox"
          :checked="modelValue"
          @input="$emit('update:modelValue', $event.target.checked)"
        />

        <label class="checkbox__label" for="agreement">
          {{ label }}
        </label>
  </div>
</template>
