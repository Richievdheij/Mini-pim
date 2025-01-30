<script setup>
import SecondaryButton from "@/Components/General/SecondaryButton.vue";

/**
 * Props passed to the component.
 * @property {Array} profiles - List of profiles to display in the table.
 * @property {Object} sortConfig - Configuration object for sorting the table columns.
 * @property {Boolean} canEditProfile - Indicates if the user can edit a profile.
 * @property {Boolean} canDeleteProfile - Indicates if the user can delete a profile.
 * @property {Function} sortColumn - Function to sort the table by a specified column.
 * @property {Function} openModal - Function to open a modal.
 */
const props = defineProps({
    profiles: Array,
    sortConfig: Object,
    canEditProfile: Boolean,
    canDeleteProfile: Boolean,
    sortColumn: Function,
    openModal: Function,
});
</script>

<template>
    <table class="profiles__table">
        <thead>
        <tr class="profiles__table-header">
            <!-- Column header for Name with sorting functionality -->
            <th
                class="profiles__table-header-cell"
                @click="props.sortColumn('name')"
            >
                Name
                <i :class="{
                    'fas fa-sort-up': props.sortConfig.column === 'name' && props.sortConfig.direction === 'asc',
                    'fas fa-sort-down': props.sortConfig.column === 'name' && props.sortConfig.direction === 'desc'}">
                </i>
            </th>
            <!-- Empty column header for action buttons, visible if editing or deleting is allowed -->
            <th v-if="props.canEditProfile || props.canDeleteProfile"
                class="profiles__table-header-cell"></th>
        </tr>
        </thead>
        <tbody class="profiles__table-body">
        <!-- Table rows for each profile -->
        <tr v-for="profile in props.profiles" :key="profile.id" class="profiles__table-row">
            <td class="profiles__table-cell">{{ profile.name }}</td>
            <!-- Action buttons for editing and deleting a profile, visible if allowed -->
            <td v-if="props.canEditProfile || props.canDeleteProfile" class="profiles__table-cell">
                <div class="profiles__actions">
                    <SecondaryButton
                        v-if="props.canEditProfile"
                        label=""
                        type="submit"
                        icon="fas fa-edit"
                        @click="props.openModal('edit', profile)"
                    />
                    <SecondaryButton
                        v-if="props.canDeleteProfile"
                        label=""
                        type="delete"
                        icon="fas fa-trash"
                        @click="props.openModal('delete', profile)"
                    />
                </div>
            </td>
        </tr>
        </tbody>
    </table>

    <!-- Message displayed when no profiles are found -->
    <div v-if="props.profiles.length === 0" class="profiles__no-results">
        <p>No results found</p>
    </div>
</template>
