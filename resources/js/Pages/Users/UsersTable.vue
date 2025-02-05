<script setup>
import SecondaryButton from "@/Components/General/SecondaryButton.vue";

/**
 * Props passed to the component.
 * @property {Array} users - List of users to display in the table.
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
            <!-- Column header for Name with sorting functionality -->
            <th class="users__table-header-cell" @click="props.sortColumn('name')">
                <div class="users__table-header-sort">
                    <span>Name</span>
                    <button class="users__sort-button" @click.stop="props.sortColumn('name')">
                        <i :class="{
                            'fas fa-sort': props.sortConfig.column !== 'name' || props.sortConfig.direction === 'none',
                            'fas fa-sort-up': props.sortConfig.column === 'name' && props.sortConfig.direction === 'asc',
                            'fas fa-sort-down': props.sortConfig.column === 'name' && props.sortConfig.direction === 'desc'
                        }"></i>
                    </button>
                </div>
            </th>
            <!-- Column header for Email with sorting functionality -->
            <th class="users__table-header-cell" @click="props.sortColumn('email')">
                <div class="users__table-header-sort">
                    <span>Email</span>
                    <button class="users__sort-button" @click.stop="props.sortColumn('email')">
                        <i :class="{
                            'fas fa-sort': props.sortConfig.column !== 'email' || props.sortConfig.direction === 'none',
                            'fas fa-sort-up': props.sortConfig.column === 'email' && props.sortConfig.direction === 'asc',
                            'fas fa-sort-down': props.sortConfig.column === 'email' && props.sortConfig.direction === 'desc'
                        }"></i>
                    </button>
                </div>
            </th>
            <!-- Column header for Profiles with sorting functionality -->
            <th class="users__table-header-cell" @click="props.sortColumn('profiles')">
                <div class="users__table-header-sort">
                    <span>Profiles</span>
                    <button class="users__sort-button" @click.stop="props.sortColumn('profiles')">
                        <i :class="{
                            'fas fa-sort': props.sortConfig.column !== 'profiles' || props.sortConfig.direction === 'none',
                            'fas fa-sort-up': props.sortConfig.column === 'profiles' && props.sortConfig.direction === 'asc',
                            'fas fa-sort-down': props.sortConfig.column === 'profiles' && props.sortConfig.direction === 'desc'
                        }"></i>
                    </button>
                </div>
            </th>
            <!-- Empty column header for action buttons, visible if editing or deleting is allowed -->
            <th v-if="props.canEditUser || props.canDeleteUser"
                class="users__table-header-cell--actions">
            </th>
        </tr>
        </thead>
        <tbody class="users__table-body">
        <!-- Table rows for each user -->
        <tr v-for="user in props.users" :key="user.id" class="users__table-row">
            <td class="users__table-cell">{{ user.name }}</td>
            <td class="users__table-cell">{{ user.email }}</td>
            <td class="users__table-cell">{{ user.profiles.map(p => p.name).join(", ") }}</td>
            <!-- Action buttons for editing and deleting a user, visible if allowed -->
            <td v-if="props.canEditUser || props.canDeleteUser" class="users__table-cell">
                <div class="users__actions">
                    <SecondaryButton
                        v-if="props.canEditUser"
                        type="submit"
                        label=""
                        icon="fas fa-edit"
                        @click="props.openModal('edit', user)"
                    />
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

    <!-- Message displayed when no users are found -->
    <div v-if="props.users.length === 0" class="users__no-results">
        <p>No results found</p>
    </div>
</template>
