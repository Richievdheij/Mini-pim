<script setup>
import { watch, ref } from "vue";
import { useNotifications } from "@/plugins/notificationPlugin";
import { useForm } from "@inertiajs/vue3";
import Input from "@/Components/General/Input.vue";
import ProductEditModalInfo from "@/Components/Admin/Data/Products/Edit/ProductEditModalInfo.vue";
import ProductEditModalTypes from "@/Components/Admin/Data/Products/Edit/ProductEditModalTypes.vue";
import SecondaryButton from "@/Components/General/SecondaryButton.vue";
import TertiaryButton from "@/Components/General/TertiaryButton.vue";

const { success, error } = useNotifications(); // Notification plugin

// Props and emits
const props = defineProps({
    isOpen: Boolean,
    attributes: Array,
    types: Array,
    product: Object,
    attributeValues: Object,
    productId: Number,
});

const emit = defineEmits(["close", "productUpdated"]); // Emit events

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
    attributes: {},
});

// Attributes and validation
const attributes = ref([]);
const attributeValues = ref({});
const errors = ref({});

// Watch for modal open state
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

            // Set attributes and attribute values
            attributes.value = props.attributes || []; // Set attributes
            attributeValues.value = attributes.value.reduce((acc, attr) => { // Set attribute values
                acc[attr.id] = props.product?.attributes?.find((a) => a.id === attr.id)?.value || ""; // Set attribute value if exists
                return acc; // Starts with empty object, if attribute value exists, add it to the object
            }, {});
        }
    }
);

// Close modal handler
function closeModal() {
    emit("close");
    form.reset();
    form.clearErrors();
    attributeValues.value = {};
    errors.value = {};
}

// Submit form data
function submit() {
    // Validate attributes
    errors.value = {}; // Clear previous errors
    attributes.value.forEach((attribute) => {
        if (!attributeValues.value[attribute.id]) {
            errors.value[attribute.id] = `${attribute.name} is required.`;
        }
    });

    // Check if there are any errors
    if (Object.keys(errors.value).length > 0) {
        error("Please fill in all required fields.");
        return;
    }

    // Submit the form data to the correct table, ensuring attributes are linked with product_id
    form.put(route("pim.products.update", props.product.id), {
        onSuccess: () => {
            closeModal();
            success("Product updated successfully.");
        },
        onError: () => {
            error("Failed to update product. Please try again.");
        },
        data: {
            ...form, // Include all form data
            attributes: Object.entries(attributeValues.value).map(([attribute_id, value]) => ({
                attribute_id,
                value,
                product_id: props.product.id,  // Include the product_id to correctly associate the attributes
            })),
        },
    });
}

</script>

<template>
    <div v-if="isOpen" class="edit-product-modal">
        <div class="edit-product-modal__overlay"></div>
        <div class="edit-product-modal__content">
            <h2 class="edit-product-modal__title">Edit Product "{{ props.product.name }}" </h2>

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

                        <!-- Description input field -->
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
                        <!-- Component for product types -->
                        <ProductEditModalTypes
                            :types="types"
                            v-model="form.type_id"
                            :attributes="attributes"
                            :attributeValues="attributeValues"
                            :errors="form.errors"
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
