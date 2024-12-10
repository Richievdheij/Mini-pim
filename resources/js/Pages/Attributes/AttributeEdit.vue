<script setup>
import { ref } from 'vue';
import { useForm } from '@inertiajs/vue3';

const form = useForm({
    name: $page.props.attribute.name,
    type_id: $page.props.attribute.type_id,
});

const types = $page.props.types;

function updateAttribute() {
    form.put(route('attributes.update', $page.props.attribute.id));
}
</script>
<template>
    <div>
        <h1>Edit Attribute</h1>
        <form @submit.prevent="updateAttribute">
            <div>
                <label for="name">Name</label>
                <input type="text" v-model="form.name" />
            </div>
            <div>
                <label for="type_id">Type</label>
                <select v-model="form.type_id">
                    <option v-for="type in types" :key="type.id" :value="type.id">{{ type.name }}</option>
                </select>
            </div>
            <button type="submit">Update</button>
            <Link :href="route('attributes.index')">Cancel</Link>
        </form>
    </div>
</template>


