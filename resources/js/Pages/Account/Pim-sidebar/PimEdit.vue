<script setup>
import PIMLayout from '@/Layouts/PIMLayout.vue';
import PimDeleteAccountForm from '@/Pages/Account/Pim-sidebar/Partials/PimDeleteAccountForm.vue';
import PimUpdatePasswordForm from '@/Pages/Account/Pim-sidebar/Partials/PimUpdatePasswordForm.vue';
import PimUpdateProfileInformationForm from '@/Pages/Account/Pim-sidebar/Partials/PimUpdateProfileInformationForm.vue';
import { Head } from '@inertiajs/vue3';

</script>

<template>
    <Head title="Account settings" />

    <PIMLayout>
        <div class="profile">
            <div class="profile__header">
                <h1 class="profile__title">Account settings</h1>
            </div>

            <div class="profile__section">
                <PimUpdateProfileInformationForm />
                <PimUpdatePasswordForm />
                <PimDeleteAccountForm />
            </div>
        </div>
    </PIMLayout>
</template>
