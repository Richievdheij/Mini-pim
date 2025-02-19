<script setup>
import { defineProps, defineEmits } from 'vue';
import { useNotifications } from '@/plugins/notificationPlugin';
import { useForm } from '@inertiajs/vue3';
import SecondaryButton from '@/Components/General/SecondaryButton.vue';
import TertiaryButton from "@/Components/General/TertiaryButton.vue";

const { success, error } = useNotifications();

// Props and emits
const props = defineProps({
    type: Object,
    isOpen: Boolean,
});

const emit = defineEmits(['close']);

// Form handling
const form = useForm({
    name: '',
});

// Close modal function
function closeModal() {
    emit('close');
}

// Submit function to handle type deletion
function submit() {
    form.delete(route("pim.types.destroy", props.type.id), {
        onSuccess: () => {
            success(`Type "${form.name}" deleted successfully!`); // Success message
            closeModal();
        },
        onError: () => {
            error("Failed to delete type, there are attributes still linked to this type.");
        },
    });
}
</script>

<template>
    <div v-if="isOpen" class="delete-type-modal">
        <div class="delete-type-modal__overlay"></div>
        <div class="delete-type-modal__content">
            <h2 class="delete-type-modal__title">Delete Type</h2>
            <p class="delete-type-modal__description">
                Are you sure you want to delete the type <strong>"{{ props.type.name }}"?</strong>
            </p>
            <form @submit.prevent="submit" class="delete-type-modal__form">
                <div class="delete-type-modal__actions">
                    <!-- Cancel button -->
                    <TertiaryButton
                        label="Cancel"
                        type="cancel"
                        @click="closeModal"
                        :disabled="form.processing"
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
