<script setup>
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import {Head} from "@inertiajs/vue3";
</script>

<template>
    <AuthenticatedLayout>
        <Head title="Mini-pim | PIM Dashboard" />

        <div class="pim-dashboard">
            <main class="pim-dashboard__content">
                <h1>PIM Dashboard</h1>
                <!-- PIM dashboard content goes here -->
            </main>
        </div>
    </AuthenticatedLayout>
</template>



