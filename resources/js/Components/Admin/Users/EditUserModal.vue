<script setup>
import { useForm } from '@inertiajs/vue3';
import { watch } from 'vue';
import { useNotifications } from "@/plugins/notificationPlugin";
import Input from '@/Components/General/Input.vue';
import SecondaryButton from '@/Components/General/SecondaryButton.vue';
import TertiaryButton from "@/Components/General/TertiaryButton.vue";

const { success, error } = useNotifications();

// Props and emits
const props = defineProps({
    user: Object,
    profiles: Array,
    isOpen: Boolean,
});

const emit = defineEmits(['close']);

// Form
const form = useForm({
    name: '',
    email: '',
    password: '',
    profiles: [],
});

// Watch for when the modal is opened
watch(
    () => props.isOpen,
    (isOpen) => {
        if (isOpen && props.user) {
            form.name = props.user.name;
            form.email = props.user.email;
            form.password = ''; // Clear password field
            form.profiles = props.user.profiles.map(profile => profile.id); // Assign profile IDs
        }
    }
);

// Close modal function
function closeModal() {
    emit('close');
    form.reset();
    form.clearErrors();
}

// Submit function to handle user update
function submit() {
    form.put(`/users/${props.user.id}`, {
        preserveScroll: true,
        onSuccess: () => {
            success(`User "${props.user.name}" updated successfully!`);
            closeModal();
        },
        onError: () => {
            error(`Failed to update user "${props.user.name}". Please try again.`);
        },
    });
}
</script>

<template>
    <div v-if="isOpen" class="edit-user-modal">
        <div class="edit-user-modal__overlay"></div>
        <div class="edit-user-modal__content">
            <h2 class="edit-user-modal__title">Edit User "{{ props.user.name }}"</h2>
            <form @submit.prevent="submit" class="edit-user-modal__form">
                <!-- Name input -->
                <Input
                    label="Name"
                    inputType="text"
                    placeholder="Enter user name"
                    type="field"
                    v-model="form.name"
                    :error="form.errors.name"
                />
                <!-- Email input -->
                <Input
                    label="Email"
                    id="email"
                    inputType="email"
                    placeholder="Enter email address"
                    type="field"
                    v-model="form.email"
                    :error="form.errors.email"
                />
                <!-- Password input -->
                <Input
                    label="Password"
                    id="password"
                    inputType="password"
                    placeholder="Leave blank to keep current password"
                    type="field"
                    v-model="form.password"
                    :error="form.errors.password"
                />
                <!-- Assign profiles select -->
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
                <div class="edit-user-modal__actions">
                    <!-- Cancel and Update buttons -->
                    <TertiaryButton
                        label="Cancel"
                        type="cancel"
                        @click="closeModal"
                        :disabled="form.processing"
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
