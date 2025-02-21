<script setup>
import { watch, reactive, toRefs } from "vue";
import Input from "@/Components/General/Input.vue";

/**
 * Define component props
 * @property {Object} form - Form data object
 * @property {Object} errors - Validation errors object
 * @property {Boolean} isOpen - Determines if the modal is open
 * @property {Object} product - Product data
 */
const props = defineProps({
    form: Object,
    errors: Object,
    isOpen: Boolean,
    product: Object,
});

// Reactive placeholders for input fields
const placeholders = reactive({
    weight: "",
    height: "",
    width: "",
    depth: "",
    price: "",
    stock_quantity: "",
});

// Watch for modal open state and set placeholders
watch(
    () => props.isOpen,
    (isOpen) => {
        if (isOpen && props.product) {
            placeholders.weight = props.product.weight || "";
            placeholders.height = props.product.height || "";
            placeholders.width = props.product.width || "";
            placeholders.depth = props.product.depth || "";
            placeholders.price = props.product.price || "";
            placeholders.stock_quantity = props.product.stock_quantity || "0";
        }
    },
    { immediate: true }
);

// Destructure form and errors from props
const { form, errors } = toRefs(props);
</script>

<template>
    <div class="edit-product-modal-info">
        <!-- Weight field for product information -->
        <Input
            label="Weight (kg)"
            id="weight"
            type="field"
            inputType="number"
            step="0.01"
            min="0"
            v-model="form.weight"
            :error="errors.weight"
            :placeholder="placeholders.weight"
            required
        />
        <!-- Height field for product information -->
        <Input
            label="Height (cm)"
            id="height"
            type="field"
            inputType="number"
            step="0.01"
            min="0"
            v-model="form.height"
            :error="errors.height"
            :placeholder="placeholders.height"
            required
        />
        <!-- Width field for product information -->
        <Input
            label="Width (cm)"
            id="width"
            type="field"
            inputType="number"
            step="0.01"
            min="0"
            v-model="form.width"
            :error="errors.width"
            :placeholder="placeholders.width"
            required
        />
        <!-- Depth field for product information -->
        <Input
            label="Depth (cm)"
            id="depth"
            type="field"
            inputType="number"
            step="0.01"
            min="0"
            v-model="form.depth"
            :error="errors.depth"
            :placeholder="placeholders.depth"
            required
        />
        <!-- Price field for product information -->
        <Input
            label="Price (€)"
            id="price"
            type="field"
            inputType="number"
            step="0.01"
            min="0"
            v-model="form.price"
            :error="errors.price"
            :placeholder="placeholders.price"
            required
        />
        <!-- Stock quantity field for product information -->
        <Input
            label="Stock Quantity"
            id="stock_quantity"
            type="field"
            inputType="number"
            step="1"
            min="0"
            v-model="form.stock_quantity"
            :error="errors.stock_quantity"
            :placeholder="placeholders.stock_quantity"
            required
        />
    </div>
</template>
