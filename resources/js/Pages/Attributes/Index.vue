<script setup>
import { ref, computed, watch } from 'vue';
import { Head, usePage, router } from '@inertiajs/vue3';
import PIMLayout from "@/Layouts/PIMLayout.vue";
import AttributeCreateModal from '@/Components/Admin/Data/Attributes/AttributeCreateModal.vue';
import AttributeEditModal from '@/Components/Admin/Data/Attributes/AttributeEditModal.vue';
import AttributeDeleteModal from "@/Components/Admin/Data/Attributes/AttributeDeleteModal.vue";
import AttributesSection from '@/Pages/Attributes/AttributesSection.vue';
import AttributesTable from '@/Pages/Attributes/AttributesTable.vue';

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

    switch (modalType) {
        case "create":
            showCreateModal.value = true;
            break;
        case "edit":
            showEditModal.value = true;
            break;
        case "delete":
            showDeleteModal.value = true;
            break;
    }
}

// Close modal for create/edit/delete
function closeModal(modalType) {
    attributeToEdit.value = null;
    attributeToDelete.value = null;

    switch (modalType) {
        case "create":
            showCreateModal.value = false;
            break;
        case "edit":
            showEditModal.value = false;
            break;
        case "delete":
            showDeleteModal.value = false;
            break;
    }
    // Reload attributes
    try {
        router.reload({ only: ["attributes"] });
    } catch (error) {
        console.error("Error reloading attributes:", error);
    }
}

// Watch for changes in the search query to filter the attributes
watch(searchQuery, (newQuery) => {
    if (newQuery) {
        attributes.value = page?.props?.attributes.filter(attribute =>
            attribute.name.toLowerCase().includes(newQuery.toLowerCase())
        ) || [];
    } else {
        attributes.value = page?.props?.attributes || []; // Reset the attributes to the original list
    }
});

// Filtered attributes based on the search query
const filteredAttributes = computed(() => {
    return attributes.value
        .filter(attribute =>
            attribute.name.toLowerCase().includes(searchQuery.value.toLowerCase())
        );
});

// Sorting function
function sortColumn(column) {
    const { direction } = sortConfig.value;
    const newDirection = direction === "asc" ? "desc" : direction === "desc" ? "none" : "asc";

    sortConfig.value = { column, direction: newDirection };
}

// Sorting logic for both 'name' and 'type'
const sortedAttributes = computed(() => {
    const { column, direction } = sortConfig.value;
    let attributesToSort = [...filteredAttributes.value];

    if (column && direction !== "none") {
        attributesToSort.sort((a, b) => {
            const aValue = column === 'type' ? a[column]?.name : a[column];
            const bValue = column === 'type' ? b[column]?.name : b[column];

            return direction === "asc" ? aValue.localeCompare(bValue) : bValue.localeCompare(aValue);
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
            <AttributesSection
                :canCreateAttribute="props.canCreateAttribute"
                v-model:searchQuery="searchQuery"
                :openModal="openModal"
            />

            <!-- Attributes Table -->
            <AttributesTable
                :attributes="sortedAttributes"
                :sortConfig="sortConfig"
                :canEditAttribute="props.canEditAttribute"
                :canDeleteAttribute="props.canDeleteAttribute"
                :sortColumn="sortColumn"
                :openModal="openModal"
            />

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
