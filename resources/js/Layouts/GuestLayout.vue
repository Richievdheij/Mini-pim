<script setup>
import { onMounted } from 'vue';
import Footer from '@/Components/Layout/Footer.vue';

onMounted(() => {
    const existingScript = document.getElementById('CookieDeclaration');
    if (!existingScript) {
        const script = document.createElement('script');
        script.id = 'CookieDeclaration';
        script.src = 'https://consent.cookiebot.com/eb5a8a84-458d-49ac-ba40-eee70b46fe14/cd.js';
        script.type = 'text/javascript';
        script.async = true;
        document.body.appendChild(script);
    }
});
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
