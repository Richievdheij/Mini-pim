<script setup>
import { Link } from '@inertiajs/vue3';
</script>

<template>
    <footer class="guest-layout__footer">
        <div class="guest-layout__footer-content">
            <!-- Footer logo section -->
            <div class="guest-layout__footer-logo">
                <img src="/images/pim/mini-pim-logo.png" alt="Mini-Pim Logo" />
            </div>

            <!-- Footer links section -->
            <footer class="guest-layout__footer-links">
                <Link href="#" class="guest-layout__footer-link">Privacy Policy</Link>
                <span class="guest-layout__footer-separator">|</span>
                <Link href="#" class="guest-layout__footer-link">Cookies</Link>
                <span class="guest-layout__footer-separator">|</span>
                <Link href="#" class="guest-layout__footer-link">Terms and conditions</Link>
                <span class="guest-layout__footer-separator">|</span>
                <Link href="#" class="guest-layout__footer-link">Contact</Link>
            </footer>
        </div>
    </footer>
</template>
