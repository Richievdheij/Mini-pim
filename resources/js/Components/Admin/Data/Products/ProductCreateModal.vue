<script setup>
import { useForm } from "@inertiajs/vue3";
import { watch } from "vue";
import { useNotifications } from "@/plugins/notificationPlugin";
import Input from "@/Components/General/Input.vue";
import SecondaryButton from "@/Components/General/SecondaryButton.vue";
import TertiaryButton from "@/Components/General/TertiaryButton.vue";

// Define props and events for the modal
const props = defineProps({
    isOpen: Boolean, // Determines if the modal is open
    types: Array, // List of product types
});
const emit = defineEmits(["close", "productCreated"]); // Emit events for closing and product creation

// Initialize notifications system
const { success, error } = useNotifications();

// Initialize form with default values
const form = useForm({
    product_id: "",
    name: "",
    type_id: "",
    description: "",
});

// Watch for changes to the `isOpen` prop to reset form and generate Product ID when modal opens
watch(
    () => props.isOpen,
    (isOpen) => {
        if (isOpen) {
            form.reset(); // Reset form fields
            form.clearErrors(); // Clear any existing form errors
        }
    }
);

// Close the modal and reset the form
function closeModal() {
    emit("close"); // Emit the close event
    form.reset(); // Reset form fields
    form.clearErrors(); // Clear any existing errors
}

// Handle form submission (post the form data)
function submit() {
    form.post(route("pim.products.store"), {
        onSuccess: () => {
            success(`Product "${form.name}" created successfully!`); // Success message
            closeModal(); // Close the modal
        },
        onError: () => {
            error("Failed to create product. Please try again."); // Error message
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
                    readonly
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
                <!-- Type select input field -->
                <Input
                    label="Type"
                    id="type_id"
                    type="selectType"
                    v-model="form.type_id"
                    optionValue="id"
                    optionLabel="name"
                    :types="types"
                    :error="form.errors.type_id"
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

                <!-- Submit and Cancel Buttons -->
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
