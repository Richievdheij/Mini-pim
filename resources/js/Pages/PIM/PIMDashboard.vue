<script setup>
import PIMLayout from '@/Layouts/PIMLayout.vue';
import { Head } from '@inertiajs/vue3';

</script>

<template>
    <PIMLayout>
        <Head title="Mini-pim | PIM Dashboard" />

        <div class="dashboard">

            <!-- Main content area for dashboard on the right -->
            <main class="dashboard__content">
                <h2 class="dashboard__header">PIM Dashboard</h2>

                <!-- Buttons inside the dashboard content area -->
                <div class="dashboard__main-content">
                    <h1 class="dashboard__welcome">Welcome to the PIM Dashboard!</h1>
                    <p class="dashboard__user-info">
                        lorem ipsum dolor sit amet
                    </p>
                </div>
            </main>
        </div>
    </PIMLayout>
</template>
