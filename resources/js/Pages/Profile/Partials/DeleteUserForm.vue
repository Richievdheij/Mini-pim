<script setup>
import { useForm } from '@inertiajs/vue3';
import { nextTick, ref } from 'vue';
import Input from '@/Components/General/Input.vue';
import Button from '@/Components/General/Button.vue';
import Modal from '@/Components/laravelWelcome/Modal.vue';

const confirmingUserDeletion = ref(false);
const passwordInput = ref(null);

const form = useForm({
    password: '',
});

const confirmUserDeletion = () => {
    confirmingUserDeletion.value = true;
    nextTick(() => passwordInput.value.focus());
};

const deleteUser = () => {
    form.delete(route('profile.destroy'), {
        preserveScroll: true,
        onSuccess: () => closeModal(),
        onError: () => passwordInput.value.focus(),
        onFinish: () => form.reset(),
    });
};

const closeModal = () => {
    confirmingUserDeletion.value = false;
    form.clearErrors();
    form.reset();
};
</script>

<template>
    <div class="delete-user-form">
        <h2 class="delete-user-form__title">Delete Account</h2>
        <p class="delete-user-form__description">
            Once your account is deleted, all of its resources and data will be permanently deleted.
        </p>

        <!-- Delete Account Button -->
        <Button label="Delete Account" @click="confirmUserDeletion" />

        <!-- Delete Account Modal -->
        <Modal :show="confirmingUserDeletion" @close="closeModal">
            <div class="delete-user-form__modal">
                <h2 class="delete-user-form__title">Are you sure you want to delete your account?</h2>
                <p class="delete-user-form__description">Enter your password to confirm deletion.</p>

                <!-- Password Input Group -->
                <Input type="password" label="Password" />
                <Input type="field"
                    id="password"
                    input-type="password"
                    placeholder="Enter your Password"
                    v-model="form.password"
                    ref="passwordInput"
                    :error="form.errors.password"
                    @keyup.enter="deleteUser"
                />
                <!-- Error input -->
                <Input type="error" :message="form.errors.password" />

                <!-- Delete Account Actions -->
                <div class="delete-user-form__actions">
                    <Button label="Cancel" @click="closeModal" variant="secondary" />
                    <Button label="Delete Account" @click="deleteUser" :disabled="form.processing" />
                </div>
            </div>
        </Modal>
    </div>
</template>
