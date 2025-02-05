<script setup>
import SecondaryButton from "@/Components/General/SecondaryButton.vue";

/**
 * Props passed to the component.
 * @property {Array} attributes - The list of attributes to display in the table.
 * @property {Object} sortConfig - The current sorting configuration.
 * @property {Boolean} canEditAttribute - Indicates if the user can edit an attribute.
 * @property {Boolean} canDeleteAttribute - Indicates if the user can delete an attribute.
 * @property {Function} sortColumn - Function to sort the table by a specified column.
 * @property {Function} openModal - Function to open a modal for editing or deleting an attribute.
 */
const props = defineProps({
    attributes: Array,
    sortConfig: Object,
    canEditAttribute: Boolean,
    canDeleteAttribute: Boolean,
    sortColumn: Function,
    openModal: Function,
});
</script>

<template>
    <table class="attributes__table">
        <thead>
        <tr class="attributes__table-header">
            <!-- Column header for Name with sorting functionality -->
            <th class="attributes__table-header-cell" @click="props.sortColumn('name')">
                <div class="attributes__table-header-sort">
                    <span>Name</span>
                    <button class="attributes__sort-button" @click.stop="props.sortColumn('name')">
                        <i :class="{
                            'fas fa-sort': props.sortConfig.column !== 'name' || props.sortConfig.direction === 'none',
                            'fas fa-sort-up': props.sortConfig.column === 'name' && props.sortConfig.direction === 'asc',
                            'fas fa-sort-down': props.sortConfig.column === 'name' && props.sortConfig.direction === 'desc'
                        }"></i>
                    </button>
                </div>
            </th>
            <!-- Column header for Type with sorting functionality -->
            <th class="attributes__table-header-cell" @click="props.sortColumn('type')">
                <div class="attributes__table-header-sort">
                    <span>Type</span>
                    <button class="attributes__sort-button" @click.stop="props.sortColumn('type')">
                        <i :class="{
                            'fas fa-sort': props.sortConfig.column !== 'type' || props.sortConfig.direction === 'none',
                            'fas fa-sort-up': props.sortConfig.column === 'type' && props.sortConfig.direction === 'asc',
                            'fas fa-sort-down': props.sortConfig.column === 'type' && props.sortConfig.direction === 'desc'
                        }"></i>
                    </button>
                </div>
            </th>
            <!-- Empty column header for action buttons, visible if editing or deleting is allowed -->
            <th v-if="props.canEditAttribute || props.canDeleteAttribute"
                class="attributes__table-header-cell--actions">
            </th>
        </tr>
        </thead>
        <tbody class="attributes__table-body">
        <!-- Table rows for each attribute -->
        <tr v-for="attribute in props.attributes" :key="attribute.id" class="attributes__table-row">
            <td class="attributes__table-cell">{{ attribute.name }}</td>
            <td class="attributes__table-cell">{{ attribute.type.name }}</td>
            <!-- Action buttons for editing and deleting an attribute, visible if allowed -->
            <td v-if="props.canEditAttribute || props.canDeleteAttribute" class="attributes__table-cell">
                <div class="attributes__actions">
                    <SecondaryButton
                        v-if="props.canEditAttribute"
                        label=""
                        type="submit"
                        icon="fas fa-edit"
                        @click="props.openModal('edit', attribute)"
                    />
                    <SecondaryButton
                        v-if="props.canDeleteAttribute"
                        label=""
                        type="delete"
                        icon="fas fa-trash"
                        @click="props.openModal('delete', attribute)"
                    />
                </div>
            </td>
        </tr>
        </tbody>
    </table>

    <!-- Message displayed when no attributes are found -->
    <div v-if="props.attributes.length === 0" class="attributes__no-results">
        <p>No results found</p>
    </div>
</template>
