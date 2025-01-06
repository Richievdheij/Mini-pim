<script setup>
import { ref, watch } from "vue";
import axios from "axios";
import Input from "@/Components/General/Input.vue";
import TertiaryButton from "@/Components/General/TertiaryButton.vue";

const props = defineProps({
    types: Array,
    modelValue: [String, Number],
    attributeValues: Object,
    productId: Number,
    attributes: Array,
    errors: Object,
});

const emit = defineEmits(["update:modelValue", "attributesUpdated"]);

// Local state
const typeId = ref(props.modelValue);
const attributes = ref([]);
const errors = ref({});

// Watch for changes in typeId to fetch attributes
watch(
    () => typeId.value,
    async (newTypeId) => {

        // Fetch attributes
        if (newTypeId) {
            try {
                const response = await axios.get(route("pim.types.attributes", {typeId: newTypeId}));
                // console.log(response.data.attributes);
                attributes.value = response.data.attributes || [];
            } catch (err) {
                console.error("Failed to fetch attributes:", err);
            }
            // Reset attribute values
        } else {
            attributes.value = [];
        }
    },
    {immediate: true}
);

// Save attributes
const saveAttributes = async () => {
    errors.value = {};

    // Validate fields
    attributes.value.forEach((attribute) => {
        if (!props.attributeValues[attribute.id]) { // Check if value is empty
            errors.value[attribute.id] = `${attribute.name} is required.`;
        }
    });

    if (Object.keys(errors.value).length > 0) return; // Stop if there are errors

    // Save attributes
    try {
        await axios.post(route("pim.attribute-values.store"), {
            values: Object.entries(props.attributeValues).map(([id, value]) => ({
                attribute_id: id,
                value,
            })),
        });
        emit("attributesUpdated", props.attributeValues);
    } catch (err) {
        console.error("Failed to save attributes:", err);
    }
};
</script>

<template>
    <div class="edit-product-modal-types">
        <form class="edit-product-modal-types__form" @submit.prevent="saveAttributes">
            <!-- Type Selection -->
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

            <!-- Dynamic Attributes -->
            <div v-if="attributes.length" class="edit-product-modal-types__attributes">
                <div
                    v-for="attribute in attributes"
                    :key="attribute.id"
                >
                    <Input
                        type="field"
                        :label="attribute.name"
                        :id="`attribute_${attribute.id}`"
                        v-model="props.attributeValues[attribute.id]"
                        :error="errors[attribute.id]"
                        required
                    />
                </div>
            </div>

            <TertiaryButton
                type="cancel"
                label="Save Attributes"
            />
        </form>
    </div>
</template>
