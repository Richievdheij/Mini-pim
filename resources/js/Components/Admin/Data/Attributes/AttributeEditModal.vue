<script setup>
import { useForm } from '@inertiajs/vue3';
import { defineProps, defineEmits, watch } from 'vue';
import { useNotifications } from "@/plugins/notificationPlugin";
import Input from "@/Components/General/Input.vue";
import SecondaryButton from "@/Components/General/SecondaryButton.vue";
import TertiaryButton from "@/Components/General/TertiaryButton.vue";

const { success, error } = useNotifications(); // success and error notifications

// Define the props for the component
const props = defineProps({
    isOpen: Boolean,
    attribute: Object,
    types: Array,
});

// Function to close the modal
const emit = defineEmits(['close']);

// Form to handle the attribute data
const form = useForm({
    name: props.attribute?.name || '',
    type_id: props.attribute?.type_id || '',
});

// Watch for changes in the attribute prop to update the form
watch(() => props.attribute, (newAttribute) => {
    if (newAttribute) {
        form.name = newAttribute.name;
        form.type_id = newAttribute.type_id;
    }
});

// Function to close the modal
function closeModal() {
    emit('close');
    form.reset();
    form.clearErrors();
}

// Function to submit the form
function submit() {
    form.put(route('pim.attributes.update', props.attribute.id), {
        onSuccess: () => {
            success(`Attribute "${form.name}" updated successfully!`); // Success message
            closeModal()
        },
        onError: () => {
            error('Failed to update attribute. Please try again.');
        },
    });
}
</script>

<template>
    <div v-if="isOpen" class="edit-attribute-modal">
        <div class="edit-attribute-modal__overlay"></div>
        <div class="edit-attribute-modal__content">
            <h2 class="edit-attribute-modal__title">Edit Attribute "{{ props.attribute.name }}"</h2>
            <form @submit.prevent="submit" class="edit-attribute-modal__form">
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
                    id="type_id"
                    type="selectType"
                    placeholder="Select Type"
                    v-model="form.type_id"
                    :types="types"
                    :error="form.errors.type_id"
                />

                <!-- Action buttons for the modal (Cancel and Edit) -->
                <div class="edit-attribute-modal__actions">
                    <TertiaryButton
                        label="Cancel"
                        type="cancel"
                        @click="closeModal"
                    />
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
