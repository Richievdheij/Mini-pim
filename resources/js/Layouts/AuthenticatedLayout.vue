<script setup>
// import NavBar from '@/Components/Layout/NavBar.vue';
import Sidebar from '@/Components/Layout/Sidebar.vue';
</script>

<template>
    <div class="authenticated-layout">
        <header class="authenticated-layout__header">
            <!-- <NavBar /> -->
        </header>
        <aside class="authenticated-layout__sidebar">
             <Sidebar />
        </aside>
        <main class="authenticated-layout__content">
            <slot />
        </main>
    </div>
</template>
