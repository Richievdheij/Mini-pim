<script setup>
import { useForm } from "@inertiajs/vue3";
import { watch } from "vue";
import { useNotifications } from "@/plugins/notificationPlugin";
import Input from "@/Components/General/Input.vue";
import SecondaryButton from "@/Components/General/SecondaryButton.vue";
import TertiaryButton from "@/Components/General/TertiaryButton.vue";

// Define props and events for the modal
const props = defineProps({
    isOpen: Boolean, // Determines if the modal is open
});
const emit = defineEmits(["close"]); // Emit event to close the modal

// Initialize notifications system
const { success, error } = useNotifications();

// Set up form with a default field value
const form = useForm({
    name: "",
});

// Watch for changes to the `isOpen` prop to reset form when modal opens
watch(
    () => props.isOpen,
    (isOpen) => {
        if (isOpen) {
            form.reset(); // Reset form fields
            form.clearErrors(); // Clear any existing form errors
        }
    }
);

// Close the modal and reset the form
function closeModal() {
    emit("close"); // Emit the close event
    form.reset(); // Reset form fields
    form.clearErrors(); // Clear any existing errors
}

// Handle form submission (post the form data)
function submit() {
    form.post(route("profiles.store"), {
        onSuccess: () => {
            success(`Profile "${form.name}" created successfully!`); // Success message
            closeModal(); // Close modal on success
        },
        onError: () => {
            error("Failed to create profile."); // Notify failure
        },
    });
}
</script>

<template>
    <div v-if="isOpen" class="create-profile-modal">
        <div class="create-profile-modal__overlay"></div>
        <div class="create-profile-modal__content">
            <h2 class="create-profile-modal__title">Create Profile</h2>
            <form @submit.prevent="submit" class="create-profile-modal__form">
                <!-- Name input field -->
                <Input
                    label="Name"
                    id="name"
                    inputType="text"
                    placeholder="Enter profile name"
                    type="field"
                    v-model="form.name"
                    :error="form.errors.name"
                />
                <!-- Modal action buttons (Cancel and Submit) -->
                <div class="create-profile-modal__actions">
                    <TertiaryButton
                        label="Cancel"
                        type="cancel"
                        @click="closeModal"
                    />
                    <SecondaryButton
                        label="Create"
                        type="submit"
                        :disabled="form.processing"
                    />
                </div>
            </form>
        </div>
    </div>
</template>
