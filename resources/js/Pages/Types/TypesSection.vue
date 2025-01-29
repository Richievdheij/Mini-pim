<script setup>
import PrimaryButton from "@/Components/General/PrimaryButton.vue";
import Searchbar from "@/Components/General/Searchbar.vue";
import Filter from "@/Components/General/Filter.vue";

const props = defineProps({
    canCreateType: Boolean,
    searchQuery: String,
    openModal: Function,
});

const emit = defineEmits(['update:searchQuery']);
</script>

<template>
    <div class="types__section">
        <div class="types__top-bar">
            <div class="types__create-button" v-if="props.canCreateType">
                <PrimaryButton
                    label="Create new Type"
                    type="cancel"
                    icon="fas fa-plus"
                    @click="props.openModal('create', null)"
                />
            </div>

            <div class="types__search-bar">
                <Searchbar
                    id="search"
                    placeholder="Search..."
                    :modelValue="props.searchQuery"
                    @update:modelValue="value => emit('update:searchQuery', value)"
                />
            </div>

            <div class="types__filter">
                <Filter/>
            </div>
        </div>
    </div>
</template>
