<script setup>
import { useForm } from '@inertiajs/vue3';
import { watch } from 'vue';
import Input from '@/Components/General/Input.vue';
import SecondaryButton from '@/Components/General/SecondaryButton.vue';
import TertiaryButton from "@/Components/General/TertiaryButton.vue";
import { useNotifications } from "@/plugins/notificationPlugin"; // Import notifications

const { success, error } = useNotifications(); // Destructure success and error notifications

const props = defineProps({
    type: Object,
    isOpen: Boolean,
});
const emit = defineEmits(['close']);

const form = useForm({
    name: '',
});

watch(
    () => props.isOpen,
    (isOpen) => {
        if (isOpen && props.type) {
            form.name = props.type.name;
        }
    }
);

function closeModal() {
    emit('close');
    form.reset();
    form.clearErrors();
}

function submit() {
    form.put(`/product-types/${props.type.id}`, {
        preserveScroll: true,
        onSuccess: () => {
            success(`Product Type "${props.type.name}" updated successfully!`);
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
            <h2 class="edit-type-modal__title">Edit Product Type</h2>
            <form @submit.prevent="submit" class="edit-type-modal__form">
                <Input
                    label="Type Name"
                    inputType="text"
                    placeholder="Enter type name"
                    type="field"
                    v-model="form.name"
                    :error="form.errors.name"
                />
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
