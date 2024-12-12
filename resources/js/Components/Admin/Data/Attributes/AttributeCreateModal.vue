<script setup>
import { useForm } from "@inertiajs/vue3";
import { useNotifications } from "@/plugins/notificationPlugin";
import { defineEmits } from "vue";
import Input from "@/Components/General/Input.vue";
import SecondaryButton from "@/Components/General/SecondaryButton.vue";
import TertiaryButton from "@/Components/General/TertiaryButton.vue";

const emit = defineEmits(["close"]);
const { success, error } = useNotifications(); // Initialize notifications

// Props from the parent component
const props = defineProps({
    isOpen: Boolean, // Determines if the modal is open
    types: Array, // List of available types for the attribute
    attributes: Array, // List of available attributes
});

const form = useForm({
    name: "",
    type_id: "",
});

// Submit form
function submit() {
    form.post(route("pim.attributes.store"), {
        preserveScroll: true,
        onSuccess: () => {
            success(`Attribute "${form.name}" created successfully!`); // Success message
            closeModal(); // Close the modal
        },
        onError: () => {
            error("Error creating the attribute."); // Error message
        },
    });
}

// Close the modal
function closeModal() {
    emit("close");
    form.reset();
    form.clearErrors();
}

</script>

<template>
    <div v-if="isOpen" class="create-attribute-modal">
        <div class="create-attribute-modal__overlay"></div>
        <div class="create-attribute-modal__content">
            <h2 class="create-attribute-modal__title">Create Attribute</h2>
            <form @submit.prevent="submit" class="create-attribute-modal__form">
                <!-- Name input field -->
                <Input
                    label="Name"
                    id="name"
                    inputType="text"
                    placeholder="Enter the attribute name"
                    type="field"
                    v-model="form.name"
                    :error="form.errors.name"
                />

                <!-- Type select input field -->
                <Input
                    label="Type"
                    id="type"
                    type="selectType"
                    placeholder="Select Type"
                    v-model="form.type_id"
                    :types="types"
                    :error="form.errors.type_id"
                />

                <!-- Action buttons for the modal (Cancel and Save) -->
                <div class="create-attribute-modal__actions">
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
