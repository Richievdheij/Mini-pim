<script setup>
import PrimaryButton from "@/Components/General/PrimaryButton.vue";
import Searchbar from "@/Components/General/Searchbar.vue";
import Filter from "@/Components/General/Filter.vue";

const props = defineProps({
    canCreateUser: Boolean,
    searchQuery: String,
    openModal: Function,
});

const emit = defineEmits(['update:searchQuery']);
</script>

<template>
    <div class="users__section">
        <div class="users__top-bar">
            <div class="users__create-button" v-if="props.canCreateUser">
                <PrimaryButton
                    label="Create new User"
                    type="cancel"
                    icon="fas fa-plus"
                    @click="props.openModal('create', null)"
                />
            </div>

            <div class="users__search-bar">
                <Searchbar
                    id="search"
                    placeholder="Search..."
                    :modelValue="props.searchQuery"
                    @update:modelValue="value => emit('update:searchQuery', value)"
                />
            </div>

            <div class="users__filter">
                <Filter/>
            </div>
        </div>
    </div>
</template>
