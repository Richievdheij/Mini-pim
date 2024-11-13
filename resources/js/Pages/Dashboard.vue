<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head, usePage } from '@inertiajs/vue3';
import { useForm } from '@inertiajs/vue3';
import DropdownLink from '@/Components/laravelWelcome/DropdownLink.vue';

// Haal de `user` op uit de props van Inertia
const { props } = usePage();
const user = props.user || { name: "Guest" }; // Standaardwaarde voor user

// Gebruik een formulier voor de logout functionaliteit
const form = useForm({});

// Logout functie
function logout() {
    console.log('Logout clicked');
    form.post(route('logout'));
}

// Controleer of de gebruiker de 'manage_permissions' permissie heeft
const hasAdminAccess = user.permissions && user.permissions.includes('manage_permissions');
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

                        <!-- Voorwaardelijke weergave voor Admin-toegang -->
                        <div v-if="hasAdminAccess">
                            <p>You have access to the Admin Dashboard!</p>
                            <inertia-link href="/admin/dashboard">Go to Admin Dashboard</inertia-link>
                        </div>

                        <div v-else>
                            <p>You do not have access to the Admin Dashboard.</p>
                        </div>

                        <!-- Logout knop -->
                        <DropdownLink :href="route('logout')" method="post" as="button" class="dashboard-buttons__button">
                            Log Out
                        </DropdownLink>
                    </div>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>
