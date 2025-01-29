<script setup>
import SecondaryButton from "@/Components/General/SecondaryButton.vue";

const props = defineProps({
    products: Array,
    sortConfig: Object,
    canEditProduct: Boolean,
    canDeleteProduct: Boolean,
    sortColumn: Function,
    openModal: Function,
});
</script>

<template>
    <table class="products__table">
        <thead>
        <tr class="products__table-header">
            <th
                class="products__table-header-cell"
                @click="props.sortColumn('product_id')"
            >
                Product ID
                <i :class="{
                    'fas fa-sort-up': props.sortConfig.column === 'product_id' && props.sortConfig.direction === 'asc',
                    'fas fa-sort-down': props.sortConfig.column === 'product_id' && props.sortConfig.direction === 'desc'}">
                </i>
            </th>
            <th
                class="products__table-header-cell"
                @click="props.sortColumn('name')"
            >
                Name
                <i :class="{
                    'fas fa-sort-up': props.sortConfig.column === 'name' && props.sortConfig.direction === 'asc',
                    'fas fa-sort-down': props.sortConfig.column === 'name' && props.sortConfig.direction === 'desc'}">
                </i>
            </th>
            <th
                class="products__table-header-cell"
                @click="props.sortColumn('type')"
            >
                Type
                <i :class="{
                    'fas fa-sort-up': props.sortConfig.column === 'type' && props.sortConfig.direction === 'asc',
                    'fas fa-sort-down': props.sortConfig.column === 'type' && props.sortConfig.direction === 'desc'}">
                </i>
            </th>
            <th v-if="props.canEditProduct || props.canDeleteProduct"
                class="products__table-header-cell"></th>
        </tr>
        </thead>
        <tbody class="products__table-body">
        <tr v-for="product in props.products" :key="product.id" class="products__table-row">
            <td class="products__table-cell">{{ product.product_id }}</td>
            <td class="products__table-cell">{{ product.name }}</td>
            <td class="products__table-cell">{{ product.type.name }}</td>
            <td v-if="props.canEditProduct || props.canDeleteProduct" class="products__table-cell">
                <div class="products__actions">
                    <SecondaryButton
                        v-if="props.canEditProduct"
                        label=""
                        type="submit"
                        icon="fas fa-edit"
                        @click="props.openModal('edit', product)"
                    />
                    <SecondaryButton
                        v-if="props.canDeleteProduct"
                        label=""
                        type="delete"
                        icon="fas fa-trash"
                        @click="props.openModal('delete', product)"
                    />
                </div>
            </td>
        </tr>
        </tbody>
    </table>

    <div v-if="props.products.length === 0" class="products__no-results">
        <p>No results found</p>
    </div>
</template>
