<script setup>
import { useForm } from "@inertiajs/vue3";
import { watch } from "vue";
import { useNotifications } from "@/plugins/notificationPlugin"; // Import notifications
import Input from "@/Components/General/Input.vue";
import SecondaryButton from "@/Components/General/SecondaryButton.vue";
import TertiaryButton from "@/Components/General/TertiaryButton.vue";

const props = defineProps({
    isOpen: Boolean,
});
const emit = defineEmits(["close", "typeCreated"]);

const { success, error } = useNotifications(); // Destructure success and error notifications

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

function closeModal() {
    emit("close");
    form.reset();
    form.clearErrors();
}

function submit() {
    form.post(route("types.store"), {
        preserveScroll: true,
        onSuccess: () => {
            success("Type created successfully!"); // Display success notification
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
                <Input
                    label="Name"
                    id="name"
                    inputType="text"
                    placeholder="Enter type name"
                    type="field"
                    v-model="form.name"
                    :error="form.errors.name"
                />
                <div class="create-type-modal__actions">
                    <TertiaryButton
                        label="Cancel"
                        type="cancel"
                        @click="closeModal"
                    />
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

<style scoped>
.create-type-modal {
    position: fixed;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    background: rgba(0, 0, 0, 0.5);
    display: flex;
    justify-content: center;
    align-items: center;
    z-index: 1000;
}

.create-type-modal__content {
    background: white;
    padding: 2rem;
    border-radius: 8px;
    max-width: 500px;
    width: 100%;
}

.create-type-modal__title {
    font-size: 1.5rem;
    margin-bottom: 1rem;
}

.create-type-modal__actions {
    margin-top: 1.5rem;
    display: flex;
    justify-content: flex-end;
    gap: 1rem;
}
</style>
