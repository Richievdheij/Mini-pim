<script setup>
import { useForm } from '@inertiajs/vue3';
import { defineProps, defineEmits } from "vue";
import TertiaryButton from "@/Components/General/TertiaryButton.vue";
import SecondaryButton from "@/Components/General/SecondaryButton.vue";
import { useNotifications } from "@/plugins/notificationPlugin"; // Import notifications

const { success, error } = useNotifications(); // Use notifications


const props = defineProps({
    isOpen: Boolean,
    profile: Object,
});

const emit = defineEmits(["close", "delete"]);

// Form setup
const form = useForm({
    // Empty, no data to be sent
});

function closeModal() {
    emit("close");
}

function deleteProfile(profile) {
    // Send delete request
    form.delete(route("profiles.destroy", props.profile.id), {
        onSuccess: () => {
            success("Profile deleted successfully! 🎉"); // Success notification
            closeModal("delete");
        },
        onError: () => {
            error("Failed to delete profile. ❌"); // Error notification
        },
    });
}
</script>

<template>
    <div v-if="isOpen" class="delete-profile-modal">
        <div class="delete-profile-modal__overlay"></div>
        <div class="delete-profile-modal__content">
            <h2 class="delete-profile-modal__title">Delete Profile</h2>
            <p class="delete-profile-modal__description">
                Are you sure you want to delete the profile "{{ props.profile.name }}"?
            </p>
            <form @submit.prevent="deleteProfile" class="delete-profile-modal__actions">
                <TertiaryButton
                    label="Cancel"
                    type="cancel"
                    @click="closeModal"
                />
                <SecondaryButton
                    label="Delete"
                    type="delete"
                    @click="deleteProfile"
                />
            </form>
        </div>
    </div>
</template>
