<script setup>
import { ref, computed } from "vue";
import { Head, usePage } from "@inertiajs/vue3";
import TypeCreateModal from "@/Components/Admin/Data/Types/TypeCreateModal.vue";
import TypeEditModal from "@/Components/Admin/Data/Types/TypeEditModal.vue";
import TypeDeleteModal from "@/Components/Admin/Data/Types/TypeDeleteModal.vue";
import PIMLayout from "@/Layouts/PIMLayout.vue";
import PrimaryButton from "@/Components/General/PrimaryButton.vue";
import SecondaryButton from "@/Components/General/SecondaryButton.vue";
import Searchbar from "@/Components/General/Searchbar.vue";
import Filter from "@/Components/General/Filter.vue";

const props = defineProps({
    canCreateType: Boolean,
    canEditType: Boolean,
    canDeleteType: Boolean,
});

const { types } = usePage().props;

const showCreateModal = ref(false);
const showEditModal = ref(false);
const showDeleteModal = ref(false);
const typeToEdit = ref(null);
const typeToDelete = ref(null);
const selectedType = ref(null);
const searchQuery = ref("");

// Sort configuration state
const sortConfig = ref({
    column: null,
    direction: "none", // 'none', 'asc', or 'desc'
});

// Open modal for create/edit/delete
function openModal(modalType, type = null) {
    selectedType.value = type;

    if (modalType === "edit") {
        showEditModal.value = true;
    } else if (modalType === "delete") {
        showDeleteModal.value = true;
    } else if (modalType === "create") {
        showCreateModal.value = true;
    }
}

// Close modal for create/edit/delete
function closeModal(modalType) {
    selectedType.value = null;

    if (modalType === "edit") {
        showEditModal.value = false;
    } else if (modalType === "delete") {
        showDeleteModal.value = false;
    } else if (modalType === "create") {
        showCreateModal.value = false;
    }
}

// Search and Sorting
const filteredTypes = computed(() => {
    return types.filter((type) =>
        type.name.toLowerCase().includes(searchQuery.value.toLowerCase())
    );
});

function sortColumn(column) {
    const { direction } = sortConfig.value;
    let newDirection = "asc";

    if (direction === "asc") {
        newDirection = "desc";
    } else if (direction === "desc") {
        newDirection = "none";
    }

    sortConfig.value = {
        column,
        direction: newDirection,
    };
}

const sortedTypes = computed(() => {
    const { column, direction } = sortConfig.value;
    let typesToSort = [...filteredTypes.value];

    if (column && direction !== "none") {
        typesToSort.sort((a, b) => {
            const aValue = a[column];
            const bValue = b[column];

            // Handle type name sorting in alphabetical order
            if (column === "name") {
                if (direction === "asc") {
                    return aValue.localeCompare(bValue); // Ascending alphabetical order
                } else {
                    return bValue.localeCompare(aValue); // Descending alphabetical order
                }
            }

            // Handle numeric sorting for other columns (like 'id')
            if (direction === "asc") {
                return aValue > bValue ? 1 : -1;
            } else {
                return aValue < bValue ? 1 : -1;
            }
        });
    }

    return typesToSort;
});

// Event Handlers for Type Modals
function handleTypeCreated(newType) {
    showCreateModal.value = false;
    // Optionally, add the new type to the list
    types.push(newType);
}

function handleTypeUpdated(updatedType) {
    showEditModal.value = false;
    // Update the type in the list
    const index = types.findIndex(type => type.id === updatedType.id);
    if (index !== -1) {
        types[index] = updatedType;
    }
}

function handleTypeDeleted(typeId) {
    showDeleteModal.value = false;
    // Remove the deleted type from the list
    const index = types.findIndex(type => type.id === typeId);
    if (index !== -1) {
        types.splice(index, 1);
    }
}
</script>

<template>
    <Head title="Mini-Pim | Types"/>
    <PIMLayout>
        <div class="types">
            <!-- Header -->
            <div class="types__header">
                <h1 class="types__title">Types</h1>
            </div>

            <!-- Section -->
            <div class="types__section">
                <div class="types__top-bar">
                    <!-- Create Button -->
                    <div class="types__create-button" v-if="props.canCreateType">
                        <PrimaryButton
                            label="Create New Type"
                            icon="fas fa-plus"
                            type="cancel"
                            @click="openModal('create', type)"
                        />
                    </div>

                    <!-- Search Bar -->
                    <div class="types__search-bar">
                        <Searchbar
                            id="search"
                            placeholder="Search..."
                            v-model="searchQuery"
                        />
                    </div>

                    <!-- Filter -->
                    <div class="types__filter">
                        <Filter/>
                    </div>
                </div>

                <!-- Table -->
                <table class="types__table">
                    <thead>
                    <tr class="types__table-header">
                        <th
                            class="types__table-header-cell"
                            @click="sortColumn('id')"
                        >
                            Type ID
                            <i :class="{
                                        'fas fa-sort-up': sortConfig.column === 'id' && sortConfig.direction === 'asc',
                                        'fas fa-sort-down': sortConfig.column === 'id' && sortConfig.direction === 'desc'}">
                            </i>
                        </th>
                        <th
                            class="types__table-header-cell"
                            @click="sortColumn('name')"
                        >
                            Name
                            <i :class="{
                                        'fas fa-sort-up': sortConfig.column === 'name' && sortConfig.direction === 'asc',
                                        'fas fa-sort-down': sortConfig.column === 'name' && sortConfig.direction === 'desc'}">
                            </i>
                        </th>
                        <th v-if="props.canEditType || props.canDeleteType" class="types__table-header-cell"></th>
                    </tr>
                    </thead>
                    <tbody class="types__table-body">
                    <tr v-for="type in sortedTypes" :key="type.id" class="types__table-row">
                        <td class="types__table-cell">{{ type.id }}</td>
                        <td class="types__table-cell">{{ type.name }}</td>
                        <td v-if="props.canEditType || props.canDeleteType" class="types__table-cell">
                            <div class="types__actions">
                                <SecondaryButton
                                    v-if="props.canEditType"
                                    label=""
                                    type="submit"
                                    icon="fas fa-edit"
                                    @click="openModal('edit', type)"
                                />
                                <SecondaryButton
                                    v-if="props.canDeleteType"
                                    label=""
                                    type="delete"
                                    icon="fas fa-trash"
                                    @click="openModal('delete', type)"
                                />
                            </div>
                        </td>
                    </tr>
                    </tbody>
                </table>

                <!-- Show message if no Types match the search -->
                <div v-if="filteredTypes.length === 0" class="types__no-results">
                    <p>No results found</p>
                </div>
            </div>

            <!-- Modals -->
            <TypeCreateModal
                :isOpen="showCreateModal"
                @close="closeModal('create')"
                @typeCreated="handleTypeCreated"
            />
            <TypeEditModal
                :isOpen="showEditModal"
                :type="typeToEdit"
                @close="closeModal('edit')"
                @typeUpdated="handleTypeUpdated"
            />
            <TypeDeleteModal
                :isOpen="showDeleteModal"
                :type="typeToDelete"
                @close="closeModal('delete')"
                @typeDeleted="handleTypeDeleted"
            />
        </div>
    </PIMLayout>
</template>
