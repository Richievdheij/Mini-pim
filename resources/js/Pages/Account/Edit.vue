<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import DeleteAccountForm from '@/Pages/Account/Partials/DeleteAccountForm.vue';
import UpdatePasswordForm from '@/Pages/Account/Partials/UpdatePasswordForm.vue';
import UpdateProfileInformationForm from '@/Pages/Account/Partials/UpdateProfileInformationForm.vue';
import { Head } from '@inertiajs/vue3';

</script>

<template>
    <Head title="Account settings" />

    <AuthenticatedLayout>
        <div class="profile">
            <div class="profile__header">
                <h1 class="profile__title">Account settings</h1>
            </div>

            <!-- Profile information -->
            <div class="profile__section">
                <UpdateProfileInformationForm />
                <UpdatePasswordForm />
                <DeleteAccountForm />
            </div>
        </div>
    </AuthenticatedLayout>
</template>
