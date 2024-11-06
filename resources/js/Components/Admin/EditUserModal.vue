<script setup>
import { useForm, usePage } from '@inertiajs/vue3';
import { watch } from 'vue';
import Button from '@/Components/General/Button.vue'; // Import the custom button component

// Define props to accept `user`, `roles`, `isOpen`, and handle the modal close event
const props = defineProps({
    user: Object,
    roles: Array,
    isOpen: Boolean,
});
const emit = defineEmits(['close']);

// Initialize the form with the user's data and roles
const form = useForm({
    name: props.user ? props.user.name : '',
    email: props.user ? props.user.email : '',
    password: '',
    roles: props.user ? props.user.roles.map(role => role.id) : [], // Map user roles to their IDs
});

// Watch for changes in the `user` prop to update form data when the modal opens
watch(
    () => props.user,
    (newUser) => {
        if (newUser) {
            form.name = newUser.name;
            form.email = newUser.email;
            form.roles = newUser.roles.map(role => role.id);
        }
    },
    { immediate: true }
);

// Close modal function
function closeModal() {
    emit('close');
}

// Submit function to handle form submission
function submit() {
    form.put(`/users/${props.user.id}`, {
        onSuccess: () => {
            closeModal(); // Close the modal on successful form submission
        },
    });
}
</script>

<template>
    <div v-if="isOpen" class="modal-overlay">
        <div class="modal-content">
            <h2 class="modal-title">Edit User</h2>
            <form @submit.prevent="submit">
                <div class="form-group">
                    <label for="name">Name:</label>
                    <input type="text" v-model="form.name" class="form-input"/>
                </div>

                <div class="form-group">
                    <label for="email">Email:</label>
                    <input type="email" v-model="form.email" class="form-input"/>
                </div>

                <div class="form-group">
                    <label for="password">Password (Leave blank to keep current):</label>
                    <input type="password" v-model="form.password" class="form-input"/>
                </div>

                <div class="form-group">
                    <label for="roles">Assign Roles:</label>
                    <select v-model="form.roles" multiple class="form-input">
                        <option v-for="role in roles" :value="role.id" :key="role.id">
                            {{ role.name }}
                        </option>
                    </select>
                </div>

                <div class="modal-actions">
                    <Button label="Update" type="submit" class="bg-green-500 text-white px-4 py-2 rounded"/>
                    <Button label="Cancel" type="button" @click="closeModal"
                            class="bg-gray-500 text-white px-4 py-2 rounded ml-2"/>
                </div>
            </form>
        </div>
    </div>
</template>

<style scoped>
.modal-overlay {
    position: fixed;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    background-color: rgba(0, 0, 0, 0.5);
    display: flex;
    align-items: center;
    justify-content: center;
}

.modal-content {
    background: white;
    padding: 2rem;
    border-radius: 0.5rem;
    max-width: 500px;
    width: 100%;
}

.modal-title {
    font-size: 1.5rem;
    font-weight: bold;
    margin-bottom: 1rem;
}

.form-group {
    margin-bottom: 1rem;
}

.form-input {
    width: 100%;
    padding: 0.5rem;
    border: 1px solid #ccc;
    border-radius: 0.25rem;
}

.modal-actions {
    margin-top: 1rem;
    display: flex;
    justify-content: flex-end;
}
</style>
