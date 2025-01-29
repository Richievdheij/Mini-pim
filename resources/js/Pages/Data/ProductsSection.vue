<script setup>
import PrimaryButton from "@/Components/General/PrimaryButton.vue";
import Searchbar from "@/Components/General/Searchbar.vue";
import Filter from "@/Components/General/Filter.vue";

const props = defineProps({
    canCreateProduct: Boolean,
    searchQuery: String,
    openModal: Function,
});

const emit = defineEmits(['update:searchQuery']);
</script>

<template>
    <div class="products__section">
        <div class="products__top-bar">
            <div class="products__create-button" v-if="props.canCreateProduct">
                <PrimaryButton
                    label="Create new Product"
                    type="cancel"
                    icon="fas fa-plus"
                    @click="props.openModal('create', null)"
                />
            </div>

            <div class="products__search-bar">
                <Searchbar
                    id="search"
                    placeholder="Search..."
                    :modelValue="props.searchQuery"
                    @update:modelValue="value => emit('update:searchQuery', value)"
                />
            </div>

            <div class="products__filter">
                <Filter/>
            </div>
        </div>
    </div>
</template>
