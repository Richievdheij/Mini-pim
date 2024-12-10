<script setup>
import { useForm } from '@inertiajs/vue3';
import { defineProps, defineEmits } from 'vue';

const props = defineProps({
    attribute: Object,
    types: Array,
});

const emit = defineEmits(['close']);

const form = useForm({
    name: props.attribute?.name || '',
    type_id: props.attribute?.type_id || '',
});

function closeModal() {
    emit('close');
    form.reset();
    form.clearErrors();
}

function submit() {
    form.put(route('attributes.update', props.attribute.id), {
        onSuccess: () => {
            emit('close');
        },
        onError: (errors) => {
            console.error(errors); // Debug errors
        },
    });
}
</script>

<template>
    <div class="modal">
        <div class="modal-content">
            <h2>Edit Attribute</h2>
            <form @submit.prevent="submit">
                <label>
                    Name:
                    <input v-model="form.name" type="text" required />
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
                    <button type="submit">Update</button>
                    <button type="button" @click="closeModal">Cancel</button>
                </div>
            </form>
        </div>
    </div>
</template>
