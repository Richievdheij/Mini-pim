<script setup>
import { useForm } from "@inertiajs/vue3";
import { watch, computed } from "vue";
import Input from "@/Components/General/Input.vue";
import SecondaryButton from "@/Components/General/SecondaryButton.vue";
import TertiaryButton from "@/Components/General/TertiaryButton.vue";
import { useNotifications } from "@/plugins/notificationPlugin";

const { success, error } = useNotifications();

// Define props and emit events
const props = defineProps({
    user: Object,
    profiles: Array,
    isOpen: Boolean,
});
const emit = defineEmits(["close"]);

// Set up form with default values
const form = useForm({
    name: "",
    email: "",
    password: "",
    profiles: [],
});

// Watch for changes to the `isOpen` prop and reset form when modal opens
watch(
    () => props.isOpen,
    (isOpen) => {
        if (isOpen) {
            form.reset();
            form.clearErrors();
        }
    }
);

// Close the modal and reset the form
function closeModal() {
    emit("close");
    form.reset();
    form.clearErrors();
}

// Submit the form
function submit() {
    form.post("/users", {
        preserveScroll: true,
        onSuccess: () => {
            success(`User "${form.name}" created successfully!`); // Success message
            closeModal();
        },
        onError: () => {
            error("Failed to create user. Please try again.");
        },
    });
}
</script>

<template>
    <div v-if="isOpen" class="create-user-modal">
        <div class="create-user-modal__overlay"></div>
        <div class="create-user-modal__content">
            <h2 class="create-user-modal__title">Create User</h2>
            <form @submit.prevent="submit" class="create-user-modal__form">
                <!-- Name input field -->
                <Input
                    label="Name"
                    id="name"
                    inputType="text"
                    placeholder="Enter user name"
                    type="field"
                    v-model="form.name"
                    :error="form.errors.name"
                />
                <!-- Email input field -->
                <Input
                    label="Email"
                    id="email"
                    inputType="email"
                    placeholder="Enter email address"
                    type="field"
                    v-model="form.email"
                    :error="form.errors.email"
                />
                <!-- Password input field -->
                <Input
                    label="Password"
                    id="password"
                    inputType="password"
                    placeholder="Enter a secure password"
                    type="field"
                    v-model="form.password"
                    :error="form.errors.password"
                />
                <!-- Assign profiles select field -->
                <Input
                    label="Assign Profiles"
                    id="profiles"
                    type="select"
                    inputType="select"
                    placeholder="Select profiles"
                    v-model="form.profiles"
                    :options="profiles"
                    :error="form.errors.profiles"
                />
                <!-- Model actions -->
                <div class="create-user-modal__actions">
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
