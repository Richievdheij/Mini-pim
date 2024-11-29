<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head, usePage } from '@inertiajs/vue3';

// Get the user and roles from Inertia's props
const { props } = usePage();
const user = props.user;

</script>

<template>
    <AuthenticatedLayout>
        <Head title="Mini-pim | Dashboard" />

        <div class="dashboard">

            <!-- Main content area for dashboard on the right -->
            <div class="dashboard__content">
                <h2 class="dashboard__header">Dashboard</h2>

                <!-- Buttons inside the dashboard content area -->
                <div class="dashboard__main-content">
                    <h1 class="dashboard__welcome">Welcome to the Dashboard!</h1>
                    <p class="dashboard__user-info">
                        You are logged in as: <strong>{{ user.name }}</strong>
                    </p>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>
