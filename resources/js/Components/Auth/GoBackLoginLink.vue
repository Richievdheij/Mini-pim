<script setup>
import { Link } from '@inertiajs/vue3';
</script>

<template>
    <div class="forgot-password">
        <i class="forgot-password__icon fas fa-angles-left"></i>
        <Link :href="route('login')" class="forgot-password__link">Terug naar login pagina</Link>
    </div>
</template>
