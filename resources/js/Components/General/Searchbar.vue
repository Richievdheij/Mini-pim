<script setup>
const props = defineProps({
    modelValue: String,
    placeholder: {
        type: String,
        default: "Search...",
    },
    id: {
        type: String,
        default: "search",
    },
    icon: {
        type: String,
        default: "fas fa-search",
    },
});

function onInput(event) {
    emit('update:modelValue', event.target.value);
}

const emit = defineEmits(["update:modelValue"]);
</script>

<template>
    <div class="searchbar__body">
        <i
            v-if="icon"
            :class="['searchbar__icon', icon]">
        </i>
        <input
            :id="id"
            :placeholder="placeholder"
            class="searchbar__input"
            type="search"
            :value="modelValue"
            @input="onInput"
        />
    </div>
</template>
