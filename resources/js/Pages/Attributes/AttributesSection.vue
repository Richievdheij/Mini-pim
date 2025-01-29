<script setup>
import PrimaryButton from "@/Components/General/PrimaryButton.vue";
import Searchbar from "@/Components/General/Searchbar.vue";
import Filter from "@/Components/General/Filter.vue";

const props = defineProps({
    canCreateAttribute: Boolean,
    searchQuery: String,
    openModal: Function,
});

const emit = defineEmits(['update:searchQuery']);
</script>

<template>
    <div class="attributes__section">
        <div class="attributes__top-bar">
            <div class="attributes__create-button" v-if="props.canCreateAttribute">
                <PrimaryButton
                    label="Create new Attribute"
                    type="cancel"
                    icon="fas fa-plus"
                    @click="props.openModal('create', null)"
                />
            </div>

            <div class="attributes__search-bar">
                <Searchbar
                    id="search"
                    placeholder="Search..."
                    :modelValue="props.searchQuery"
                    @update:modelValue="value => emit('update:searchQuery', value)"
                />
            </div>

            <div class="attributes__filter">
                <Filter/>
            </div>
        </div>
    </div>
</template>
