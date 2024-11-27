<script setup>
import { defineProps, computed } from 'vue';

const props = defineProps({
    label: String,
    type: {
        type: String,
        default: 'primary'
    },
    icon: String,
});

const buttonType = computed(() => {
    let type = 'button button__body';

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
        <div class="button__icon-container">
            <i
                v-if="icon"
                :class="icon">
            </i>
        </div>
            {{ label }}
    </button>
</template>
