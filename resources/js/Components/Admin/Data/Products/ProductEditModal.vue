<script setup>
import { watch } from "vue";
import { useForm } from "@inertiajs/vue3";
import { useNotifications } from "@/plugins/notificationPlugin";
import Input from "@/Components/General/Input.vue";
import ProductEditModalInfo from "@/Components/Admin/Data/Products/Edit/ProductEditModalInfo.vue";
import ProductEditModalTypes from "@/Components/Admin/Data/Products/Edit/ProductEditModalTypes.vue";
import SecondaryButton from "@/Components/General/SecondaryButton.vue";
import TertiaryButton from "@/Components/General/TertiaryButton.vue";

const { success, error } = useNotifications();

const props = defineProps({
    attributes: Array, // List of product attributes
    product: Object, // The selected product to edit
    isOpen: Boolean, // Whether the modal is open or not
    types: Array, // List of product types
});

const emit = defineEmits(["close", "productUpdated"]);

// Reactive form state
const form = useForm({
    product_id: "",
    name: "",
    description: "",
    type_id: "",
    weight: "",
    height: "",
    width: "",
    depth: "",
    price: "",
    stock_quantity: "",
});

// Watch for modal open state and reset form if necessary
watch(
    () => props.isOpen,
    (isOpen) => {
        if (isOpen && props.product) {
            form.product_id = props.product.product_id;
            form.name = props.product.name;
            form.description = props.product.description;
            form.type_id = props.product.type_id;
            form.weight = props.product.weight;
            form.height = props.product.height;
            form.width = props.product.width;
            form.depth = props.product.depth;
            form.price = props.product.price;
            form.stock_quantity = props.product.stock_quantity;
        }
    }
);

// Close modal handler
function closeModal() {
    emit("close");
    form.reset();
    form.clearErrors();
    attributes.value = [];
    attributeValues.value = {};
}

// Submit form data
function submit() {
    form.put(route("pim.products.update", props.product.id), {
        onSuccess: () => {
            closeModal();
            success("Product updated successfully.");
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
                <div class="edit-product-modal__container">
                    <div class="edit-product-modal__general">
                        <h3 class="edit-product-modal__subtitle">General Information</h3>
                        <!-- Product ID -->
                        <Input
                            label="Product ID"
                            id="product_id"
                            inputType="text"
                            placeholder="Enter product ID"
                            type="field"
                            v-model="form.product_id"
                            :error="form.errors.product_id"
                            class="product-id-input input"
                            :disabled="true"
                            required
                        />

                        <!-- Name -->
                        <Input
                            label="Name"
                            id="name"
                            inputType="text"
                            placeholder="Enter product name"
                            type="field"
                            v-model="form.name"
                            :error="form.errors.name"
                            required
                        />

                        <!-- Description -->
                        <Input
                            label="Description"
                            id="description"
                            inputType="text"
                            placeholder="Enter product description"
                            type="field"
                            v-model="form.description"
                            :error="form.errors.description"
                        />
                    </div>

                    <div class="edit-product-modal__additional">
                        <h3 class="edit-product-modal__subtitle">Types</h3>
                        <!-- Component for product types -->
                        <ProductEditModalTypes
                            :types="types"
                            v-model="form.type_id"
                            :product="product"
                        />
                    </div>

                    <div class="edit-product-modal__info">
                        <h3 class="edit-product-modal__subtitle">Additional Information</h3>
                        <!-- Component for product info -->
                        <ProductEditModalInfo
                            v-model="form"
                        />
                    </div>
                </div>

                <!-- Actions -->
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
