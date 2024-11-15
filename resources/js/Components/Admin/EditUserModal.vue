<script setup>
import { useForm } from '@inertiajs/vue3';
import { watch } from 'vue';
import Input from '@/Components/General/Input.vue';
import SecondaryButton from '@/Components/General/SecondaryButton.vue';
import TertiaryButton from "@/Components/General/TertiaryButton.vue";

// Props and emits
const props = defineProps({
    user: Object,
    profiles: Array,
    isOpen: Boolean,
});
const emit = defineEmits(['close']);

// Form setup
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
            form.password = '';
            form.profiles = props.user.profiles.map(profile => profile.id);
        }
    }
);

// Close modal function
function closeModal() {
    emit('close');
    form.reset();
}

// Submit function to handle form submission
function submit() {
    form.put(`/users/${props.user.id}`, {
        onSuccess: () => {
            closeModal();
        },
    });
}
</script>

<template>
    <div v-if="isOpen" class="modal">
        <div class="modal__content">
            <h2 class="modal__title">Edit User</h2>
            <form @submit.prevent="submit" class="modal__form">
                <Input
                    label="Name"
                    inputType="text"
                    placeholder="Enter user name"
                    type="field"
                    v-model="form.name"
                    :error="form.errors.name"
                />
                <Input
                    label="Email"
                    inputType="email"
                    placeholder="Enter email address"
                    type="field"
                    v-model="form.email"
                    :error="form.errors.email"
                />
                <Input
                    label="Password"
                    inputType="password"
                    placeholder="Leave blank to keep current password"
                    type="field"
                    v-model="form.password"
                    :error="form.errors.password"
                />
                <!-- Assign Profiles Select Input -->
                <Input
                    label="Assign Profiles"
                    inputType="select"
                    type="select"
                    v-model="form.profiles"
                    :options="profiles"
                    :error="form.errors.profiles"
                    multiple
                />
                <div class="modal__actions">
                    <TertiaryButton
                        label="Cancel"
                        type="cancel"
                        @click="closeModal"
                    />
                    <SecondaryButton
                        label="Update"
                        type="submit"
                    />
                </div>
            </form>
        </div>
    </div>
</template>
