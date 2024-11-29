<script setup>
import Footer from '@/Components/Layout/Footer.vue';
</script>

<template>
    <div class="guest-layout">
        <main class="guest-layout__content">
            <slot />
        </main>
        <div class="guest-layout__footer">
            <Footer />
        </div>
    </div>
</template>
