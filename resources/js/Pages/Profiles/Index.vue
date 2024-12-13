<script setup>
import { ref, computed } from "vue";
import { Head } from "@inertiajs/vue3";
import { useNotifications } from "@/plugins/notificationPlugin";
import CreateProfileModal from "@/Components/Admin/Profiles/CreateProfileModal.vue";
import EditProfileModal from "@/Components/Admin/Profiles/EditProfileModal.vue";
import DeleteProfileModal from "@/Components/Admin/Profiles/DeleteProfileModal.vue";
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import PrimaryButton from "@/Components/General/PrimaryButton.vue";
import Filter from '@/Components/General/Filter.vue';
import SecondaryButton from "@/Components/General/SecondaryButton.vue";
import Searchbar from "@/Components/General/Searchbar.vue";

const props = defineProps({
    profiles: Array,
    canEditProfile: Boolean,
    canDeleteProfile: Boolean,
    canCreateProfile: Boolean,
});

const { success, error } = useNotifications(); // Use notifications

const isEditModalOpen = ref(false);
const isDeleteModalOpen = ref(false);
const isCreateModalOpen = ref(false);
const selectedProfile = ref(null);
const searchQuery = ref("");

// Sort configuration state
const sortConfig = ref({
    column: null,
    direction: 'none',  // 'none', 'asc', or 'desc'
});

// Open modal for create/edit/delete
function openModal(modalType, profile = null) {
    selectedProfile.value = profile;

    if (modalType === "edit") {
        isEditModalOpen.value = true;
    } else if (modalType === "delete") {
        isDeleteModalOpen.value = true;
    } else if (modalType === "create") {
        isCreateModalOpen.value = true;
    }
}

// Close modal for create/edit/delete
function closeModal(modalType) {
    selectedProfile.value = null;

    if (modalType === "edit") {
        isEditModalOpen.value = false;
    } else if (modalType === "delete") {
        isDeleteModalOpen.value = false;
    } else if (modalType === "create") {
        isCreateModalOpen.value = false;
    }
}

// Filter profiles based on search query
const filteredProfiles = computed(() => {
    return (props.profiles || []).filter((profile) =>
        profile.name.toLowerCase().includes(searchQuery.value.toLowerCase())
    );
});

// Sorting function
function sortColumn(column) {
    const { direction } = sortConfig.value;
    let newDirection = 'asc';

    if (direction === 'asc') {
        newDirection = 'desc';
    } else if (direction === 'desc') {
        newDirection = 'none';
    }

    sortConfig.value = {
        column,
        direction: newDirection,
    };
}

// Sorted profiles
const sortedProfiles = computed(() => {
    const { column, direction } = sortConfig.value;
    let profilesToSort = [...filteredProfiles.value];

    if (column && direction !== 'none') {
        profilesToSort.sort((a, b) => {
            const aValue = a[column];
            const bValue = b[column];

            if (direction === 'asc') {
                return aValue > bValue ? 1 : -1;
            } else {
                return aValue < bValue ? 1 : -1;
            }
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
                        <Filter />
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
