<script setup>
import { ref, computed } from "vue";
import { Head, router, usePage } from "@inertiajs/vue3";
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

const isCreateModalOpen = ref(false);
const isEditModalOpen = ref(false);
const isDeleteModalOpen = ref(false);
const selectedType = ref(null);
const searchQuery = ref("");

// Sort configuration state
const sortConfig = ref({
    column: null,
    direction: "none", // 'none', 'asc', or 'desc'
});

// Open modal function
function openModal(modalType, type = null) {
    selectedType.value = type;

    switch (modalType) {
        case "create":
            isCreateModalOpen.value = true;
            break;
        case "edit":
            isEditModalOpen.value = true;
            break;
        case "delete":
            isDeleteModalOpen.value = true;
            break;
    }
}

// Close modal function
function closeModal(modalType) {
    selectedType.value = null;

    switch (modalType) {
        case "create":
            isCreateModalOpen.value = false;
            break;
        case "edit":
            isEditModalOpen.value = false;
            break;
        case "delete":
            isDeleteModalOpen.value = false;
            break;
    }

    // Reload types
    try {
        router.reload({ only: ["types"] });
        console.log("Types reloaded", types);
    } catch (error) {
        console.error("Error reloading types:", error);
    }
}

// Filter types based on search query
const filteredTypes = computed(() => {
    return types.filter((type) =>
        type.name.toLowerCase().includes(searchQuery.value.toLowerCase())
    );
});

// Sorting function
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

// Sorted types
const sortedTypes = computed(() => {
    const { column, direction } = sortConfig.value;
    let typesToSort = [...filteredTypes.value];

    if (column && direction !== "none") {
        typesToSort.sort((a, b) => {
            const aValue = a[column];
            const bValue = b[column];

            if (direction === "asc") {
                return aValue > bValue ? 1 : -1;
            } else {
                return aValue < bValue ? 1 : -1;
            }
        });
    }

    return typesToSort;
});
</script>

<template>
    <Head title="Mini-Pim | Types" />

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
                            @click="openModal('create')"
                        />
                    </div>

                    <!-- Search Bar -->
                    <div class="types__search-bar">
                        <Searchbar id="search" placeholder="Search..." v-model="searchQuery" />
                    </div>

                    <!-- Filter -->
                    <div class="types__filter">
                        <Filter />
                    </div>
                </div>

                <!-- Table -->
                <table class="types__table">
                    <thead>
                    <tr class="types__table-header">
                        <th class="types__table-header-cell" @click="sortColumn('id')">
                            Type ID
                            <i
                                :class="{
                                        'fas fa-sort-up': sortConfig.column === 'id' && sortConfig.direction === 'asc',
                                        'fas fa-sort-down': sortConfig.column === 'id' && sortConfig.direction === 'desc',
                                    }"
                            ></i>
                        </th>
                        <th class="types__table-header-cell" @click="sortColumn('name')">
                            Name
                            <i
                                :class="{
                                        'fas fa-sort-up': sortConfig.column === 'name' && sortConfig.direction === 'asc',
                                        'fas fa-sort-down': sortConfig.column === 'name' && sortConfig.direction === 'desc',
                                    }"
                            ></i>
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

                <!-- No results message -->
                <div v-if="filteredTypes.length === 0" class="types__no-results">
                    <p>No results found</p>
                </div>
            </div>

            <!-- Modals -->
            <TypeCreateModal
                :isOpen="isCreateModalOpen"
                @close="closeModal('create')"
            />
            <TypeEditModal
                :type="selectedType"
                :isOpen="isEditModalOpen"
                @close="closeModal('edit')"
            />
            <TypeDeleteModal
                :type="selectedType"
                :isOpen="isDeleteModalOpen"
                @close="closeModal('delete')"
            />
        </div>
    </PIMLayout>
</template>
