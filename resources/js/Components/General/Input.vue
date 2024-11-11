<script setup>
import { defineProps, computed } from 'vue';
const props = defineProps({
  label: String,         // Label text for InputLabel
  placeholder: String,   // Placeholder for InputField
  inputType: String,     // Type of the input field, e.g., 'text', 'password'
  message: String,       // Error message for InputError
  type: {
    type: String,
    required: true,      // Can be 'error', 'field', 'label or 'status'
  },
  modelValue: String,    // v-model value from parent component (form data)
});

// Emit event to update v-model
const emit = defineEmits(['update:modelValue']);

// Computed class to apply based on the input type (error, field, or label)
const inputClass = computed(() => {
  let type = 'input input__body';
  if (props.message) {
    type += ' input__body--error';
  }
  if (props.type === 'field') {
    type += ' input__body--field';
  }
  if (props.type === 'label') {
    type += ' input__body--label';
  }
if (props.type === 'status') {
    type += ' input__body--status';
}
  return type;
});

</script>
<template>
  <div :class="inputClass">
    <!-- If type is 'label', display the input label -->
    <label v-if="label">
      {{ label }}
    </label>

    <!-- If type is 'field', display the input field -->
    <input
      v-if="type === 'field'"
      :type="inputType"
      :placeholder="placeholder"
      class="input__field"
      :class="{ 'has-value': modelValue }"
      :value="modelValue"
      @input="$emit('update:modelValue', $event.target.value)"
    />

    <!-- If type is 'error', display the error message -->
    <div v-if="type === 'error'" class="input__error">
      <p>{{ message }}</p>
    </div>

    <!-- If type is 'status', display the status message -->
      <div v-if="type === 'status'" class="input__status">
          <p>{{ message }}</p>
      </div>
  </div>
</template>
