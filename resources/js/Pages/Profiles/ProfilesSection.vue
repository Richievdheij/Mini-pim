<script setup>
import PrimaryButton from "@/Components/General/PrimaryButton.vue";
import Searchbar from "@/Components/General/Searchbar.vue";
import Filter from "@/Components/General/Filter.vue";

const props = defineProps({
    canCreateProfile: Boolean,
    searchQuery: String,
    openModal: Function,
});

const emit = defineEmits(['update:searchQuery']);
</script>

<template>
    <div class="profiles__section">
        <div class="profiles__top-bar">
            <div class="profiles__create-button" v-if="props.canCreateProfile">
                <PrimaryButton
                    label="Create new Profile"
                    type="cancel"
                    icon="fas fa-plus"
                    @click="props.openModal('create', null)"
                />
            </div>

            <div class="profiles__search-bar">
                <Searchbar
                    id="search"
                    placeholder="Search..."
                    :modelValue="props.searchQuery"
                    @update:modelValue="value => emit('update:searchQuery', value)"
                />
            </div>

            <div class="profiles__filter">
                <Filter/>
            </div>
        </div>
    </div>
</template>
