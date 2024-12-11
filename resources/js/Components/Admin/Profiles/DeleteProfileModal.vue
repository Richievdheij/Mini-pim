<script setup>
import { useForm } from '@inertiajs/vue3';
import { defineProps, defineEmits } from "vue";
import TertiaryButton from "@/Components/General/TertiaryButton.vue";
import SecondaryButton from "@/Components/General/SecondaryButton.vue";
import { useNotifications } from "@/plugins/notificationPlugin";

const { success, error } = useNotifications();

// Define the props the component will accept
const props = defineProps({
    isOpen: Boolean, // Indicates whether the modal is open
    profile: Object, // Profile data to be deleted
});

const emit = defineEmits(["close", "delete"]);

// Form setup
const form = useForm({
    // Empty, no data to be sent
});

function closeModal() {
    emit("close");
}

function submit() {
    // Send delete request
    form.delete(route("profiles.destroy", props.profile.id), {
        onSuccess: () => {
            success("Profile deleted successfully!"); // Success notification
            closeModal("delete");
        },
        onError: () => {
            error("Failed to delete profile, there are users still linked to this profile."); // Error notification
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
                Are you sure you want to delete the profile <strong>"{{ props.profile.name }}"?</strong>
            </p>
            <form @submit.prevent="submit" class="delete-profile-modal__actions">
                <!-- Cancel button to close the modal -->
                <TertiaryButton
                    label="Cancel"
                    type="cancel"
                    @click="closeModal"
                />
                <!-- Delete button to confirm the deletion -->
                <SecondaryButton
                    label="Delete"
                    type="delete"
                />
            </form>
        </div>
    </div>
</template>
