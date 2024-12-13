<script setup>
import { useForm } from "@inertiajs/vue3";
import { ref, watch } from "vue";
import { useNotifications } from "@/plugins/notificationPlugin";
import Input from "@/Components/General/Input.vue";
import SecondaryButton from "@/Components/General/SecondaryButton.vue";
import TertiaryButton from "@/Components/General/TertiaryButton.vue";

const props = defineProps({
    isOpen: Boolean, // Determines if the modal is open
    types: Array, // List of product types
});
const emit = defineEmits(["close", "productCreated"]);

const { success, error } = useNotifications();

// Initialize the form fields and state
const form = useForm({
    product_id: "",
    name: "",
    type_id: "",
    attributes: [], // Attributes fetched from the backend
    weight: "",
    description: "",
    price: "",
    stock_quantity: "",
});

// Stores values for the dynamically generated attribute fields
const attributeValues = ref({});

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
            }
        } else {
            form.attributes = [];
        }
    }
);



// Reset the form and attributes when the modal is opened or closed
watch(
    () => props.isOpen,
    (isOpen) => {
        if (isOpen) {
            form.reset();
            form.clearErrors();
            attributeValues.value = {};
        }
    }
);

// Close the modal and reset form values
function closeModal() {
    emit("close");
    form.reset();
    form.clearErrors();
    attributeValues.value = {};
}

// Submit the form, including dynamic attributes, to the backend
function submit() {
    const payload = {
        product_id: form.product_id,
        name: form.name,
        type_id: form.type_id,
        weight: form.weight,
        description: form.description,
        price: form.price,
        stock_quantity: form.stock_quantity,
        attributes: Object.entries(attributeValues.value).map(([id, value]) => ({
            id,
            value,
        })),
    };

    form.post(route("pim.products.store"), {
        data: payload,
        onSuccess: () => {
            success("Product created successfully!");
            emit("productCreated");
            closeModal();
        },
        onError: () => {
            error("Failed to create product. Please try again.");
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
                <!-- Static Fields -->
                <Input
                    label="Product ID"
                    id="product_id"
                    inputType="text"
                    placeholder="Enter product ID"
                    type="field"
                    v-model="form.product_id"
                    :error="form.errors.product_id"
                />
                <Input
                    label="Name"
                    id="name"
                    inputType="text"
                    placeholder="Enter product name"
                    type="field"
                    v-model="form.name"
                    :error="form.errors.name"
                />
                <Input
                    label="Type"
                    id="type_id"
                    type="selectType"
                    v-model="form.type_id"
                    :types="types"
                    optionValue="id"
                    optionLabel="name"
                    placeholder="Select product type"
                    :error="form.errors.type_id"
                />
                <Input
                    label="Weight"
                    id="weight"
                    inputType="number"
                    placeholder="Enter product weight"
                    type="field"
                    v-model="form.weight"
                    :error="form.errors.weight"
                />
                <Input
                    label="Description"
                    id="description"
                    inputType="text"
                    placeholder="Enter product description"
                    type="field"
                    v-model="form.description"
                    :error="form.errors.description"
                />
                <Input
                    label="Price"
                    id="price"
                    inputType="number"
                    placeholder="Enter product price"
                    type="field"
                    v-model="form.price"
                    :error="form.errors.price"
                />
                <Input
                    label="Stock Quantity"
                    id="stock_quantity"
                    inputType="number"
                    placeholder="Enter stock quantity"
                    type="field"
                    v-model="form.stock_quantity"
                    :error="form.errors.stock_quantity"
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
