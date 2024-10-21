<script setup>
import NavBar from '@/Components/Layout/NavBar.vue';
</script>

<template>
    <NavBar/>
    <main class="min-h-screen flex flex-col sm:justify-center items-center pt-6 sm:pt-0 bg-gray-100">
        
        <slot name="content"></slot>
    </main>
    <footer>
        <slot name="footer"></slot>
    </footer>
</template>

