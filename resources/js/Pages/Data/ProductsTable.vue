<script setup>
import SecondaryButton from "@/Components/General/SecondaryButton.vue";

/**
 * Props passed to the component.
 * @property {Array} products - List of products to display in the table.
 * @property {Object} sortConfig - Configuration object for sorting the table columns.
 * @property {Boolean} canEditProduct - Indicates if the user can edit a product.
 * @property {Boolean} canDeleteProduct - Indicates if the user can delete a product.
 * @property {Function} sortColumn - Function to sort the table by a specified column.
 * @property {Function} openModal - Function to open a modal.
 */
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
            <!-- Column header for Product ID with sorting functionality -->
            <th class="products__table-header-cell" @click="props.sortColumn('product_id')">
                <div class="products__table-header-sort">
                    <span>Product ID</span>
                    <button class="products__sort-button" @click.stop="props.sortColumn('product_id')">
                        <i :class="{
                            'fas fa-sort': props.sortConfig.column !== 'product_id' || props.sortConfig.direction === 'none',
                            'fas fa-sort-up': props.sortConfig.column === 'product_id' && props.sortConfig.direction === 'asc',
                            'fas fa-sort-down': props.sortConfig.column === 'product_id' && props.sortConfig.direction === 'desc'
                        }"></i>
                    </button>
                </div>
            </th>
            <th class="products__table-header-cell" @click="props.sortColumn('name')">
                <!-- Column header for Name with sorting functionality -->
                <div class="products__table-header-sort">
                    <span>Name</span>
                    <button class="products__sort-button" @click.stop="props.sortColumn('name')">
                        <i :class="{
                            'fas fa-sort': props.sortConfig.column !== 'name' || props.sortConfig.direction === 'none',
                            'fas fa-sort-up': props.sortConfig.column === 'name' && props.sortConfig.direction === 'asc',
                            'fas fa-sort-down': props.sortConfig.column === 'name' && props.sortConfig.direction === 'desc'
                        }"></i>
                    </button>
                </div>
            </th>
            <th class="products__table-header-cell" @click="props.sortColumn('type')">
                <!-- Column header for Type with sorting functionality -->
                <div class="products__table-header-sort">
                    <span>Type</span>
                    <button class="products__sort-button" @click.stop="props.sortColumn('type')">
                        <i :class="{
                            'fas fa-sort': props.sortConfig.column !== 'type' || props.sortConfig.direction === 'none',
                            'fas fa-sort-up': props.sortConfig.column === 'type' && props.sortConfig.direction === 'asc',
                            'fas fa-sort-down': props.sortConfig.column === 'type' && props.sortConfig.direction === 'desc'
                        }"></i>
                    </button>
                </div>
            </th>

            <!-- Empty column header for action buttons, visible if editing or deleting is allowed -->
            <th v-if="props.canEditProduct || props.canDeleteProduct"
                class="products__table-header-cell--actions">
            </th>
        </tr>
        </thead>
        <tbody class="products__table-body">
        <!-- Table rows for each product -->
        <tr v-for="product in props.products" :key="product.id" class="products__table-row">
            <td class="products__table-cell">{{ product.product_id }}</td>
            <td class="products__table-cell">{{ product.name }}</td>
            <td class="products__table-cell">{{ product.type.name }}</td>
            <!-- Action buttons for editing and deleting a product, visible if allowed -->
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

    <!-- Message displayed when no products are found -->
    <div v-if="props.products.length === 0" class="products__no-results">
        <p>No results found</p>
    </div>
</template>
