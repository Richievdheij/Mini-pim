<script>
import { useForm } from '@inertiajs/vue3';

export default {
    props: {
        permissions: Array,
    },
    setup(props) {
        const form = useForm({
            name: '',
            permissions: [],
        });

        function submitForm() {
            form.post(route('profiles.store'));
        }

        return {
            form,
            permissions: props.permissions,
            submitForm,
        };
    },
};
</script>
<template>
    <div class="create-profile">
        <h1>Create New Profile</h1>

        <!-- Profile Creation Form -->
        <form @submit.prevent="submitForm">
            <div class="form-group">
                <label for="name">Profile Name</label>
                <input type="text" v-model="form.name" id="name" required />
            </div>

            <div class="form-group">
                <label>Permissions</label>
                <div v-for="permission in permissions" :key="permission.id" class="checkbox">
                    <input type="checkbox" :value="permission.id" v-model="form.permissions">
                    <label>{{ permission.name }}</label>
                </div>
            </div>

            <button type="submit" class="button">Create Profile</button>
        </form>
    </div>
</template>



<style scoped>
.create-profile {
    padding: 1.5rem;
}
.form-group {
    margin-bottom: 1rem;
}
.button {
    padding: 0.5rem 1rem;
    background-color: #4CAF50;
    color: white;
    border: none;
    cursor: pointer;
}
.checkbox {
    margin-bottom: 0.5rem;
}
</style>
