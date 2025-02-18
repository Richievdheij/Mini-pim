<script setup>
import Input from "@/Components/General/Input.vue";

/**
 * Component properties
 * @typedef {Object} Props
 * @property {Object} form - Object containing the form data.
 */
const props = defineProps({
    form: Object
});

/**
 * Emits events to update the form data.
 * @typedef {Object} Emits
 * @property {Function} update:form - Emits the updated form object.
 */
const emit = defineEmits(['update:form']);

/**
 * Updates the form data by modifying a specific key.
 * @param {string} key - The form field key to update.
 * @param {string|number} value - The new value for the field.
 */
function updateForm(key, value) {
    const newForm = { ...props.form, [key]: value };
    emit('update:form', newForm);
}
</script>

<template>
    <div class="edit-product-modal-info">
        <!-- Input fields for product details -->
        <Input
            label="Weight (kg)"
            id="weight"
            type="field"
            inputType="number"
            v-model="form.weight"
            @input="(value) => updateForm('weight', value)"
            :error="form.errors?.weight"
            required
        />
        <Input
            label="Height (cm)"
            id="height"
            type="field"
            inputType="number"
            v-model="form.height"
            @input="(value) => updateForm('height', value)"
            :error="form.errors?.height"
            required
        />
        <Input
            label="Width (cm)"
            id="width"
            type="field"
            inputType="number"
            v-model="form.width"
            @input="(value) => updateForm('width', value)"
            :error="form.errors?.width"
            required
        />
        <Input
            label="Depth (cm)"
            id="depth"
            type="field"
            inputType="number"
            v-model="form.depth"
            @input="(value) => updateForm('depth', value)"
            :error="form.errors?.depth"
            required
        />
        <Input
            label="Price"
            id="price"
            type="field"
            inputType="number"
            v-model="form.price"
            @input="(value) => updateForm('price', value)"
            :error="form.errors?.price"
            required
        />
        <Input
            label="Stock Quantity"
            id="stock_quantity"
            type="field"
            inputType="number"
            v-model="form.stock_quantity"
            @input="(value) => updateForm('stock_quantity', value)"
            :error="form.errors?.stock_quantity"
            required
        />
    </div>
</template>
