<script setup>
import PrimaryButton from "@/Components/General/PrimaryButton.vue";
import Searchbar from "@/Components/General/Searchbar.vue";
import Filter from "@/Components/General/Filter.vue";

/**
 * Props passed to the component.
 * @property {Boolean} canCreateProfile - Indicates if the user can create a new profile.
 * @property {String} searchQuery - The current search query.
 * @property {Function} openModal - Function to open a modal.
 */
const props = defineProps({
    canCreateProfile: Boolean,
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
    <div class="profiles__section">
        <div class="profiles__top-bar">
            <!-- Button to create a new profile, visible if canCreateProfile is true -->
            <div class="profiles__create-button" v-if="props.canCreateProfile">
                <PrimaryButton
                    label="Create new Profile"
                    type="cancel"
                    icon="fas fa-plus"
                    @click="props.openModal('create', null)"
                />
            </div>

            <!-- Search bar for filtering profiles -->
            <div class="profiles__search-bar">
                <Searchbar
                    id="search"
                    placeholder="Search..."
                    :modelValue="props.searchQuery"
                    @update:modelValue="value => emit('update:searchQuery', value)"
                />
            </div>

            <!-- Filter component for additional filtering options -->
            <div class="profiles__filter">
                <Filter/>
            </div>
        </div>
    </div>
</template>
