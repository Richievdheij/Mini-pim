<script setup>
import { useForm } from '@inertiajs/vue3';
import { usePage } from '@inertiajs/vue3';

const { attribute } = usePage().props;

const form = useForm({
    value: '',
    attribute_id: attribute.id,
});

function submit() {
    form.post(route('attribute-values.store', attribute.id));
}
</script>
<template>
    <div>
        <h1>Create Value for {{ attribute.name }}</h1>
        <form @submit.prevent="submit">
            <label>
                Value:
                <input v-model="form.value" type="text" required />
            </label>
            <button type="submit">Save</button>
        </form>
    </div>
</template>


