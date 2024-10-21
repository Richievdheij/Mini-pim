<script setup>
import { defineProps, computed } from 'vue';

const props = defineProps({
  label: String,
  type: String
});

// Computed property to generate the class string
const buttonType = computed(() => {
  let type = 'button button__body';

  if (props.type === 'submit') {
    type += ' button__body--submit';
  }

  if (props.type === 'delete') {
    type += ' button__body--delete';
  }

  return type;
});
</script>

<template>
  <button :class="buttonType" type="submit">{{ label }}</button>
</template>