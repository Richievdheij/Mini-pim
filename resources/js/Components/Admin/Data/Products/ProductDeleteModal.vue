<script setup>
import { defineProps, defineEmits } from "vue";
import { useForm } from "@inertiajs/vue3";
import { useNotifications } from "@/plugins/notificationPlugin";

const props = defineProps({
    isOpen: Boolean,
    product: {
        type: Object,
        default: null,
    },
});

const emit = defineEmits(["close"]);

const { success, error } = useNotifications(); // Use toast notifications

const form = useForm({});

function closeModal() {
    emit("close");
}

function deleteProduct() {
    if (!props.product) return;

    form.delete(route("products.destroy", props.product.id), {
        onSuccess: () => {
            success("Product deleted successfully!");
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
                Are you sure you want to delete the product
                <strong>{{ product?.name }}</strong>?
            </p>
            <div class="delete-product-modal__actions">
                <button class="btn btn-secondary" @click="closeModal">Cancel</button>
                <button class="btn btn-danger" @click="deleteProduct">Delete</button>
            </div>
        </div>
    </div>
</template>

<style scoped>
.delete-product-modal {
    position: fixed;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    background: rgba(0, 0, 0, 0.5);
    display: flex;
    align-items: center;
    justify-content: center;
    z-index: 1000;
}

.delete-product-modal__content {
    background: white;
    padding: 1.5rem;
    border-radius: 8px;
    max-width: 400px;
    width: 100%;
    text-align: center;
}

.delete-product-modal__title {
    font-size: 1.5rem;
    margin-bottom: 1rem;
    color: #dc3545;
}

.delete-product-modal__message {
    font-size: 1rem;
    margin-bottom: 1.5rem;
}

.delete-product-modal__actions {
    display: flex;
    justify-content: space-between;
    gap: 1rem;
}

.btn {
    padding: 0.5rem 1rem;
    border-radius: 4px;
    border: none;
    cursor: pointer;
    font-size: 1rem;
}

.btn-secondary {
    background-color: #6c757d;
    color: white;
}

.btn-secondary:hover {
    background-color: #5a6268;
}

.btn-danger {
    background-color: #dc3545;
    color: white;
}

.btn-danger:hover {
    background-color: #c82333;
}
</style>
