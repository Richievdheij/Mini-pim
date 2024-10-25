<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head, usePage } from '@inertiajs/vue3';
import { useForm } from '@inertiajs/vue3';
import DropdownLink from '@/Components/laravelWelcome/DropdownLink.vue';

// Get the user and roles from Inertia's props
const { props } = usePage();
const user = props.user;
const roles = props.roles;

// Use form for logout functionality
const form = useForm({});

// Logout function
function logout() {
    console.log('Logout clicked');
    form.post(route('logout'));
}

// Check if the user has the 'admin' role
const hasAdminRole = roles.some(role => role.name === 'admin');
</script>

<template>
    <Head title="Dashboard" />

    <AuthenticatedLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">Dashboard</h2>
        </template>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 text-gray-900">
                        <h1>Welcome to the Dashboard!</h1>
                        <p>You are logged in as: <strong>{{ user.name }}</strong></p>

                        <h2>Your Roles:</h2>
                        <ul>
                            <li v-for="role in roles" :key="role.id">{{ role.name }}</li>
                        </ul>

                        <!-- Conditionally show admin dashboard link -->
                        <div v-if="hasAdminRole">
                            <p>You have access to the Admin Dashboard!</p>
                            <inertia-link href="/admin/dashboard">Go to Admin Dashboard</inertia-link>
                        </div>

                        <div v-else>
                            <p>You do not have access to the Admin Dashboard.</p>
                        </div>

                        <!-- Logout Button -->
                        <DropdownLink :href="route('logout')" method="post" as="button" class="dashboard-buttons__button">
                            Log Out
                        </DropdownLink>
                    </div>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>
