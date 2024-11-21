<script setup>
import { ref, computed } from "vue";
import { Head } from "@inertiajs/vue3";
import CreateProfileModal from "@/Components/Admin/Profiles/CreateProfileModal.vue";
import EditProfileModal from "@/Components/Admin/Profiles/EditProfileModal.vue";
import DeleteProfileModal from "@/Components/Admin/Profiles/DeleteProfileModal.vue";
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import PrimaryButton from "@/Components/General/PrimaryButton.vue";
import Input from "@/Components/General/Input.vue";

const props = defineProps({
    profiles: Array,
    canEditProfile: Boolean,
    canDeleteProfile: Boolean,
    canCreateProfile: Boolean,
});

const isEditModalOpen = ref(false);
const isDeleteModalOpen = ref(false);
const isCreateModalOpen = ref(false);
const selectedProfile = ref(null);
const searchQuery = ref("");

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

const filteredProfiles = computed(() =>
    (props.profiles || []).filter((profile) =>
        profile.name.toLowerCase().includes(searchQuery.value.toLowerCase())
    )
);
</script>

<template>
    <Head title="Mini-Pim | Profiles"/>

    <AuthenticatedLayout>
        <div class="profiles">
            <div class="profiles__header">
                <h1 class="profiles__title">Profiles</h1>
            </div>

            <div class="profiles__section">
                <div class="profiles__top-bar">
                    <div class="profiles__create-button" v-if="props.canCreateProfile">
                        <PrimaryButton
                            v-if="props.canCreateProfile"
                            label="Create New Profile"
                            type="cancel"
                            icon="fas fa-plus"
                            @click="openModal('create')"
                        />
                    </div>
                    <div class="profiles__search-bar">
                        <Input
                            type="search"
                            id="search"
                            placeholder="Search..."
                            v-model="searchQuery"
                            icon="fas fa-search"
                        />
                    </div>
                </div>

                <table class="profiles__table">
                    <thead>
                    <tr>
                        <th>Name</th>
                        <th v-if="props.canEditProfile || props.canDeleteProfile">Actions</th>
                    </tr>
                    </thead>
                    <tbody>
                    <tr v-for="profile in filteredProfiles" :key="profile.id">
                        <td>{{ profile.name }}</td>
                        <td>
                            <PrimaryButton
                                v-if="props.canEditProfile"
                                label="Edit"
                                type="submit"
                                icon="fas fa-edit"
                                @click="openModal('edit', profile)"
                            />
                            <PrimaryButton
                                v-if="props.canDeleteProfile"
                                label="Delete"
                                type="delete"
                                icon="fas fa-trash"
                                @click="openModal('delete', profile)"
                            />
                        </td>
                    </tr>
                    </tbody>
                </table>
            </div>

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
