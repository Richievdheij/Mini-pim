<script setup>
import { useForm } from "@inertiajs/vue3";
import { watch } from "vue";
import { useNotifications } from "@/plugins/notificationPlugin";

const props = defineProps({
    product: Object,
    isOpen: Boolean,
});
const emit = defineEmits(["close", "productUpdated"]);

const { success, error } = useNotifications();

const form = useForm({
    product_id: props.product?.product_id || "",
    name: props.product?.name || "",
    type_id: props.product?.type_id || "",
    weight: props.product?.weight || "",
    description: props.product?.description || "",
    price: props.product?.price || "",
    stock_quantity: props.product?.stock_quantity || "",
});

watch(
    () => props.isOpen,
    (isOpen) => {
        if (isOpen && props.product) {
            form.fill(props.product);
        }
    }
);

function closeModal() {
    emit("close");
    form.reset();
    form.clearErrors();
}

function submit() {
    form.put(route("products.update", props.product.id), {
        onSuccess: ({ props }) => {
            success("Product updated successfully!");
            emit("productUpdated", props.flash.updatedProduct); // Emit the updated product
            closeModal();
        },
        onError: () => {
            error("Failed to update product. Please try again.");
        },
    });
}
</script>

<template>
    <div class="modal">
        <div class="modal-content">
            <h2>Edit Product</h2>
            <form @submit.prevent="submit">
                <!-- Zelfde velden als Create -->
            </form>
        </div>
    </div>
</template>
