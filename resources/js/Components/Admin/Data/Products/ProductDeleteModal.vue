<script setup>
import { defineProps, defineEmits } from "vue";
import { useNotifications } from "@/plugins/notificationPlugin";
import { useForm } from "@inertiajs/vue3";
import SecondaryButton from "@/Components/General/SecondaryButton.vue";
import TertiaryButton from "@/Components/General/TertiaryButton.vue";

const { success, error } = useNotifications(); // Notification plugin

/**
* Define component props
* @property {Boolean} isOpen - Determines if the modal is open
* @property {Object} product - Product data
*/
const props = defineProps({
    isOpen: Boolean,
    product: Object,
});

// Emit event for closing the modal
const emit = defineEmits(["close"]);

// Reactive form state
const form = useForm({
    name: "",
});

/**
 * Close the modal
 */
function closeModal() {
    emit("close");
    form.reset();
    form.clearErrors();
}

// Submit function to handle product deletion
function submit() {
    form.delete(route("pim.products.destroy", props.product.id), {
        onSuccess: () => {
            success(`Product "${props.product.name}" deleted successfully!`);
            closeModal();
        },
        onError: () => {
            error(`Failed to delete the product "${props.product.name}". Please try again.`);
        },
    });
}
</script>

<template>
    <div v-if="isOpen" class="delete-product-modal">
        <div class="delete-product-modal__overlay"></div>
        <div class="delete-product-modal__content">
            <h2 class="delete-product-modal__title">Delete Product</h2>
            <p class="delete-product-modal__description">
                Are you sure you want to delete the product <strong>"{{ props.product.name }}"?</strong>
            </p>
            <form @submit.prevent="submit" class="delete-product-modal__form">
                <div class="delete-product-modal__actions">
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
