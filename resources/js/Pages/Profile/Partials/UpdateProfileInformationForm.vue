<script setup>
import { useForm, usePage } from '@inertiajs/vue3';
import Input from '@/Components/General/Input.vue';
import Button from '@/Components/General/Button.vue';
import { Link } from '@inertiajs/vue3';

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
</script>

<template>
    <div class="update-profile-information-form">
        <h2 class="update-profile-information-form__title">Profile Information</h2>
        <p class="update-profile-information-form__description">
            Update your account's profile information and email address.
        </p>

        <form class="update-profile-information-form__form" @submit.prevent="form.patch(route('profile.update'))" >
            <!-- Name Input Group -->
            <Input type="name" label="Name" />
            <Input type="field"
               id="name"
               v-model="form.name"
               :error="form.errors.name"
               required
               autofocus
               :placeholder="user.name"
            />
            <!-- Error input -->
            <Input type="error" :message="form.errors.name" />

            <!-- Email Input Group -->
            <Input type="email" label="Email adress" />
            <Input type="field"
                id="email"
                v-model="form.email"
                :error="form.errors.email"
                required
                :placeholder="user.email"
            />
            <!-- Error input -->
            <Input type="error" :message="form.errors.email" />

            <!-- Email verification notice -->
            <div v-if="mustVerifyEmail && user.email_verified_at === null">
                <p>Your email address is unverified.</p>
                <Link class="update-profile-information-form__verify-link"
                    :href="route('verification.send')" method="post" as="button"
                >
                    Click here to re-send the verification email.
                </Link>

                <p>After changing your email address, you will need to verify it again.</p>
                <p class="update-profile-information-form__status"
                    v-show="status === 'verification-link-sent'">
                    A new verification link has been sent to your email address.
                </p>
            </div>

            <Input type="hidden" name="_method" value="PATCH" />
            <Button label="Save" type="submit" :disabled="form.processing"/>
        </form>
    </div>
</template>
