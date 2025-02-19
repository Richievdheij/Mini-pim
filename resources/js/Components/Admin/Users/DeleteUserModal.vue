<script setup>
import { useForm } from '@inertiajs/vue3';
import { watch, defineProps, defineEmits } from 'vue';
import SecondaryButton from '@/Components/General/SecondaryButton.vue';
import TertiaryButton from "@/Components/General/TertiaryButton.vue";
import { useNotifications } from "@/plugins/notificationPlugin";

const { success, error } = useNotifications();

// Props and emits
const props = defineProps({
    user: Object,
    isOpen: Boolean,
});
const emit = defineEmits(['close']);

// Form setup
const form = useForm({
    password: '',
});

// Watch for when the modal is opened
watch(
    () => props.isOpen,
    (isOpen) => {
        if (isOpen) {
            form.password = '';
        }
    }
);

// Close modal function
function closeModal() {
    emit('close');
    form.reset();
    form.clearErrors();
}

// Submit function to handle user deletion
function submit() {
    form.delete(`/users/${props.user.id}`, {
        preserveScroll: true,
        onSuccess: () => {
            success(`User "${props.user.name}" deleted successfully!`);
            closeModal();
        },
        onError: () => {
            error("Failed to delete user. Please try again.");
        },
    });
}
</script>

<template>
    <div v-if="isOpen" class="delete-user-modal">
        <div class="delete-user-modal__overlay"></div>
        <div class="delete-user-modal__content">
            <h2 class="delete-user-modal__title">Delete User</h2>
            <p class="delete-user-modal__description">
                Are you sure you want to delete the user <strong>"{{ props.user.name }}"?</strong>
            </p>
            <form @submit.prevent="submit" class="delete-user-modal__form">
                <div class="delete-user-modal__actions">
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
