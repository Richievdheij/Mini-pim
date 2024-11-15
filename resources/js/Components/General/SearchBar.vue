<script setup>
import { ref } from 'vue';

const modelValue = ref('');
const emit = defineEmits(['update:modelValue']);

const handleInputChange = (event) => {
    modelValue.value = event.target.value;
    emit('update:modelValue', modelValue.value);
};
</script>

<template>
    <div class="search-bar">
        <input
            v-model="modelValue"
            type="text"
            class="search-bar__input"
            placeholder="Search..."
            @input="handleInputChange"
        />
    </div>
</template>

<style scoped>
.search-bar {
    &__input {
        width: 100%;
        padding: 0.5rem 1rem;
        font-size: 1rem;
        border: 1px solid #ccc;
        border-radius: 4px;
        transition: border-color 0.3s ease;
    }

    &__input:focus {
        border-color: #4a90e2;
        outline: none;
    }
}
</style>
