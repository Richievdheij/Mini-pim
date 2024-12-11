<script setup>
import { defineProps, defineEmits } from 'vue';
import SecondaryButton from '@/Components/General/SecondaryButton.vue';
import TertiaryButton from "@/Components/General/TertiaryButton.vue";
import { useNotifications } from "@/plugins/notificationPlugin";

const { success, error } = useNotifications();

// Props and emits
const props = defineProps({
    type: Object,
    isOpen: Boolean,
});
const emit = defineEmits(['close']);


// Close modal function
function closeModal() {
    emit('close');
    form.reset();
    form.clearErrors();
}

// Submit function to handle type deletion
function submit() {
    form.delete(`/types/${props.type.id}`, {
        preserveScroll: true,
        onSuccess: () => {
            success(`Type ${props.type.name} deleted successfully!`);
            closeModal();
        },
        onError: () => {
            error("Failed to delete type. Please try again.");
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
                    />
                    <!-- Delete button -->
                    <SecondaryButton
                        label="Delete"
                        type="delete"
                    />
                </div>
            </form>
        </div>
    </div>
</template>
