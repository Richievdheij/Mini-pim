<script setup>
import { Link } from '@inertiajs/vue3';
</script>

<template>
    <header class="authenticated-layout__header">
        <div class="authenticated-layout__header-content">
            <div class="authenticated-layout__header-logo">
                <img src="/images/pim/mini-pim-logo.png" alt="Mini-Pim Logo" />
            </div>
            <nav class="authenticated-layout__header-links">
<!--                <Link href="#" class="authenticated-layout__header-link">Button1</Link>-->
                <span class="authenticated-layout__header-separator">|</span>
<!--                <Link href="#" class="authenticated-layout__header-link">Button2</Link>-->
                <span class="authenticated-layout__header-separator">|</span>
<!--                <Link href="#" class="authenticated-layout__header-link">Button3</Link>-->
            </nav>
        </div>
    </header>
</template>
