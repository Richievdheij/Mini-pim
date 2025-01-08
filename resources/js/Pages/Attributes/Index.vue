<script setup>
import { ref, computed, watch } from 'vue';
import { Head, usePage } from '@inertiajs/vue3';
import PIMLayout from "@/Layouts/PIMLayout.vue";
import AttributeCreateModal from '@/Components/Admin/Data/Attributes/AttributeCreateModal.vue';
import AttributeEditModal from '@/Components/Admin/Data/Attributes/AttributeEditModal.vue';
import AttributeDeleteModal from "@/Components/Admin/Data/Attributes/AttributeDeleteModal.vue";
import SecondaryButton from "@/Components/General/SecondaryButton.vue";
import PrimaryButton from "@/Components/General/PrimaryButton.vue";
import Searchbar from "@/Components/General/Searchbar.vue";
import Filter from "@/Components/General/Filter.vue";

const props = defineProps({
    canCreateAttribute: Boolean,
    canEditAttribute: Boolean,
    canDeleteAttribute: Boolean,
});

// Modal visibility states
const showCreateModal = ref(false);
const showEditModal = ref(false);
const showDeleteModal = ref(false);
const attributeToEdit = ref(null);
const attributeToDelete = ref(null);
const searchQuery = ref("");

// Data from the server
const page = usePage();
const attributes = ref(page?.props?.attributes || []);
const types = ref(page?.props?.types || []);

// Sort configuration state
const sortConfig = ref({
    column: null,
    direction: "none", // 'none', 'asc', or 'desc'
});

// Open modal for create/edit/delete
function openModal(modalType, attribute = null) {
    attributeToEdit.value = attribute;
    attributeToDelete.value = attribute;

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
    attributeToEdit.value = null;
    attributeToDelete.value = null;

    if (modalType === "edit") {
        showEditModal.value = false;
    } else if (modalType === "delete") {
        showDeleteModal.value = false;
    } else if (modalType === "create") {
        showCreateModal.value = false;
    }
}

// Watch for changes in the search query to filter the attributes
watch(searchQuery, (newQuery) => {
    if (newQuery) {
        attributes.value = page?.props?.attributes.filter(attribute => // Filter attributes based on the search query
            attribute.name.toLowerCase().includes(newQuery.toLowerCase())
        ) || [];
    } else {
        attributes.value = page?.props?.attributes || []; // Reset the attributes to the original list
    }
});

// Sorting functionality
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

// Filtered attributes based on the search query
const filteredAttributes = computed(() => {
    return attributes.value.filter(attribute =>
        attribute.name.toLowerCase().includes(searchQuery.value.toLowerCase())
    );
});

// Sorting logic for both 'name' and 'type'
const sortedAttributes = computed(() => {
    const { column, direction } = sortConfig.value;
    let attributesToSort = [...filteredAttributes.value];

    // Sort the attributes based on the column and direction
    if (column && direction !== "none") {
        attributesToSort.sort((a, b) => {
            const aValue = column === 'type' ? a[column]?.name : a[column];
            const bValue = column === 'type' ? b[column]?.name : b[column];

            if (direction === "asc") {
                return aValue > bValue ? 1 : -1;
            } else {
                return aValue < bValue ? 1 : -1;
            }
        });
    }

    return attributesToSort;
});

</script>

<template>
    <Head title="Mini-Pim | Attributes"/>

    <PIMLayout>
        <div class="attributes">
            <!-- Header -->
            <div class="attributes__header">
                <h1 class="attributes__title">Attributes</h1>
            </div>

            <!-- Section -->
            <div class="attributes__section">
                <div class="attributes__top-bar">
                    <div class="attributes__create-button" v-if="props.canCreateAttribute">
                        <PrimaryButton
                            label="Create new Attribute"
                            type="cancel"
                            icon="fas fa-plus"
                            @click="openModal('create', null)"
                        />
                    </div>

                    <div class="attributes__search-bar">
                        <Searchbar
                            id="search"
                            placeholder="Search..."
                            v-model="searchQuery"
                        />
                    </div>

                    <div class="attributes__filter">
                        <Filter />
                    </div>
                </div>

                <!-- Attributes Table -->
                <table class="attributes__table">
                    <thead>
                    <tr class="attributes__table-header">
                        <th
                            class="attributes__table-header-cell"
                            @click="sortColumn('name')"
                        >
                            Name
                            <i :class="{
                                'fas fa-sort-up': sortConfig.column === 'name' && sortConfig.direction === 'asc',
                                'fas fa-sort-down': sortConfig.column === 'name' && sortConfig.direction === 'desc'}">
                            </i>
                        </th>
                        <th
                            class="attributes__table-header-cell"
                            @click="sortColumn('type')"
                        >
                            Type
                            <i :class="{
                                'fas fa-sort-up': sortConfig.column === 'type' && sortConfig.direction === 'asc',
                                'fas fa-sort-down': sortConfig.column === 'type' && sortConfig.direction === 'desc'}">
                            </i>
                        </th>
                        <th v-if="props.canEditAttribute || props.canDeleteAttribute"
                            class="attributes__table-header-cell"></th>
                    </tr>
                    </thead>
                    <tbody class="attributes__table-body">
                    <tr v-for="attribute in sortedAttributes" :key="attribute.id" class="attributes__table-row">
                        <td class="attributes__table-cell">{{ attribute.name }}</td>
                        <td class="attributes__table-cell">{{ attribute.type.name }}</td>
                        <td v-if="props.canEditAttribute || props.canDeleteAttribute" class="attributes__table-cell">
                            <!-- Actions -->
                            <div class="attributes__actions">
                                <SecondaryButton
                                    v-if="props.canEditAttribute"
                                    label=""
                                    type="submit"
                                    icon="fas fa-edit"
                                    @click="openModal('edit', attribute)"
                                />
                                <SecondaryButton
                                    v-if="props.canDeleteAttribute"
                                    label=""
                                    type="delete"
                                    icon="fas fa-trash"
                                    @click="openModal('delete', attribute)"
                                />
                            </div>
                        </td>
                    </tr>
                    </tbody>
                </table>

                <!-- Show message if no Attributes match the search -->
                <div v-if="filteredAttributes.length === 0" class="attributes__no-results">
                    <p>No results found</p>
                </div>
            </div>

            <!-- Modals -->
            <AttributeCreateModal
                :isOpen="showCreateModal"
                :types="types"
                @close="closeModal('create')"
            />
            <AttributeEditModal
                :isOpen="showEditModal"
                :attribute="attributeToEdit"
                :types="types"
                @close="closeModal('edit')"
            />
            <AttributeDeleteModal
                :isOpen="showDeleteModal"
                :attribute="attributeToDelete"
                @close="closeModal('delete')"
            />
        </div>
    </PIMLayout>
</template>
