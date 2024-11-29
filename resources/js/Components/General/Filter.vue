<script setup>
import { ref } from "vue";

const selectedOption = ref("profile");
const dropdownVisible = ref(false);

const toggleDropdown = () => {
    dropdownVisible.value = !dropdownVisible.value;
};

const selectOption = (option) => {
    selectedOption.value = option;
    dropdownVisible.value = false;
};
</script>

<template>
    <div class="filter">
        <!-- Filter Button -->
        <button @click="toggleDropdown" class="filter__button">
            <i class="fas fa-sliders filter__icon"></i>
        </button>

        <!-- Dropdown -->
        <div v-if="dropdownVisible" class="filter__dropdown">
            <label
                v-for="option in ['Profile', 'Creation Date', 'Last Modified']"
                :key="option"
                class="filter__option"
                @click="selectOption(option)"
            >
                {{ option }}
            </label>
        </div>
    </div>
</template>
