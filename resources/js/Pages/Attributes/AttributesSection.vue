<script setup>
import PrimaryButton from "@/Components/General/PrimaryButton.vue";
import Searchbar from "@/Components/General/Searchbar.vue";
import Filter from "@/Components/General/Filter.vue";

/**
 * Props passed to the component.
 * @property {Boolean} canCreateAttribute - Indicates if the user can create a new attribute.
 * @property {String} searchQuery - The current search query.
 * @property {Function} openModal - Function to open a modal.
 */
const props = defineProps({
    canCreateAttribute: Boolean,
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
    <div class="attributes__section">
        <div class="attributes__top-bar">
            <!-- Button to create a new attribute, visible if canCreateAttribute is true -->
            <div class="attributes__create-button" v-if="props.canCreateAttribute">
                <PrimaryButton
                    label="Create new Attribute"
                    type="cancel"
                    icon="fas fa-plus"
                    @click="props.openModal('create', null)"
                />
            </div>

            <!-- Search bar for filtering attributes -->
            <div class="attributes__search-bar">
                <Searchbar
                    id="search"
                    placeholder="Search..."
                    :modelValue="props.searchQuery"
                    @update:modelValue="value => emit('update:searchQuery', value)"
                />
            </div>

            <!-- Filter component for additional filtering options -->
            <div class="attributes__filter">
                <Filter/>
            </div>
        </div>
    </div>
</template>
