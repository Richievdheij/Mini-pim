<script setup>
import { ref, watch } from "vue";
import Input from "@/Components/General/Input.vue";

/**
 * Component properties
 * @typedef {Object} Props
 * @property {Array} types - List of available types.
 * @property {string|number} typeId - Currently selected type ID.
 * @property {Object} attributeValues - Object containing selected attribute values.
 * @property {Array} attributes - List of attributes related to the type.
 * @property {Object} errors - Validation errors.
 */
const props = defineProps({
    types: Array,
    typeId: [String, Number],
    attributeValues: Object,
    attributes: Array,
    errors: Object,
});

/**
 * Emits events to update the selected type ID and attribute values.
 * @typedef {Object} Emits
 * @property {Function} update:typeId - Emits the updated type ID.
 * @property {Function} update:attributeValues - Emits the updated attribute values.
 */
const emit = defineEmits(['update:typeId', 'update:attributeValues']);

/**
 * Reactive state for the selected type ID.
 * @type {import("vue").Ref<string|number>}
 */
const selectedTypeId = ref(props.typeId);

/**
 * Reactive list of attributes for the selected type.
 * @type {import("vue").Ref<Array>}
 */
const localAttributes = ref([]);

/**
 * Watches for changes in the selected type ID and fetches related attributes.
 */
watch(
    () => selectedTypeId.value,
    async (newTypeId) => {
        if (newTypeId) {
            try {
                const response = await axios.get(route("pim.types.attributes", { typeId: newTypeId }));
                localAttributes.value = response.data.attributes || [];
                emit('update:typeId', newTypeId);
            } catch (err) {
                console.error("Failed to fetch attributes:", err);
            }
        } else {
            localAttributes.value = [];
        }
    },
    { immediate: true }
);

/**
 * Updates the attribute value for a given attribute ID.
 * @param {number} attributeId - The ID of the attribute to update.
 * @param {string} value - The new value for the attribute.
 */
function updateAttributeValue(attributeId, value) {
    const newValues = { ...props.attributeValues, [attributeId]: value };
    emit('update:attributeValues', newValues);
}
</script>

<template>
    <div class="edit-product-modal-types">
        <!-- Dropdown for selecting the product type -->
        <Input
            label="Type"
            id="type_id"
            type="selectType"
            v-model="selectedTypeId"
            :types="types"
            optionValue="id"
            optionLabel="name"
            placeholder="Select Type"
            required
        />

        <!-- Dynamically generated input fields for attributes -->
        <div v-if="localAttributes.length" class="edit-product-modal-types__attributes">
            <div v-for="attribute in localAttributes" :key="attribute.id">
                <Input
                    type="field"
                    :label="attribute.name"
                    :id="`attribute_${attribute.id}`"
                    :modelValue="props.attributeValues[attribute.id]"
                    @update:modelValue="(value) => updateAttributeValue(attribute.id, value)"
                    :error="errors[`attributes.${attribute.id}`]"
                    required
                />
            </div>
        </div>
    </div>
</template>
