<script setup>
import { useForm } from '@inertiajs/vue3';
import { defineProps, defineEmits } from 'vue';
import Input from "@/Components/General/Input.vue";
import SecondaryButton from "@/Components/General/SecondaryButton.vue";
import TertiaryButton from "@/Components/General/TertiaryButton.vue";

const props = defineProps({
    attribute: Object,
    types: Array,
});

const emit = defineEmits(['close']);

const form = useForm({
    name: props.attribute?.name || '',
    type_id: props.attribute?.type_id || '',
});

function closeModal() {
    emit('close');
    form.reset();
    form.clearErrors();
}

function submit() {
    form.put(route('pim.attributes.update', props.attribute.id), {
        onSuccess: () => {
            emit('close');
        },
        onError: (errors) => {
            console.error(errors); // Debugging errors
        },
    });
}
</script>

<template>
    <div v-if="form.processing" class="edit-attribute-modal">
        <div class="edit-attribute-modal__overlay"></div>
        <div class="edit-attribute-modal__content">
            <h2 class="edit-attribute-modal__title">Edit Attribute</h2>
            <form @submit.prevent="submit" class="edit-attribute-modal__form">
                <!-- Name input field -->
                <Input
                    label="Name"
                    id="name"
                    inputType="text"
                    placeholder="Enter the attribute name"
                    type="field"
                    v-model="form.name"
                    :error="form.errors.name"
                />

                <!-- Type dropdown field -->
                <label for="type_id" class="edit-attribute-modal__label">
                    Type:
                    <select
                        v-model="form.type_id"
                        id="type_id"
                        class="edit-attribute-modal__select"
                        required
                    >
                        <option disabled value="">Select Type</option>
                        <option v-for="type in props.types" :value="type.id" :key="type.id">
                            {{ type.name }}
                        </option>
                    </select>
                </label>

                <!-- Action buttons for the modal (Cancel and Edit) -->
                <div class="edit-attribute-modal__actions">
                    <TertiaryButton
                        label="Cancel"
                        type="cancel"
                        @click="closeModal"
                    />
                    <SecondaryButton
                        label="Update"
                        type="submit"
                        :disabled="form.processing"
                    />
                </div>
            </form>
        </div>
    </div>
</template>
