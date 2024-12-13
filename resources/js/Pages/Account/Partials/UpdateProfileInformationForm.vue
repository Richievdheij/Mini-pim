<script setup>
import { useForm, usePage } from '@inertiajs/vue3';
import { useNotifications } from "@/plugins/notificationPlugin";
import Input from '@/Components/General/Input.vue';
import PrimaryButton from '@/Components/General/PrimaryButton.vue';

defineProps({
    mustVerifyEmail: {
        type: Boolean,
    },
    status: {
        type: String,
    },
});

const user = usePage().props.auth.user;

const form = useForm({
    name: user.name,
    email: user.email,
});

// Initialize notifications system
const { success, error } = useNotifications();

// Handle form submission (patch the form data)
function submit() {
    form.patch(route('account.update'), {
        onSuccess: () => {
            success("Account updated successfully!"); // Notify success
        },
        onError: () => {
            error("Failed to update account."); // Notify failure
        },
    });
}
</script>

<template>
    <div class="update-profile-information-form">
        <h2 class="update-profile-information-form__title">Profile Information</h2>
        <p class="update-profile-information-form__description">
            Update your account's profile information and email address.
        </p>

        <form class="update-profile-information-form__form" @submit.prevent="submit">
            <!-- Name Input Group -->
            <Input
                type="field"
                label="Name"
                id="name"
                v-model="form.name"
                :error="form.errors.name"
                :placeholder="user.name"
                required
                autofocus
            />

            <!-- Email Input Group -->
            <Input
                type="field"
                label="Email address"
                id="email"
                v-model="form.email"
                :error="form.errors.email"
                :placeholder="user.email"
                required
            />

            <!-- Save Button -->
            <PrimaryButton
                label="Save"
                type="submit"
                :disabled="form.processing"
            />
        </form>
    </div>
</template>
