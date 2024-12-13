<script setup>
import { ref, watch } from "vue";
import { useForm } from "@inertiajs/vue3";
import Input from "@/Components/General/Input.vue";
import SecondaryButton from "@/Components/General/SecondaryButton.vue";
import TertiaryButton from "@/Components/General/TertiaryButton.vue";

const props = defineProps({
    product: Object, // The selected product to edit
    isOpen: Boolean, // Whether the modal is open or not
    types: Array, // List of product types
    attributes: Array, // List of attributes related to the product type
});

const emit = defineEmits(["close", "productUpdated"]);

// Reactive form state
const form = useForm({
    product_id: props.product?.product_id || "",
    name: props.product?.name || "",
    type_id: props.product?.type_id || "",
    weight: props.product?.weight || "",
    description: props.product?.description || "",
    price: props.product?.price || "",
    stock_quantity: props.product?.stock_quantity || "",
});

const attributes = ref([]);

const attributeValues = ref({});

// Watch for product changes and initialize form and attributes
watch(
    () => props.product,
    (product) => {
        if (product) {
            form.product_id = product.product_id || "";
            form.name = product.name || "";
            form.type_id = product.type_id || "";
            form.weight = product.weight || "";
            form.description = product.description || "";
            form.price = product.price || "";
            form.stock_quantity = product.stock_quantity || "";

            // Initialize attribute values if attributes are available
            attributeValues.value = attributes.value.reduce((acc, attr) => {
                acc[attr.id] = product.attributes?.find((a) => a.id === attr.id)?.value || "";
                return acc;
            }, {});
        }
    },
    { immediate: true }
);

// Watch for type_id changes to fetch related attributes dynamically
watch(
    () => form.type_id,
    async (typeId) => {
        if (typeId) {
            try {
                const response = await axios.get(route("pim.types.attributes", { typeId }));
                const fetchedAttributes = response.data.attributes || [];
                attributes.value = fetchedAttributes;

                // Initialize attribute values for the fetched attributes
                attributeValues.value = fetchedAttributes.reduce((acc, attr) => {
                    acc[attr.id] = props.product?.attributes?.find(a => a.id === attr.id)?.value || "";
                    return acc;
                }, {});
            } catch (error) {
                console.error("Failed to fetch attributes:", error);
            }
        }
    },
    { immediate: true }
);

// Close modal handler
function closeModal() {
    emit("close");
    form.reset();
    attributeValues.value = {};
}

// Submit form data
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
        })), // Send attribute ID and value
    };

    form.put(route("pim.products.update", props.product.id), {
        data: payload,
        onSuccess: () => {
            emit("productUpdated", { ...form, attributes: payload.attributes });
            closeModal();
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
                <div class="edit-product-modal__attributes">
                    <div
                        v-for="attribute in attributes"
                        :key="attribute.id"
                        class="edit-product-modal__attribute"
                    >
                        <label :for="`attribute-${attribute.id}`">{{ attribute.name }}</label>
                        <input
                            v-if="attribute.type === 'text'"
                            class="edit-product-modal__attribute-input"
                            type="text"
                            :id="`attribute-${attribute.id}`"
                            v-model="attributeValues.value[attribute.id]"
                            :placeholder="`Enter ${attribute.name}`"
                        />
                        <input
                            v-else-if="attribute.type === 'number'"
                            class="edit-product-modal__attribute-input"
                            type="number"
                            :id="`attribute-${attribute.id}`"
                            v-model="attributeValues.value[attribute.id]"
                            :placeholder="`Enter ${attribute.name}`"
                        />
                        <!-- Add more input types as necessary -->
                    </div>
                </div>

                <!-- Submit and Cancel Buttons -->
                <div class="edit-product-modal__actions">
                    <TertiaryButton label="Cancel" @click="closeModal" />
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
