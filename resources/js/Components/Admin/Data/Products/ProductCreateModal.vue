<script setup>
import { useForm } from "@inertiajs/vue3";
import { ref, watch } from "vue";
import axios from "axios";
import { useNotifications } from "@/plugins/notificationPlugin";
import Input from "@/Components/General/Input.vue";
import SecondaryButton from "@/Components/General/SecondaryButton.vue";
import TertiaryButton from "@/Components/General/TertiaryButton.vue";

// Define props and events for the modal
const props = defineProps({
    isOpen: Boolean, // Determines if the modal is open
    types: Array,
});
const emit = defineEmits(["close", "productCreated"]); // Emit events for closing and product creation

// Initialize notifications system
const { success, error } = useNotifications();

// Initialize form with default values
const form = useForm({
    product_id: "",
    name: "",
    type_id: "",
    attributes: [],
    weight: "",
    description: "",
    price: "",
    stock_quantity: "",
});

// Store values for dynamically fetched attributes
const attributeValues = ref([]);

// Watch for changes to `type_id` to fetch attributes when a product type is selected
watch(
    () => form.type_id,
    async (typeId) => {
        if (typeId) {
            try {
                const { data } = await axios.get(`/types/${typeId}/attributes`);
                form.attributes = data;
                attributeValues.value = data.reduce((acc, attr) => {
                    acc[attr.id] = ""; // Default value for attributes
                    return acc;
                }, {});
            } catch (err) {
                console.error("Failed to fetch attributes:", err);
                form.attributes = [];
                attributeValues.value = {};
            }
        } else {
            form.attributes = [];
            attributeValues.value = {};
        }
    }
);

// Watch for changes to `isOpen` prop to reset form when modal opens
watch(
    () => props.isOpen,
    (isOpen) => {
        if (isOpen) {
            form.reset(); // Reset form fields
            form.clearErrors(); // Clear any existing errors
            attributeValues.value = {}; // Clear attribute values
        }
    }
);

// Close the modal and reset the form
function closeModal() {
    emit("close"); // Emit the close event
    form.reset(); // Reset form fields
    form.clearErrors(); // Clear any existing errors
    attributeValues.value = {}; // Clear attribute values
}

// Handle form submission (post the form data)
function submit() {
    const payload = {
        ...form,
        attributeValues: attributeValues.value,
    };

    form.post(route("pim.products.store"), {
        data: payload,
        onSuccess: ({ props }) => {
            success("Product created successfully!"); // Notify success
            closeModal(); // Close modal on success
        },
        onError: () => {
            error("Failed to create product. Please try again."); // Notify failure
        },
    });
}
</script>

<template>
    <div v-if="isOpen" class="create-product-modal">
        <div class="create-product-modal__overlay"></div>
        <div class="create-product-modal__content">
            <h2 class="create-product-modal__title">Create Product</h2>
            <form @submit.prevent="submit" class="create-product-modal__form">
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

                <div class="create-product-modal__attributes">
                    <div
                        v-for="attribute in form.attributes"
                        :key="attribute.id"
                        class="create-product-modal__attribute"
                    >
                        <label :for="attribute.id">{{ attribute.name }}</label>
                        <input
                            v-if="attribute.type === 'text'"
                            class="create-product-modal__attribute-input"
                            type="text"
                            v-model="attributeValues[attribute.id]"
                        />
                    </div>
                </div>

                <div class="create-product-modal__actions">
                    <TertiaryButton
                        label="Cancel"
                        type="cancel"
                        @click="closeModal"
                    />
                    <SecondaryButton
                        label="Create"
                        type="submit"
                        :disabled="form.processing"
                    />
                </div>
            </form>
        </div>
    </div>
</template>
