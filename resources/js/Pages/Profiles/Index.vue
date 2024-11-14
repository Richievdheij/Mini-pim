<script setup>
import { ref } from 'vue';
import { Link, router } from '@inertiajs/vue3';
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";

defineProps({ profiles: Array });

function deleteProfile(profileId) {
    if (confirm('Are you sure you want to delete this profile?')) {
        // Use the router.delete method to call the delete route
        router.delete(route('profiles.destroy', profileId), {
            onSuccess: () => {
                alert('Profile deleted successfully');
            },
            onError: (errors) => {
                console.error('Failed to delete profile:', errors);
            }
        });
    }
}
</script>

<template>
    <AuthenticatedLayout>
    <div class="manage-profiles">
        <h1>Manage Profiles</h1>

        <!-- Button to navigate to the profile creation page -->
        <div class="create-profile-button">
            <Link :href="route('profiles.create')" class="button">Create New Profile</Link>
        </div>

        <!-- Profiles Table -->
        <table class="profiles-table">
            <thead>
            <tr>
                <th>Profile Name</th>
                <th>Actions</th>
            </tr>
            </thead>
            <tbody>
            <tr v-for="profile in profiles" :key="profile.id">
                <td>{{ profile.name }}</td>
                <td>
                    <!-- Edit Button -->
                    <Link :href="route('profiles.edit', profile.id)" class="button edit">Edit</Link>

                    <!-- Delete Button -->
                    <button @click="deleteProfile(profile.id)" class="button delete">Delete</button>
                </td>
            </tr>
            </tbody>
        </table>
    </div>
    </AuthenticatedLayout>
</template>

<style scoped>
.manage-profiles {
    padding: 1.5rem;
}

.create-profile-button {
    margin-bottom: 1rem;
}

.button {
    padding: 0.5rem 1rem;
    border-radius: 0.25rem;
    border: none;
    color: black;
    cursor: pointer;
    margin-right: 0.5rem;
    text-decoration: none;
}

.edit {
    background-color: #4CAF50;
}

.delete {
    background-color: #f44336;
}

.profiles-table {
    width: 100%;
    border-collapse: collapse;
}

.profiles-table th, .profiles-table td {
    padding: 0.75rem;
    border: 1px solid #ddd;
    text-align: left;
}

.profiles-table th {
    background-color: #f4f4f4;
}
</style>
