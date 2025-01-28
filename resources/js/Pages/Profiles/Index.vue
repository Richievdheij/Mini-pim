<script setup>
import { ref, computed } from "vue";
import { Head, router } from "@inertiajs/vue3";

import CreateProfileModal from "@/Components/Admin/Profiles/CreateProfileModal.vue";
import EditProfileModal from "@/Components/Admin/Profiles/EditProfileModal.vue";
import DeleteProfileModal from "@/Components/Admin/Profiles/DeleteProfileModal.vue";
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import PrimaryButton from "@/Components/General/PrimaryButton.vue";
import Filter from '@/Components/General/Filter.vue';
import SecondaryButton from "@/Components/General/SecondaryButton.vue";
import Searchbar from "@/Components/General/Searchbar.vue";

// Props definition
const props = defineProps({
    profiles: Array,
    canCreateProfile: Boolean,
    canEditProfile: Boolean,
    canDeleteProfile: Boolean,
});

// Modal visibility state
const isCreateModalOpen = ref(false);
const isEditModalOpen = ref(false);
const isDeleteModalOpen = ref(false);
const selectedProfile = ref(null);
const searchQuery = ref("");

// Sort configuration state
const sortConfig = ref({
    column: null,
    direction: 'none',  // 'none', 'asc', or 'desc'
});

// Function to open modals based on type
function openModal(modalType, profile = null) {
    selectedProfile.value = profile;

    switch (modalType) {
        case 'create':
            isCreateModalOpen.value = true;
            break;
        case 'edit':
            isEditModalOpen.value = true;
            break;
        case 'delete':
            isDeleteModalOpen.value = true;
            break;
    }
}

// Function to close modals based on type
function closeModal(modalType) {
    selectedProfile.value = null;

    switch (modalType) {
        case 'create':
            isCreateModalOpen.value = false;
            break;
        case 'edit':
            isEditModalOpen.value = false;
            break;
        case 'delete':
            isDeleteModalOpen.value = false;
            break;
    }

    // Reload profiles
    try {
        router.reload({only: ['profiles']});
        console.log("Profiles reloaded", props.profiles);
    } catch (error) {
        console.error("Error reloading profiles:", error);
    }
}

// Filter profiles based on search query
const filteredProfiles = computed(() => {
    return (props.profiles || []).filter((profile) =>
        profile.name.toLowerCase().includes(searchQuery.value.toLowerCase())
    );
});

// Function to sort columns
function sortColumn(column) {
    const {direction} = sortConfig.value;
    let newDirection = 'asc';

    if (direction === 'asc') {
        newDirection = 'desc';
    } else if (direction === 'desc') {
        newDirection = 'none';
    }

    sortConfig.value = {
        column,
        direction: newDirection, // 'none', 'asc', or 'desc'
    };
}

// Sorted profiles
const sortedProfiles = computed(() => {
    const {column, direction} = sortConfig.value;
    let profilesToSort = [...filteredProfiles.value];

    if (column && direction !== 'none') {
        profilesToSort.sort((a, b) => {
            const aValue = a[column];
            const bValue = b[column];

            return direction === "asc" ? aValue.localeCompare(bValue) : bValue.localeCompare(aValue);
        });
    }

    return profilesToSort;
});
</script>

<template>
    <Head title="Mini-Pim | Profiles"/>

    <AuthenticatedLayout>
        <div class="profiles">
            <!-- Header -->
            <div class="profiles__header">
                <h1 class="profiles__title">Profiles</h1>
            </div>

            <!-- Section -->
            <div class="profiles__section">
                <div class="profiles__top-bar">
                    <!-- Create Profiles Button -->
                    <div class="profiles__create-button" v-if="props.canCreateProfile">
                        <PrimaryButton
                            label="Create New Profile"
                            type="cancel"
                            icon="fas fa-plus"
                            @click="openModal('create')"
                        />
                    </div>

                    <!-- Search Bar -->
                    <div class="profiles__search-bar">
                        <Searchbar
                            id="search"
                            placeholder="Search..."
                            v-model="searchQuery"
                        />
                    </div>

                    <div class="profiles__filter">
                        <Filter/>
                    </div>
                </div>

                <!-- Table -->
                <table class="profiles__table">
                    <thead>
                    <tr class="profiles__table-header">
                        <th
                            class="profiles__table-header-cell"
                            @click="sortColumn('name')"
                        >
                            Name
                            <i :class="{'fas fa-sort-up': sortConfig.column === 'name' && sortConfig.direction === 'asc', 'fas fa-sort-down': sortConfig.column === 'name' && sortConfig.direction === 'desc'}"></i>
                        </th>
                        <th
                            v-if="props.canEditProfile || props.canDeleteProfile"
                            class="profiles__table-header-cell">
                        </th>
                    </tr>
                    </thead>
                    <tbody class="profiles__table-body">
                    <tr v-for="profile in sortedProfiles" :key="profile.id" class="profiles__table-row">
                        <td class="profiles__table-cell">{{ profile.name }}</td>
                        <td v-if="props.canEditProfile || props.canDeleteProfile" class="profiles__table-cell">
                            <div class="profiles__actions">
                                <SecondaryButton
                                    v-if="props.canEditProfile"
                                    type="submit"
                                    label=""
                                    icon="fas fa-edit"
                                    @click="openModal('edit', profile)"
                                />
                                <SecondaryButton
                                    v-if="props.canDeleteProfile"
                                    type="delete"
                                    label=""
                                    icon="fas fa-trash"
                                    @click="openModal('delete', profile)"
                                />
                            </div>
                        </td>
                    </tr>
                    </tbody>
                </table>

                <!-- Show message if no profiles match the search -->
                <div v-if="filteredProfiles.length === 0" class="profiles__no-results">
                    <p>No results found</p>
                </div>
            </div>

            <!-- Modals -->
            <CreateProfileModal
                :isOpen="isCreateModalOpen"
                @close="closeModal('create')"
            />
            <EditProfileModal
                :profile="selectedProfile"
                :isOpen="isEditModalOpen"
                @close="closeModal('edit')"
            />
            <DeleteProfileModal
                :profile="selectedProfile"
                :isOpen="isDeleteModalOpen"
                @close="closeModal('delete')"
            />
        </div>
    </AuthenticatedLayout>
</template>
