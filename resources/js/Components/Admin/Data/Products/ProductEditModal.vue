<script setup>
import { watch } from "vue";
import { useNotifications } from "@/plugins/notificationPlugin";
import { useForm } from "@inertiajs/vue3";
import Input from "@/Components/General/Input.vue";
import ProductEditModalInfo from "@/Components/Admin/Data/Products/Edit/ProductEditModalInfo.vue";
import ProductEditModalTypes from "@/Components/Admin/Data/Products/Edit/ProductEditModalTypes.vue";
import SecondaryButton from "@/Components/General/SecondaryButton.vue";
import TertiaryButton from "@/Components/General/TertiaryButton.vue";

// Notification functions for success and error messages
const { success, error } = useNotifications();

/**
 * Define component props
 * @property {Boolean} isOpen - Determines if the modal is open
 * @property {Array} attributes - List of product attributes
 * @property {Array} types - List of product types
 * @property {Object} product - Product data
 */
const props = defineProps({
    isOpen: Boolean,
    attributes: Array,
    types: Array,
    product: Object,
});

// Emit events for closing the modal and updating the product
const emit = defineEmits(["close", "productUpdated"]);

// Initialize form with default values
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
    stock_quantity: "0",
    attribute_values: {},
});

// Watch for modal open state and set form values
watch(
    () => props.isOpen,
    (isOpen) => {
        if (isOpen && props.product) {
            form.product_id = props.product.product_id;
            form.name = props.product.name;
            form.description = props.product.description;
            form.type_id = props.product.type_id;
            form.weight = props.product.weight || "";
            form.height = props.product.height || "";
            form.width = props.product.width || "";
            form.depth = props.product.depth || "";
            form.price = props.product.price || "";
            form.stock_quantity = props.product.stock_quantity || "0";
            form.attribute_values = props.product.attribute_values || {};
        }
    }
);

// Close the modal and reset the form
function closeModal() {
    emit("close");
    form.reset();
    form.clearErrors();
}

// Submit the form data to update the product
function submit() {
    form.put(route("pim.products.update", props.product.id), {
        onSuccess: () => {
            closeModal();
            emit("productUpdated");
            success(`Product "${props.product.name}" updated successfully.`);
        },
        onError: () => {
            error(`Failed to update product "${props.product.name}". Please check the fields.`);
        },
    });
}
</script>

<template>
    <div v-if="isOpen" class="edit-product-modal">
        <div class="edit-product-modal__overlay"></div>
        <div class="edit-product-modal__content">
            <h2 class="edit-product-modal__title">Edit Product "{{ props.product.name }}"</h2>

            <!-- Product edit form -->
            <form @submit.prevent="submit" class="edit-product-modal__form">
                <div class="edit-product-modal__container">
                    <div class="edit-product-modal__general">
                        <h3 class="edit-product-modal__subtitle">General Information</h3>
                        <!-- Product ID input field -->
                        <Input
                            label="Product ID"
                            id="product_id"
                            inputType="text"
                            :placeholder="props.product.product_id"
                            type="field"
                            v-model="form.product_id"
                            :error="form.errors.product_id"
                            required
                        />
                        <!-- Name input field -->
                        <Input
                            label="Name"
                            id="name"
                            inputType="text"
                            :placeholder="props.product.name"
                            type="field"
                            v-model="form.name"
                            :error="form.errors.name"
                            required
                        />
                        <!-- Description input field -->
                        <Input
                            label="Description"
                            id="description"
                            inputType="textarea"
                            :placeholder="props.product.description"
                            type="description"
                            v-model="form.description"
                            :error="form.errors.description"
                        />
                    </div>

                    <!-- Additional product information -->
                    <div class="edit-product-modal__additional">
                        <h3 class="edit-product-modal__subtitle">Types</h3>
                        <ProductEditModalTypes
                            :types="types"
                            v-model:type-id="form.type_id"
                            v-model:attribute-values="form.attribute_values"
                            :attributes="attributes"
                            :errors="form.errors"
                        />
                    </div>

                    <!-- Additional product information -->
                    <div class="edit-product-modal__info">
                        <h3 class="edit-product-modal__subtitle">Additional Information</h3>
                        <ProductEditModalInfo
                            v-model:form="form"
                            :errors="form.errors"
                            :isOpen="isOpen"
                            :product="props.product"
                        />
                    </div>
                </div>

                <!-- Submit and Cancel Buttons -->
                <div class="edit-product-modal__actions">
                    <TertiaryButton
                        label="Cancel"
                        type="cancel"
                        @click="closeModal"
                        :disabled="form.processing"
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
