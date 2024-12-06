<script setup>
import PIMLayout from "@/Layouts/PIMLayout.vue";
import { Head } from "@inertiajs/vue3";
</script>

<template>
    <PIMLayout>
        <Head title="Mini-pim | PIM Dashboard" />

        <div class="pim-dashboard">
            <main class="pim-dashboard__content">
                <h1>PIM</h1>
                <slot />
            </main>
        </div>
    </PIMLayout>
</template>



