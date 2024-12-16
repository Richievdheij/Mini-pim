<script setup>
import { useForm } from "@inertiajs/vue3";
import { watch, ref } from "vue";
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
const attributeValues = ref({}); // Attribute values for the product

// Initialize notifications system
const { success, error } = useNotifications();

// Initialize form with default values
const form = useForm({
    product_id: "",
    name: "",
    attributes: [],
    type_id: "",
    description: "",
});

// Watch for changes to the `isOpen` prop to reset form when modal opens
watch(
    () => props.isOpen,
    (isOpen) => {
        if (isOpen) {
            form.reset(); // Reset form fields
            form.clearErrors(); // Clear any existing form errors
            attributeValues.value = {}; // Clear attribute values
        }
    }
);

// Watch for changes in `type_id` and fetch the related attributes
watch(
    () => form.type_id,
    async (typeId) => {
        if (typeId) {
            try {
                const url = route("pim.types.attributes", { typeId });
                const response = await axios.get(url);
                form.attributes = response.data.attributes || [];
            } catch (error) {
                console.error("Failed to fetch attributes:", error);
                form.attributes = [];
                attributeValues.value = {};
            }
        } else {
            form.attributes = [];
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
        product_id: form.product_id,
        name: form.name,
        type_id: form.type_id,
        description: form.description,
        attributes: Object.entries(attributeValues.value).map(([id, value]) => ({
            id,
            value,
        })),
    };

    form.post(route("pim.products.store"), {
        data: payload,
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
                    inputType="text"
                    placeholder="Enter product description"
                    type="field"
                    v-model="form.description"
                    :error="form.errors.description"
                />

                <!-- Dynamic Attribute Fields -->
                <div class="create-product-modal__attributes">
                    <div
                        v-for="attribute in form.attributes"
                        :key="attribute.id"
                        class="create-product-modal__attribute"
                    >
                        <label :for="`attribute-${attribute.id}`">{{ attribute.name }}</label>
                        <input
                            v-if="attribute.type === 'text'"
                            class="create-product-modal__attribute-input"
                            type="text"
                            :id="`attribute-${attribute.id}`"
                            v-model="attributeValues.value[attribute.id]"
                            :placeholder="`Enter ${attribute.name}`"
                        />
                        <input
                            v-else-if="attribute.type === 'number'"
                            class="create-product-modal__attribute-input"
                            type="number"
                            :id="`attribute-${attribute.id}`"
                            v-model="attributeValues.value[attribute.id]"
                            :placeholder="`Enter ${attribute.name}`"
                        />
                        <!-- Add other input types as needed -->
                    </div>
                </div>
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
