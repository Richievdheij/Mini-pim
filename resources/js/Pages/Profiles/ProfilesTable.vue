<script setup>
import SecondaryButton from "@/Components/General/SecondaryButton.vue";

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
            <th v-if="props.canEditProfile || props.canDeleteProfile"
                class="profiles__table-header-cell"></th>
        </tr>
        </thead>
        <tbody class="profiles__table-body">
        <tr v-for="profile in props.profiles" :key="profile.id" class="profiles__table-row">
            <td class="profiles__table-cell">{{ profile.name }}</td>
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

    <div v-if="props.profiles.length === 0" class="profiles__no-results">
        <p>No results found</p>
    </div>
</template>
