<script setup>
import { ref, onMounted } from 'vue';

const props = defineProps({
    message: String,
    type: {
        type: String,
        default: 'success',
    },
});

const emit = defineEmits(['close']);
const visible = ref(true);

onMounted(() => {
    setTimeout(() => {
        visible.value = false;
        emit('close');
    }, 5000);
});
</script>

<template>
    <div
        v-if="visible"
        :class="['notification', `notification--${type}`]"
        role="alert"
    >
        <p class="notification__message">{{ message }}</p>
        <button class="notification__close" @click="() => { visible.value = false; emit('close'); }">
            &times;
        </button>
    </div>
</template>

