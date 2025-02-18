<script setup>
import { watch, ref } from "vue";
import { useNotifications } from "@/plugins/notificationPlugin";
import { useForm } from "@inertiajs/vue3";
import Input from "@/Components/General/Input.vue";
import ProductEditModalInfo from "@/Components/Admin/Data/Products/Edit/ProductEditModalInfo.vue";
import ProductEditModalTypes from "@/Components/Admin/Data/Products/Edit/ProductEditModalTypes.vue";
import SecondaryButton from "@/Components/General/SecondaryButton.vue";
import TertiaryButton from "@/Components/General/TertiaryButton.vue";

// Import the useNotifications function
const { success, error } = useNotifications();

// Define the props and emits
const props = defineProps({
    isOpen: Boolean,
    attributes: Array,
    types: Array,
    product: Object,
    attributeValues: Object,
    productId: Number,
});

// Define the emits
const emit = defineEmits(["close", "productUpdated"]);

// Define the form and attributes
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
    attribute_values: {},
});

// Define the attributes and errors
const attributes = ref([]);
const errors = ref({});

// Watch the isOpen prop and set the form values
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

            attributes.value = props.attributes || [];
            form.attribute_values = props.product.attribute_values || {};
        }
    }
);

// Close the modal
function closeModal() {
    emit("close");
    form.reset();
    form.clearErrors();
    errors.value = {};
}

// Validate the form
function validateForm() {
    errors.value = {};
    attributes.value.forEach((attribute) => {
        if (!form.attribute_values[attribute.id]) {
            errors.value[`attributes.${attribute.id}`] = `${attribute.name} is required.`;
        }
    });

    // Check if there are any errors
    return Object.keys(errors.value).length === 0;
}

// Submit the form
function submit() {
    if (!validateForm()) {
        error("Please fill in all required fields.");
        return;
    }

    // Submit the form
    form.put(route("pim.products.update", props.product.id), {
        onSuccess: () => {
            closeModal();
            emit("productUpdated");
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
            <h2 class="edit-product-modal__title">Edit Product "{{ props.product.name }}"</h2>

            <form @submit.prevent="submit" class="edit-product-modal__form">
                <div class="edit-product-modal__container">
                    <div class="edit-product-modal__general">
                        <h3 class="edit-product-modal__subtitle">General Information</h3>
                        <!-- Product ID, Name, and Description Inputs -->
                        <Input
                            label="Product ID"
                            id="product_id"
                            inputType="text"
                            placeholder="Enter product ID"
                            type="field"
                            v-model="form.product_id"
                            :error="form.errors.product_id"
                            required
                        />
                        <!-- Product Name and Description Inputs -->
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
                        <Input
                            label="Description"
                            id="description"
                            inputType="textarea"
                            placeholder="Enter product description"
                            type="description"
                            v-model="form.description"
                            :error="form.errors.description"
                        />
                    </div>

                    <div class="edit-product-modal__additional">
                        <h3 class="edit-product-modal__subtitle">Types</h3>
                        <!-- Product Type and Attributes Inputs -->
                        <ProductEditModalTypes
                            :types="types"
                            v-model:type-id="form.type_id"
                            v-model:attribute-values="form.attribute_values"
                            :attributes="attributes"
                            :errors="errors"
                        />
                    </div>

                    <div class="edit-product-modal__info">
                        <h3 class="edit-product-modal__subtitle">Additional Information</h3>
                        <!-- Product Weight, Height, Width, Depth, Price, and Stock Quantity Inputs -->
                        <ProductEditModalInfo
                            v-model:form="form"
                        />
                    </div>
                </div>

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
