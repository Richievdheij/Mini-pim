<script setup>
import { useForm, usePage } from '@inertiajs/vue3';
import Input from '@/Components/General/Input.vue';
import PrimaryButton from '@/Components/General/PrimaryButton.vue';
import VerifyEmail from '@/Pages/Auth/VerifyEmail.vue';

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

const sendVerification = () => {
    form.post(route('verification.send'), {
        onFinish: () => {
            form.setStatus('verification-link-sent');
        },
    });
};
</script>

<template>
    <div class="update-profile-information-form">
        <h2 class="update-profile-information-form__title">Profile Information</h2>
        <p class="update-profile-information-form__description">
            Update your account's profile information and email address.
        </p>

        <form class="update-profile-information-form__form" @submit.prevent="form.patch(route('profile.update'))">
            <!-- Name Input Group -->
            <Input type="name" label="Name"/>
            <Input type="field"
                   id="name"
                   v-model="form.name"
                   :error="form.errors.name"
                   required
                   autofocus
                   :placeholder="user.name"
            />
            <Input type="error" :message="form.errors.name"/>

            <!-- Email Input Group -->
            <Input type="email" label="Email address"/>
            <Input type="field"
                   id="email"
                   v-model="form.email"
                   :error="form.errors.email"
                   required
                   :placeholder="user.email"
            />
            <Input type="error" :message="form.errors.email"/>

            <!-- Email Verification Status -->
            <div v-if="mustVerifyEmail && user.email_verified_at === null">
                <VerifyEmail :status="status"/>
                <p>After changing your email address, you will need to verify it again.</p>
            </div>

            <Input type="hidden" name="_method" value="PATCH"/>
            <PrimaryButton label="Save" type="submit" :disabled="form.processing"/>
        </form>
    </div>
</template>
