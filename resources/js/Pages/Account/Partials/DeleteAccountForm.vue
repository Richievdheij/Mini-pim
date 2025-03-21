<script setup>
import { useForm } from '@inertiajs/vue3';
import { ref } from 'vue';
import { useNotifications } from "@/plugins/notificationPlugin";
import Input from '@/Components/General/Input.vue';
import PrimaryButton from '@/Components/General/PrimaryButton.vue';
import SecondaryButton from "@/Components/General/SecondaryButton.vue";
import TertiaryButton from "@/Components/General/TertiaryButton.vue";
import Modal from '@/Components/laravelWelcome/Modal.vue';

// Data properties and methods for the component
const confirmingUserDeletion = ref(false);
const passwordInput = ref(null);

// Form initialization
const form = useForm({
    password: '',
});

// Confirm user deletion
const confirmUserDeletion = () => {
    confirmingUserDeletion.value = true;
};

// Close the modal
const closeModal = () => {
    confirmingUserDeletion.value = false;
    form.clearErrors();
    form.reset();
};

// Initialize notifications system
const { success, error } = useNotifications();

// Delete user account
const deleteUser = () => {
    form.delete(route('account.destroy'), {
        preserveScroll: true,
        onSuccess: () => {
            closeModal();
            success("Account deleted successfully!"); // Notify success
        },
        onError: () => {
            error("Failed to delete account."); // Notify failure
            if (form.errors.password) {
                passwordInput.value.focus();
            }
        },
        onFinish: () => {
            form.reset(); // Reset the form after submission
        },
    });
};

</script>

<template>
    <div class="delete-user-form">
        <h2 class="delete-user-form__title">Delete Account</h2>
        <p class="delete-user-form__description">
            Once your account is deleted, all of its resources and data will be permanently deleted.
        </p>

        <!-- Delete Account Button -->
        <PrimaryButton
            label="Delete Account"
            type="delete"
            @click="confirmUserDeletion"
        />

        <!-- Delete Account Modal -->
        <Modal :show="confirmingUserDeletion" @close="closeModal">
            <div class="delete-user-form__modal">
                <h2 class="delete-user-form__title">Are you sure you want to delete your account?</h2>
                <p class="delete-user-form__description">Enter your password to confirm deletion.</p>

                <!-- Password Input Group -->
                <Input
                    type="field"
                    label="Password"
                    id="password"
                    input-type="password"
                    placeholder="Enter your Password"
                    v-model="form.password"
                    ref="passwordInput"
                    :error="form.errors.password"
                    @keyup.enter="deleteUser"
                />

                <!-- Delete Account Actions -->
                <div class="delete-user-form__actions">
                    <TertiaryButton
                        label="Cancel"
                        @click="closeModal"
                    />
                    <SecondaryButton
                        label="Delete Account"
                        type="delete"
                        @click="deleteUser"
                        :disabled="form.processing"
                    />
                </div>
            </div>
        </Modal>
    </div>
</template>
