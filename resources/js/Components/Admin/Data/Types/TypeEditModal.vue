<script setup>
import { useForm } from '@inertiajs/vue3';
import { watch } from 'vue';
import { useNotifications } from "@/plugins/notificationPlugin";
import Input from '@/Components/General/Input.vue';
import SecondaryButton from '@/Components/General/SecondaryButton.vue';
import TertiaryButton from "@/Components/General/TertiaryButton.vue";

const { success, error } = useNotifications(); // Destructure success and error notifications

// Define props and emits from parent component
const props = defineProps({
    type: Object,
    isOpen: Boolean,
});

// Define emits
const emit = defineEmits(['close']);

// Form handling
const form = useForm({
    name: '',
});

// Watch for changes in isOpen prop
watch(
    () => props.isOpen,
    (isOpen) => {
        if (isOpen && props.type) {
            form.name = props.type.name;
        }
    }
);

// Close modal
function closeModal() {
    emit('close');
    form.reset();
    form.clearErrors();
}

// Submit form
function submit() {
    form.put(route('pim.types.update', props.type.id), {
        preserveScroll: true,
        onSuccess: () => {
            success(`Type "${form.name}" updated successfully!`); // Success message
            closeModal();
        },
        onError: () => {
            error("Failed to update the product type. Please try again.");
        },
    });
}
</script>

<template>
    <div v-if="isOpen" class="edit-type-modal">
        <div class="edit-type-modal__overlay"></div>
        <div class="edit-type-modal__content">
            <h2 class="edit-type-modal__title">Edit Product Type "{{ props.type.name }}"</h2>
            <form @submit.prevent="submit" class="edit-type-modal__form">
                <!-- Name -->
                <Input
                    label="Type Name"
                    inputType="text"
                    placeholder="Enter type name"
                    type="field"
                    v-model="form.name"
                    :error="form.errors.name"
                />
                <!-- Actions -->
                <div class="edit-type-modal__actions">
                    <TertiaryButton
                        label="Cancel"
                        type="cancel"
                        @click="closeModal"
                    />
                    <SecondaryButton
                        label="Update"
                        type="submit"
                    />
                </div>
            </form>
        </div>
    </div>
</template>
