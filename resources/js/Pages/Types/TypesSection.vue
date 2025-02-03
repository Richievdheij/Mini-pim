<script setup>
import PrimaryButton from "@/Components/General/PrimaryButton.vue";
import Searchbar from "@/Components/General/Searchbar.vue";
import Filter from "@/Components/General/Filter.vue";

/**
 * Props passed to the component.
 * @property {Boolean} canCreateType - Indicates if the user can create a new type.
 * @property {String} searchQuery - The current search query.
 * @property {Function} openModal - Function to open a modal.
 */
const props = defineProps({
    canCreateType: Boolean,
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
    <div class="types__section">
        <div class="types__top-bar">
            <!-- Button to create a new type, visible if canCreateType is true -->
            <div class="types__create-button" v-if="props.canCreateType">
                <PrimaryButton
                    label="Create new Type"
                    type="cancel"
                    icon="fas fa-plus"
                    @click="props.openModal('create', null)"
                />
            </div>

            <!-- Search bar for filtering types -->
            <div class="types__search-bar">
                <Searchbar
                    id="search"
                    placeholder="Search..."
                    :modelValue="props.searchQuery"
                    @update:modelValue="value => emit('update:searchQuery', value)"
                />
            </div>

            <!-- Filter component for additional filtering options -->
            <div class="types__filter">
                <Filter/>
            </div>
        </div>
    </div>
</template>
