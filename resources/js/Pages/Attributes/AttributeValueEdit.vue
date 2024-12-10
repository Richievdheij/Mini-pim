<script setup>
import { useForm } from '@inertiajs/vue3';
import { usePage } from '@inertiajs/vue3';

const { value, attribute } = usePage().props;

const form = useForm({
    value: value.value,
});

function submit() {
    form.put(route('attribute-values.update', value.id));
}
</script>
<template>
    <div>
        <h1>Edit Value for {{ attribute.name }}</h1>
        <form @submit.prevent="submit">
            <label>
                Value:
                <input v-model="form.value" type="text" required />
            </label>
            <button type="submit">Update</button>
        </form>
    </div>
</template>


