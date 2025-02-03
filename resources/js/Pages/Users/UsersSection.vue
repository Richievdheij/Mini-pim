<script setup>
import PrimaryButton from "@/Components/General/PrimaryButton.vue";
import Searchbar from "@/Components/General/Searchbar.vue";
import Filter from "@/Components/General/Filter.vue";

/**
 * Props passed to the component.
 * @property {Boolean} canCreateUser - Indicates if the user can create a new user.
 * @property {String} searchQuery - The current search query.
 * @property {Function} openModal - Function to open a modal.
 */
const props = defineProps({
    canCreateUser: Boolean,
    searchQuery: String,
    openModal: Function,
});

/**
 * Emits an event to update the search query.
 * @event update:searchQuery
 */
const emit = defineEmits(['update:searchQuery']);
</script>

<template>
    <div class="users__section">
        <div class="users__top-bar">
            <!-- Button to create a new user, visible if allowed -->
            <div class="users__create-button" v-if="props.canCreateUser">
                <PrimaryButton
                    label="Create new User"
                    type="cancel"
                    icon="fas fa-plus"
                    @click="props.openModal('create', null)"
                />
            </div>

            <!-- Search bar component for filtering users -->
            <div class="users__search-bar">
                <Searchbar
                    id="search"
                    placeholder="Search..."
                    :modelValue="props.searchQuery"
                    @update:modelValue="value => emit('update:searchQuery', value)"
                />
            </div>

            <!-- Filter component for additional filtering options -->
            <div class="users__filter">
                <Filter/>
            </div>
        </div>
    </div>
</template>
