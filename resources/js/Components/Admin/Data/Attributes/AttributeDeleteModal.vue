<script setup>
import { defineProps, defineEmits } from "vue";
import { useNotifications } from "@/plugins/notificationPlugin";
import { useForm } from '@inertiajs/vue3';
import SecondaryButton from "@/Components/General/SecondaryButton.vue";
import TertiaryButton from "@/Components/General/TertiaryButton.vue";

// Success and error functions from notifications plugin
const { success, error } = useNotifications();

// Emit the close event
const emit = defineEmits(["close"]);

// Props from the parent component
const props = defineProps({
    isOpen: Boolean,
    attribute: Object,
});

// Form for deleting the attribute
const form = useForm({
    name: "",
});

// Close the modal
function closeModal() {
    emit("close");
}

function submit() {
    form.delete(route("pim.attributes.destroy", props.attribute.id), {
        onSuccess: () => {
            success(`Type "${form.name}" deleted successfully!`); // Success message
            closeModal();
        },
        onError: () => {
            error("Failed to delete the attribute. Please try again.");
        },
    });
}
</script>

<template>
    <div v-if="isOpen" class="delete-attribute-modal">
        <div class="delete-attribute-modal__overlay"></div>
        <div class="delete-attribute-modal__content">
            <h2 class="delete-attribute-modal__title">Delete Attribute</h2>
            <p class="delete-attribute-modal__message">
                Are you sure you want to delete the attribute <strong>"{{ props.attribute.name }}"?</strong>
            </p>
            <form @submit.prevent="submit" class="delete-attribute-modal__form">
                <div class="delete-attribute-modal__actions">
                    <!-- Cancel button -->
                    <TertiaryButton
                        label="Cancel"
                        type="cancel"
                        @click="closeModal"
                    />
                    <!-- Delete button -->
                    <SecondaryButton
                        label="Delete"
                        type="delete"
                        :disabled="form.processing"
                    />
                </div>
            </form>
        </div>
    </div>
</template>
