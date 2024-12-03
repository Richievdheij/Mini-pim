<script setup>
import { useForm } from '@inertiajs/vue3';
import { usePage } from '@inertiajs/vue3';
import { defineEmits } from 'vue';

const emit = defineEmits(['close']);
const { types } = usePage().props;

const form = useForm({
    name: '',
    type_id: '',
});

function submit() {
    form.post(route('attributes.store'), {
        onSuccess: () => {
            emit('close'); // Close modal on successful submission
            form.reset(); // Reset the form fields
        },
        onError: (errors) => {
            console.error(errors); // Debugging errors
        },
    });
}

function closeModal() {
    emit('close');
}
</script>

<template>
    <div class="modal">
        <div class="modal-content">
            <h2>Create Attribute</h2>
            <form @submit.prevent="submit">
                <label>
                    Name:
                    <input v-model="form.name" type="text" required placeholder="Enter attribute name"/>
                </label>
                <label>
                    Type:
                    <select v-model="form.type_id" required>
                        <option disabled value="">Select Type</option>
                        <option v-for="type in types" :value="type.id" :key="type.id">
                            {{ type.name }}
                        </option>
                    </select>
                </label>
                <div class="modal-actions">
                    <button type="submit">Save</button>
                    <button type="button" @click="closeModal">Cancel</button>
                </div>
            </form>
        </div>
    </div>
</template>

<style scoped>
.modal {
    position: fixed;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    background: rgba(0, 0, 0, 0.5);
    display: flex;
    justify-content: center;
    align-items: center;
}

.modal-content {
    background: white;
    padding: 1.5rem;
    border-radius: 0.5rem;
    width: 30rem;
}

.modal-actions {
    margin-top: 1rem;
    display: flex;
    justify-content: flex-end;
    gap: 0.5rem;
}

button {
    padding: 0.5rem 1rem;
    border: none;
    border-radius: 0.25rem;
    cursor: pointer;
}

button:hover {
    opacity: 0.9;
}
</style>
