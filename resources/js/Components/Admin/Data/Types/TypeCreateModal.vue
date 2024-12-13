<script setup>
import { useForm } from "@inertiajs/vue3";
import { watch } from "vue";
import { useNotifications } from "@/plugins/notificationPlugin";
import Input from "@/Components/General/Input.vue";
import SecondaryButton from "@/Components/General/SecondaryButton.vue";
import TertiaryButton from "@/Components/General/TertiaryButton.vue";

const props = defineProps({
    types: Object,
    isOpen: Boolean,
});
const emit = defineEmits(["close", "typeCreated"]);

// Destructure success and error notifications
const { success, error } = useNotifications();

const form = useForm({
    name: "",
});

// Reset and clear form errors when the modal is opened
watch(
    () => props.isOpen,
    (isOpen) => {
        if (isOpen) {
            form.reset();
            form.clearErrors();
        }
    }
);

// Close the modal
function closeModal() {
    emit("close");
    form.reset();
    form.clearErrors();
}

function submit() {
    form.post(route("pim.types.store"), {
        onSuccess: () => {
            success(`Type "${form.name}" created successfully!`); // Display success notification
            closeModal();
        },
        onError: () => {
            error("Failed to create type. Please try again."); // Display error notification
        },
    });
}
</script>

<template>
    <div v-if="isOpen" class="create-type-modal">
        <div class="create-type-modal__overlay"></div>
        <div class="create-type-modal__content">
            <h2 class="create-type-modal__title">Create Type</h2>
            <form @submit.prevent="submit" class="create-type-modal__form">
                <!-- Name -->
                <Input
                    label="Name"
                    id="name"
                    inputType="text"
                    placeholder="Enter type name"
                    type="field"
                    v-model="form.name"
                    :error="form.errors.name"
                />
                <!-- Actions -->
                <div class="create-type-modal__actions">
                    <!-- Cancel -->
                    <TertiaryButton
                        label="Cancel"
                        type="cancel"
                        @click="closeModal"
                    />
                    <!-- Create -->
                    <SecondaryButton
                        label="Create"
                        type="submit"
                        :disabled="form.processing"
                    />
                </div>
            </form>
        </div>
    </div>
</template>
