<script setup>
import { ref, computed } from "vue";
import { Head, router } from "@inertiajs/vue3";
import CreateProfileModal from "@/Components/Admin/Profiles/CreateProfileModal.vue";
import EditProfileModal from "@/Components/Admin/Profiles/EditProfileModal.vue";
import DeleteProfileModal from "@/Components/Admin/Profiles/DeleteProfileModal.vue";
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import ProfilesSection from '@/Pages/Profiles/ProfilesSection.vue';
import ProfilesTable from '@/Pages/Profiles/ProfilesTable.vue';

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

// Sorting function
function sortColumn(column) {
    const { direction } = sortConfig.value;
    const newDirection = direction === "asc" ? "desc" : direction === "desc" ? "none" : "asc";

    sortConfig.value = { column, direction: newDirection };
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
            <ProfilesSection
                :canCreateProfile="props.canCreateProfile"
                v-model:searchQuery="searchQuery"
                :openModal="openModal"
            />

            <!-- Profiles Table -->
            <ProfilesTable
                :profiles="sortedProfiles"
                :sortConfig="sortConfig"
                :canEditProfile="props.canEditProfile"
                :canDeleteProfile="props.canDeleteProfile"
                :sortColumn="sortColumn"
                :openModal="openModal"
            />

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
