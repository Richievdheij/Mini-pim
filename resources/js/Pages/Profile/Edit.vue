<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import DeleteUserForm from './Partials/DeleteUserForm.vue';
import UpdatePasswordForm from './Partials/UpdatePasswordForm.vue';
import UpdateProfileInformationForm from './Partials/UpdateProfileInformationForm.vue';
import { Head } from '@inertiajs/vue3';

defineProps({
    mustVerifyEmail: {
        type: Boolean,
    },
    status: {
        type: String,
    },
});

</script>

<template>
    <Head title="Profile" />

    <AuthenticatedLayout>
        <div class="profile">
            <div class="profile__header">
                <h1 class="profile__title">Account settings</h1>
            </div>

            <div class="profile__section">
                <UpdateProfileInformationForm
                    :must-verify-email="mustVerifyEmail"
                    :status="status" />
                <UpdatePasswordForm />
                <DeleteUserForm />
            </div>
        </div>
    </AuthenticatedLayout>
</template>
