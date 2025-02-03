<script setup>
import SecondaryButton from "@/Components/General/SecondaryButton.vue";

/**
 * Props passed to the component.
 * @property {Array} users - List of user objects.
 * @property {Object} sortConfig - Configuration object for sorting the table columns.
 * @property {Boolean} canEditUser - Indicates if the user can edit a user.
 * @property {Boolean} canDeleteUser - Indicates if the user can delete a user.
 * @property {Function} sortColumn - Function to sort the table by a specified column.
 * @property {Function} openModal - Function to open a modal.
 */
const props = defineProps({
    users: Array,
    sortConfig: Object,
    canEditUser: Boolean,
    canDeleteUser: Boolean,
    sortColumn: Function,
    openModal: Function,
});
</script>

<template>
    <table class="users__table">
        <thead>
        <tr class="users__table-header">
            <th
                class="users__table-header-cell"
                @click="props.sortColumn('name')"
            >
                <!-- Column header for user name with sorting icon -->
                Name
                <i :class="{
                    'fas fa-sort-up': props.sortConfig.column === 'name' && props.sortConfig.direction === 'asc',
                    'fas fa-sort-down': props.sortConfig.column === 'name' && props.sortConfig.direction === 'desc'}">
                </i>
            </th>
            <th
                class="users__table-header-cell"
                @click="props.sortColumn('email')"
            >
                <!-- Column header for user email with sorting icon -->
                Email
                <i :class="{
                    'fas fa-sort-up': props.sortConfig.column === 'email' && props.sortConfig.direction === 'asc',
                    'fas fa-sort-down': props.sortConfig.column === 'email' && props.sortConfig.direction === 'desc'}">
                </i>
            </th>
            <th
                class="users__table-header-cell"
                @click="props.sortColumn('profiles')"
            >
                <!-- Column header for user profiles with sorting icon -->
                Profiles
                <i :class="{
                    'fas fa-sort-up': props.sortConfig.column === 'profiles' && props.sortConfig.direction === 'asc',
                    'fas fa-sort-down': props.sortConfig.column === 'profiles' && props.sortConfig.direction === 'desc'}">
                </i>
            </th>
            <th v-if="props.canEditUser || props.canDeleteUser"
                class="users__table-header-cell"></th>
        </tr>
        </thead>
        <tbody class="users__table-body">
        <tr v-for="user in props.users" :key="user.id" class="users__table-row">
            <td class="users__table-cell">{{ user.name }}</td>
            <td class="users__table-cell">{{ user.email }}</td>
            <td class="users__table-cell">{{ user.profiles.map(p => p.name).join(", ") }}</td>
            <td v-if="props.canEditUser || props.canDeleteUser" class="users__table-cell">
                <div class="users__actions">
                    <!-- Button to edit user, visible if allowed -->
                    <SecondaryButton
                        v-if="props.canEditUser"
                        type="submit"
                        label=""
                        icon="fas fa-edit"
                        @click="props.openModal('edit', user)"
                    />
                    <!-- Button to delete user, visible if allowed -->
                    <SecondaryButton
                        v-if="props.canDeleteUser"
                        type="delete"
                        label=""
                        icon="fas fa-trash"
                        @click="props.openModal('delete', user)"
                    />
                </div>
            </td>
        </tr>
        </tbody>
    </table>

    <div v-if="props.users.length === 0" class="users__no-results">
        <!-- Message displayed when no users are found -->
        <p>No results found</p>
    </div>
</template>
