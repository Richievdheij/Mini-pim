<script setup>
// import NavBar from '@/Components/Layout/NavBar.vue';
import PimSidebar from '@/Components/Layout/PIM/PimSidebar.vue';
</script>

<template>
    <div class="pim-layout">
        <header class="pim-layout__header">
            <!-- <NavBar />-->
        </header>
        <aside class="pim-layout__sidebar">
            <PimSidebar />
        </aside>
        <main class="pim-layout__content">
            <slot />
        </main>
    </div>
</template>
