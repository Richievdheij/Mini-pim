<script setup>
import { ref } from "vue";

const selectedOption = ref("profile");
const dropdownVisible = ref(false);

// Toggle the dropdown visibility
const toggleDropdown = () => {
    dropdownVisible.value = !dropdownVisible.value;
};

// Select the option and hide the dropdown
const selectOption = (option) => {
    selectedOption.value = option;
    dropdownVisible.value = false;
};

</script>

<template>
    <div class="filter">
        <!-- Filter Button -->
        <button @click="toggleDropdown" class="filter__button">
            <i
                class="fas fa-sliders filter__icon">
            </i>
        </button>

        <!-- Removed v-if="dropdownVisible" to disable -->
        <!-- Dropdown -->
        <div class="filter__dropdown">
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
