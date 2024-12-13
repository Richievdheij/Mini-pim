<script setup>
import { defineProps, computed } from 'vue';

const props = defineProps({
    label: String,
    type: {
        type: String,
        default: 'secondary'
    },
    icon: String,
});

// Compute the button class based on the type
const buttonType = computed(() => {
    let type = 'button button__body button__body--secondary';

    if (props.type === 'submit') {
        type += ' button__body--submit';
    }
    if (props.type === 'delete') {
        type += ' button__body--delete';
    }
    if (props.type === 'cancel') {
        type += ' button__body--cancel';
    }

    return type;
});
</script>

<template>
    <button :class="buttonType" type="submit">
        <!-- Add icon if provided -->
        <i v-if="icon" :class="icon"></i>
        {{ label }}
    </button>
</template>
