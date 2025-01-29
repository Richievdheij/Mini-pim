<script setup>
import SecondaryButton from "@/Components/General/SecondaryButton.vue";

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
            <th
                class="types__table-header-cell"
                @click="props.sortColumn('id')"
            >
                Type ID
                <i :class="{
                    'fas fa-sort-up': props.sortConfig.column === 'id' && props.sortConfig.direction === 'asc',
                    'fas fa-sort-down': props.sortConfig.column === 'id' && props.sortConfig.direction === 'desc'}">
                </i>
            </th>
            <th
                class="types__table-header-cell"
                @click="props.sortColumn('name')"
            >
                Name
                <i :class="{
                    'fas fa-sort-up': props.sortConfig.column === 'name' && props.sortConfig.direction === 'asc',
                    'fas fa-sort-down': props.sortConfig.column === 'name' && props.sortConfig.direction === 'desc'}">
                </i>
            </th>
            <th v-if="props.canEditType || props.canDeleteType"
                class="types__table-header-cell"></th>
        </tr>
        </thead>
        <tbody class="types__table-body">
        <tr v-for="type in props.types" :key="type.id" class="types__table-row">
            <td class="types__table-cell">{{ type.id }}</td>
            <td class="types__table-cell">{{ type.name }}</td>
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

    <div v-if="props.types.length === 0" class="types__no-results">
        <p>No results found</p>
    </div>
</template>
