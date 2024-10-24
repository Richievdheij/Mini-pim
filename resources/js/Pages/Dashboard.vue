<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head } from '@inertiajs/vue3';
import { useForm } from '@inertiajs/vue3';
import axios from 'axios';
import DropdownLink from '@/Components/laravelWelcome/DropdownLink.vue';


const form = useForm({});

function logout() {
    console.log('Logout clicked'); // Logging the click on logout button
    form.post(route('logout'));
}
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
                        You're logged in!
                        <!-- Loguit knop -->
                        <DropdownLink :href="route('logout')" method="post" as="button" class="dashboard-buttons__button">
                            Log Out
                        </DropdownLink>
                    </div>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>
