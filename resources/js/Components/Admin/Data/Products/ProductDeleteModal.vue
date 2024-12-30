<script setup>
import { defineProps, defineEmits } from "vue";
import { useForm } from "@inertiajs/inertia-vue3";
import { useNotifications } from "@/plugins/notificationPlugin";
import SecondaryButton from "@/Components/General/SecondaryButton.vue";
import TertiaryButton from "@/Components/General/TertiaryButton.vue";

const props = defineProps({
    isOpen: Boolean,
    product: Object,
});

const emit = defineEmits(["close"]);

const { success, error } = useNotifications();

const form = useForm({
    name: "",
});

function closeModal() {
    emit("close");
}

// Submit function to handle product deletion
function submit() {
    form.delete(route("pim.products.destroy", props.product.id), {
        onSuccess: () => {
            success(`Product "${props.product.name}" deleted successfully!`);
            closeModal();
        },
        onError: () => {
            error("Failed to delete the product. Please try again.");
        },
    });
}
</script>

<template>
    <div v-if="isOpen" class="delete-product-modal">
        <div class="delete-product-modal__overlay"></div>
        <div class="delete-product-modal__content">
            <h2 class="delete-product-modal__title">Delete Product</h2>
            <p class="delete-product-modal__message">
                Are you sure you want to delete the product <strong>"{{ props.product.name }}"?</strong>
            </p>
            <form @submit.prevent="submit" class="delete-product-modal__form">
                <div class="delete-product-modal__actions">
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
