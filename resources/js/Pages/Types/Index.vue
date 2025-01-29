<script setup>
import { ref, computed } from "vue";
import { Head, router, usePage } from "@inertiajs/vue3";
import TypeCreateModal from "@/Components/Admin/Data/Types/TypeCreateModal.vue";
import TypeEditModal from "@/Components/Admin/Data/Types/TypeEditModal.vue";
import TypeDeleteModal from "@/Components/Admin/Data/Types/TypeDeleteModal.vue";
import PIMLayout from "@/Layouts/PIMLayout.vue";
import TypesSection from '@/Pages/Types/TypesSection.vue';
import TypesTable from '@/Pages/Types/TypesTable.vue';

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
    const newDirection = direction === "asc" ? "desc" : direction === "desc" ? "none" : "asc";

    sortConfig.value = { column, direction: newDirection };
}

// Sorted types
const sortedTypes = computed(() => {
    const { column, direction } = sortConfig.value;
    let typesToSort = [...filteredTypes.value];

    if (column && direction !== "none") {
        typesToSort.sort((a, b) => {
            const aValue = a[column];
            const bValue = b[column];

            return direction === "asc" ? aValue > bValue ? 1 : -1 : aValue < bValue ? 1 : -1;
        });
    }

    return typesToSort;
});
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
            <TypesSection
                :canCreateType="props.canCreateType"
                v-model:searchQuery="searchQuery"
                :openModal="openModal"
            />

            <!-- Types Table -->
            <TypesTable
                :types="sortedTypes"
                :sortConfig="sortConfig"
                :canEditType="props.canEditType"
                :canDeleteType="props.canDeleteType"
                :sortColumn="sortColumn"
                :openModal="openModal"
            />

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
