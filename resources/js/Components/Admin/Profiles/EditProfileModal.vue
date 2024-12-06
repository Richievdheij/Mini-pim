<script setup>
import { useForm } from "@inertiajs/vue3";
import { watch } from "vue";
import { useNotifications } from "@/plugins/notificationPlugin";
import Input from "@/Components/General/Input.vue";
import SecondaryButton from "@/Components/General/SecondaryButton.vue";
import TertiaryButton from "@/Components/General/TertiaryButton.vue";

// Define props
const props = defineProps({
    profile: Object,
    isOpen: Boolean,
});

// Define emits for closing the modal
const emit = defineEmits(["close"]);

// Notifications
const { success, error } = useNotifications(); // Use notifications

// Initialize the form object with the current profile's name
const form = useForm({
    name: props.profile?.name || "",
});

// Watch for when the modal opens and reset form values accordingly
watch(
    () => props.isOpen,
    (isOpen) => {
        if (isOpen) {
            // When the modal is opened, set the form name to the profile's current name
            form.name = props.profile?.name || "";
            form.clearErrors();
        }
    }
);

// Function to close the modal and reset form state
function closeModal() {
    emit("close");
    form.reset();
    form.clearErrors();
}

// Function to handle the form submission (update the profile)
function submit() {
    form.put(route("profiles.update", props.profile.id), {
        preserveScroll: true,
        onSuccess: () => {
            success(`Profile "${form.name}" updated successfully!`); // Show success notification
            closeModal(); // Close modal after success
        },
        onError: () => {
            error("Failed to update profile. Please try again."); // Show error notification
        },
    });
}
</script>

<template>
    <div v-if="isOpen" class="edit-profile-modal">
        <div class="edit-profile-modal__overlay"></div>
        <div class="edit-profile-modal__content">
            <h2 class="edit-profile-modal__title">Edit Profile</h2>

            <!-- Form for editing the profile -->
            <form @submit.prevent="submit" class="edit-profile-modal__form">
                <!-- Name Input -->
                <Input
                    label="Name"
                    inputType="text"
                    placeholder="Edit profile name"
                    type="field"
                    v-model="form.name"
                    :error="form.errors.name"
                />

                <div class="edit-profile-modal__actions">
                    <!-- Cancel Button -->
                    <TertiaryButton
                        label="Cancel"
                        type="cancel"
                        @click="closeModal"
                    />
                    <!-- Update Button -->
                    <SecondaryButton
                        label="Update"
                        type="submit"
                        :disabled="form.processing"
                    />
                </div>
            </form>
        </div>
    </div>
</template>
