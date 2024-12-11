<script setup>
import { useForm } from "@inertiajs/vue3";
import { watch } from "vue";
import { useNotifications } from "@/plugins/notificationPlugin";
import Input from "@/Components/General/Input.vue";
import SecondaryButton from "@/Components/General/SecondaryButton.vue";
import TertiaryButton from "@/Components/General/TertiaryButton.vue";

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
    form.put(route("pim.products.update", props.product.id), {
        onSuccess: ({props}) => {
            success("Product updated successfully!");
            emit("productUpdated", props.flash.updatedProduct); // Emit de bijgewerkte product
            closeModal();
        },
        onError: () => {
            error("Failed to update product. Please try again.");
        },
    });
}
</script>

<template>
    <div v-if="isOpen" class="edit-product-modal">
        <div class="edit-product-modal__overlay"></div>
        <div class="edit-product-modal__content">
            <h2 class="edit-product-modal__title">Edit Product</h2>
            <form @submit.prevent="submit" class="edit-product-modal__form">
                <!-- Product ID input field -->
                <Input
                    label="Product ID"
                    id="product_id"
                    inputType="text"
                    placeholder="Enter product ID"
                    type="field"
                    v-model="form.product_id"
                    :error="form.errors.product_id"
                />
                <!-- Name input field -->
                <Input
                    label="Name"
                    id="name"
                    inputType="text"
                    placeholder="Enter product name"
                    type="field"
                    v-model="form.name"
                    :error="form.errors.name"
                />
                <!-- Type input field (Select Type) -->
                <Input
                    label="Type"
                    id="type_id"
                    type="select"
                    inputType="select"
                    placeholder="Select product type"
                    v-model="form.type_id"
                    :options="types"
                    :error="form.errors.type_id"
                />

                <!-- Weight input field -->
                <Input
                    label="Weight"
                    id="weight"
                    inputType="number"
                    placeholder="Enter product weight"
                    type="field"
                    v-model="form.weight"
                    :error="form.errors.weight"
                />

                <!-- Description input field -->
                <Input
                    label="Description"
                    id="description"
                    inputType="text"
                    placeholder="Enter product description"
                    type="field"
                    v-model="form.description"
                    :error="form.errors.description"
                />

                <!-- Price input field -->
                <Input
                    label="Price"
                    id="price"
                    inputType="number"
                    placeholder="Enter product price"
                    type="field"
                    v-model="form.price"
                    :error="form.errors.price"
                />

                <!-- Stock Quantity input field -->
                <Input
                    label="Stock Quantity"
                    id="stock_quantity"
                    inputType="number"
                    placeholder="Enter stock quantity"
                    type="field"
                    v-model="form.stock_quantity"
                    :error="form.errors.stock_quantity"
                />

                <div class="edit-product-modal__actions">
                    <TertiaryButton
                        label="Cancel"
                        type="cancel"
                        @click="closeModal"
                    />
                    <SecondaryButton
                        label="Save"
                        type="submit"
                        :disabled="form.processing"
                    />
                </div>
            </form>
        </div>
    </div>
</template>
