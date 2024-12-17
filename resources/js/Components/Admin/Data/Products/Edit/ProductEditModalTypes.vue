<script setup>
import { ref, watch, defineEmits, defineProps } from "vue";
import axios from "axios";
import Input from "@/Components/General/Input.vue";

const props = defineProps({
    types: Array, // List of available product types
    modelValue: [String, Number], // Selected type_id
    product: Object, // Product data to prepopulate attribute values
});

const emit = defineEmits(["update:modelValue", "attributesUpdated"]);

// State for selected product type
const typeId = ref(props.modelValue);

// State to store fetched attributes for the selected type
const attributes = ref([]);

// State to store input values for each attribute
const attributeValues = ref({});

// Watch for changes in the selected product type to fetch its attributes
watch(
    () => typeId.value,
    async (newTypeId) => {
        if (newTypeId) {
            try {
                // Fetch the attributes for the selected type from the API
                const response = await axios.get(route("pim.types.attributes", { typeId: newTypeId }));
                attributes.value = response.data.attributes || [];

                // Prepopulate attribute values using product data if available
                attributeValues.value = attributes.value.reduce((acc, attr) => {
                    acc[attr.id] = props.product?.attributes?.find((a) => a.id === attr.id)?.value || "";
                    return acc;
                }, {});

                // Emit updated attribute values to the parent component
                emit("attributesUpdated", attributeValues.value);
            } catch (err) {
                console.error("Failed to fetch attributes:", err);
            }
        } else {
            // Reset attributes and values if no type is selected
            attributes.value = [];
            attributeValues.value = {};
            emit("attributesUpdated", {});
        }
    },
    { immediate: true } // Trigger this watcher immediately on component mount
);

// Watch for changes in the selected type_id and emit to the parent component
watch(
    () => typeId.value,
    (newVal) => {
        emit("update:modelValue", newVal);
    }
);
</script>

<template>
    <div class="edit-product-modal-types">
        <form class="edit-product-modal-types__form">
            <!-- Select Product Type -->
            <Input
                label="Type"
                id="type_id"
                type="selectType"
                v-model="typeId"
                :types="types"
                optionValue="id"
                optionLabel="name"
                placeholder="Select Type"
                required
            />

            <!-- Dynamic Attribute Inputs -->
            <div v-if="attributes.length" class="edit-product-modal-types__attributes">
                <div
                    v-for="attribute in attributes"
                    :key="attribute.id"
                    class="edit-product-modal-types__attribute"
                >
                    <!-- Attribute Name and Input Field of type 'field' -->
                    <Input
                        :label="attribute.name"
                        :id="`attribute-${attribute.id}`"
                        type="field"
                        v-model="attributeValues[attribute.id]"
                        :placeholder="`Value`"
                    />
                </div>
            </div>
        </form>
    </div>
</template>
