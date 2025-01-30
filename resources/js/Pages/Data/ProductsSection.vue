<script setup>
import PrimaryButton from "@/Components/General/PrimaryButton.vue";
import Searchbar from "@/Components/General/Searchbar.vue";
import Filter from "@/Components/General/Filter.vue";

/**
 * Props passed to the component.
 * @property {Boolean} canCreateProduct - Indicates if the user can create a new product.
 * @property {String} searchQuery - The current search query.
 * @property {Function} openModal - Function to open a modal.
 */
const props = defineProps({
    canCreateProduct: Boolean,
    searchQuery: String,
    openModal: Function,
});

/**
 * Emits events from the component.
 * @event update:searchQuery - Emitted when the search query is updated.
 */
const emit = defineEmits(['update:searchQuery']);
</script>

<template>
    <div class="products__section">
        <div class="products__top-bar">
            <!-- Button to create a new product, visible if canCreateProduct is true -->
            <div class="products__create-button" v-if="props.canCreateProduct">
                <PrimaryButton
                    label="Create new Product"
                    type="cancel"
                    icon="fas fa-plus"
                    @click="props.openModal('create', null)"
                />
            </div>

            <!-- Search bar for filtering products -->
            <div class="products__search-bar">
                <Searchbar
                    id="search"
                    placeholder="Search..."
                    :modelValue="props.searchQuery"
                    @update:modelValue="value => emit('update:searchQuery', value)"
                />
            </div>

            <!-- Filter component for additional filtering options -->
            <div class="products__filter">
                <Filter/>
            </div>
        </div>
    </div>
</template>
