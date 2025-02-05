<script setup>
import SecondaryButton from "@/Components/General/SecondaryButton.vue";

/**
 * Props passed to the component.
 * @property {Array} types - List of types to display in the table.
 * @property {Object} sortConfig - Configuration object for sorting the table columns.
 * @property {Boolean} canEditType - Indicates if the user can edit a type.
 * @property {Boolean} canDeleteType - Indicates if the user can delete a type.
 * @property {Function} sortColumn - Function to sort the table by a specified column.
 * @property {Function} openModal - Function to open a modal.
 */
const props = defineProps({
    types: Array,
    sortConfig: Object,
    canEditType: Boolean,
    canDeleteType: Boolean,
    sortColumn: Function,
    openModal: Function,
});
</script>

<template>
    <table class="types__table">
        <thead>
        <tr class="types__table-header">
            <!-- Column header for Type ID with sorting functionality -->
            <th class="types__table-header-cell" @click="props.sortColumn('id')">
                <div class="types__table-header-sort">
                    <span>Type ID</span>
                    <button class="types__sort-button" @click.stop="props.sortColumn('id')">
                        <i :class="{
                            'fas fa-sort': props.sortConfig.column !== 'id' || props.sortConfig.direction === 'none',
                            'fas fa-sort-up': props.sortConfig.column === 'id' && props.sortConfig.direction === 'asc',
                            'fas fa-sort-down': props.sortConfig.column === 'id' && props.sortConfig.direction === 'desc'
                        }"></i>
                    </button>
                </div>
            </th>
            <!-- Column header for Name with sorting functionality -->
            <th class="types__table-header-cell" @click="props.sortColumn('name')">
                <div class="types__table-header-sort">
                    <span>Name</span>
                    <button class="types__sort-button" @click.stop="props.sortColumn('name')">
                        <i :class="{
                            'fas fa-sort': props.sortConfig.column !== 'name' || props.sortConfig.direction === 'none',
                            'fas fa-sort-up': props.sortConfig.column === 'name' && props.sortConfig.direction === 'asc',
                            'fas fa-sort-down': props.sortConfig.column === 'name' && props.sortConfig.direction === 'desc'
                        }"></i>
                    </button>
                </div>
            </th>
            <!-- Empty column header for action buttons, visible if editing or deleting is allowed -->
            <th v-if="props.canEditType || props.canDeleteType"
                class="types__table-header-cell--actions">
            </th>
        </tr>
        </thead>
        <tbody class="types__table-body">
        <!-- Table rows for each type -->
        <tr v-for="type in props.types" :key="type.id" class="types__table-row">
            <td class="types__table-cell">{{ type.id }}</td>
            <td class="types__table-cell">{{ type.name }}</td>
            <!-- Action buttons for editing and deleting a type, visible if allowed -->
            <td v-if="props.canEditType || props.canDeleteType" class="types__table-cell">
                <div class="types__actions">
                    <SecondaryButton
                        v-if="props.canEditType"
                        label=""
                        type="submit"
                        icon="fas fa-edit"
                        @click="props.openModal('edit', type)"
                    />
                    <SecondaryButton
                        v-if="props.canDeleteType"
                        label=""
                        type="delete"
                        icon="fas fa-trash"
                        @click="props.openModal('delete', type)"
                    />
                </div>
            </td>
        </tr>
        </tbody>
    </table>

    <!-- Message displayed when no types are found -->
    <div v-if="props.types.length === 0" class="types__no-results">
        <p>No results found</p>
    </div>
</template>
