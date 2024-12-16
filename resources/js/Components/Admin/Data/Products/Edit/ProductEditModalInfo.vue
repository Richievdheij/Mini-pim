<script setup>
import { useForm } from "@inertiajs/vue3";
import Input from "@/Components/General/Input.vue";

const props = defineProps({
    product: Object,
});

const emit = defineEmits(["productUpdated"]);

const form = useForm({
    weight: props.product?.weight || "",
    height: props.product?.height || "",
    width: props.product?.width || "",
    depth: props.product?.depth || "",
    price: props.product?.price || "",
    stock_quantity: props.product?.stock_quantity || "",
    // Add Active/Inactive
});

</script>

<template>
    <div class="edit-product-modal-info">
            <form class="edit-product-modal-info__form">
                <!-- Add dimensions & weight popup button -->
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

                <!-- Size: Height input field -->
                <Input
                    label="Height"
                    id="height"
                    inputType="number"
                    placeholder="Enter product height"
                    type="field"
                    v-model="form.height"
                    :error="form.errors.height"
                />
                <!-- Size: Width input field -->
                <Input
                    label="Width"
                    id="width"
                    inputType="number"
                    placeholder="Enter product width"
                    type="field"
                    v-model="form.width"
                    :error="form.errors.width"
                />
                <!-- Size: Depth input field -->
                <Input
                    label="Depth"
                    id="depth"
                    inputType="number"
                    placeholder="Enter product depth"
                    type="field"
                    v-model="form.depth"
                    :error="form.errors.depth"
                />

                <!-- Add Pricing & stock popup button -->
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
            </form>
        </div>
</template>
