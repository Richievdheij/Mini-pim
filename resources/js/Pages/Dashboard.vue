<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import DropdownLink from '@/Components/laravelWelcome/DropdownLink.vue';
import { Head, usePage } from '@inertiajs/vue3';
import { useForm } from '@inertiajs/vue3';

// Get the user and roles from Inertia's props
const { props } = usePage();
const user = props.user;
const roles = props.roles;

// Use form for logout functionality
const form = useForm({});

// Logout function
function logout() {
    form.post(route('logout'));
}

// Check if the user has the 'admin' role
const hasAdminRole = roles.some(role => role.name === 'admin');
</script>

<template>
    <AuthenticatedLayout>
        <Head title="Mini-pim | Dashboard" />

        <div class="dashboard">

            <!-- Main content area for dashboard on the right -->
            <div class="dashboard__content">
                <h2 class="dashboard__header">Dashboard</h2>

                <!-- Buttons inside the dashboard content area -->
                <div class="dashboard__buttons">
                    <DropdownLink :href="route('logout')" method="post" as="button" class="dashboard__buttons--button">
                        Log Out
                    </DropdownLink>
                    <DropdownLink :href="route('profile.edit')" class="dashboard__buttons--button">
                        Profile
                    </DropdownLink>
                </div>

                <div class="dashboard__main-content">
                    <h1 class="dashboard__welcome">Welcome to the Dashboard!</h1>
                    <p class="dashboard__user-info">
                        You are logged in as: <strong>{{ user.name }}</strong>
                    </p>

                    <h2 class="dashboard__roles-title">Your Roles:</h2>
                    <ul class="dashboard__roles-list">
                        <li v-for="role in roles" :key="role.id" class="dashboard__role-item">
                            {{ role.name }}
                        </li>
                    </ul>

                    <!-- Conditionally show admin dashboard link -->
                    <div v-if="hasAdminRole" class="dashboard__admin-access">
                        <p>You have access to the Admin Dashboard!</p>
                        <button href="/admin/dashboard" class="dashboard__admin-link">Go to Admin Dashboard
                        </button>
                    </div>

                    <div v-else class="dashboard__no-access">
                        <p>You do not have access to the Admin Dashboard.</p>
                    </div>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>
