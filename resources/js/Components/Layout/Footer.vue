<script setup>
import { Link } from '@inertiajs/vue3';
</script>

<template>
    <footer class="guest-layout__footer">
        <div class="guest-layout__footer-content">
            <div class="guest-layout__footer-logo">
                <img src="/images/pim/mini-pim-logo.png" alt="Mini-Pim Logo" />
            </div>
            <footer class="guest-layout__footer-links">
                <Link href="#" class="guest-layout__footer-link">Privacybeleid</Link>
                <span class="guest-layout__footer-separator">|</span>
                <Link href="#" class="guest-layout__footer-link">Cookieverklaring</Link>
                <span class="guest-layout__footer-separator">|</span>
                <Link href="#" class="guest-layout__footer-link">Algemene voorwaarden</Link>
                <span class="guest-layout__footer-separator">|</span>
                <Link href="#" class="guest-layout__footer-link">Contact</Link>
            </footer>
        </div>
    </footer>
</template>
