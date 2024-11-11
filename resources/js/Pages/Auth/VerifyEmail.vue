<script setup>
import { computed } from 'vue';
import PrimaryButton from '@/Components/General/PrimaryButton.vue';
import { useForm } from '@inertiajs/vue3';

const props = defineProps({
    status: {
        type: String,
    },
});

const form = useForm({});

const submit = () => {
    form.post(route('verification.send'));
};

const verificationLinkSent = computed(() => props.status === 'verification-link-sent');
</script>

<template>
    <div class="verify-email">
        <p class="verify-email__description">
            Thanks for signing up! Before getting started, could you verify your email address by clicking on the link
            we just emailed to you? If you didn't receive the email, we will gladly send you another.
        </p>

        <p v-if="verificationLinkSent" class="verify-email__status">
            A new verification link has been sent to the email address you provided during registration.
        </p>

        <form class="verify-email__form" @submit.prevent="submit">
            <div class="verify-email__actions">
                <PrimaryButton :class="{ 'opacity-25': form.processing }" :disabled="form.processing">
                    Resend Verification Email
                </PrimaryButton>
            </div>
        </form>
    </div>
</template>
