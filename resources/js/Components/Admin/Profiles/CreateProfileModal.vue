<script setup>
import {useForm} from "@inertiajs/vue3";
import {watch} from "vue";
import {useNotifications} from "@/plugins/notificationPlugin"; // Import centralized notification plugin
import Input from "@/Components/General/Input.vue";
import SecondaryButton from "@/Components/General/SecondaryButton.vue";
import TertiaryButton from "@/Components/General/TertiaryButton.vue";

const props = defineProps({
    isOpen: Boolean,
});
const emit = defineEmits(["close"]);

const {success, error} = useNotifications(); // Use notifications

const form = useForm({
    name: "",
});

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
    const { success, error } = useNotifications(); // Simplified usage

    form.post(route("profiles.store"), {
        onSuccess: () => {
            success("Profile created successfully!");
            closeModal();
        },
        onError: () => {
            error("Failed to create profile.");
        },
    });
}
</script>

<template>
    <div v-if="isOpen" class="create-profile-modal">
        <div class="create-profile-modal__overlay"></div>
        <div class="create-profile-modal__content">
            <h2 class="create-profile-modal__title">Create Profile</h2>
            <form @submit.prevent="submit" class="create-profile-modal__form">
                <Input
                    label="Name"
                    id="name"
                    inputType="text"
                    placeholder="Enter profile name"
                    type="field"
                    v-model="form.name"
                    :error="form.errors.name"
                />
                <div class="create-profile-modal__actions">
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
