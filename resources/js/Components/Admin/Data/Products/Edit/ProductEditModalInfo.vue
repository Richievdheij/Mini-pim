<script setup>
import Input from "@/Components/General/Input.vue";

// Define component properties
const props = defineProps({
    form: Object,
    errors: Object
});

// Define emits to update the form
const emit = defineEmits(["update:form"]);

// Function to update the form fields and emit the changes
function updateForm(key, value) {
    const newForm = { ...props.form, [key]: value };
    emit("update:form", newForm);
}
</script>

<template>
    <div class="edit-product-modal-info">
        <Input
            label="Weight (kg)"
            id="weight"
            type="field"
            inputType="number"
            step="0.01"
            min="0"
            v-model="form.weight"
            @update:modelValue="(value) => updateForm('weight', value)"
            :error="errors.weight"
            required
        />
        <Input
            label="Height (cm)"
            id="height"
            type="field"
            inputType="number"
            step="0.1"
            min="0"
            v-model="form.height"
            @update:modelValue="(value) => updateForm('height', value)"
            :error="errors.height"
            required
        />
        <Input
            label="Width (cm)"
            id="width"
            type="field"
            inputType="number"
            step="0.1"
            min="0"
            v-model="form.width"
            @update:modelValue="(value) => updateForm('width', value)"
            :error="errors.width"
            required
        />
        <Input
            label="Depth (cm)"
            id="depth"
            type="field"
            inputType="number"
            step="0.1"
            min="0"
            v-model="form.depth"
            @update:modelValue="(value) => updateForm('depth', value)"
            :error="errors.depth"
            required
        />
        <Input
            label="Price (€)"
            id="price"
            type="field"
            inputType="number"
            step="0.01"
            min="0"
            v-model="form.price"
            @update:modelValue="(value) => updateForm('price', value)"
            :error="errors.price"
            required
        />
        <Input
            label="Stock Quantity"
            id="stock_quantity"
            type="field"
            inputType="number"
            step="1"
            min="0"
            v-model="form.stock_quantity"
            @update:modelValue="(value) => updateForm('stock_quantity', value)"
            :error="errors.stock_quantity"
            required
        />
    </div>
</template>
