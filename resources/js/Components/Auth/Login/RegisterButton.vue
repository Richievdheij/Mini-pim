<script setup>
import { Link } from '@inertiajs/vue3';
</script>

<template>
    <div class="register-link">
      <Link :href="route('register')" class="register-link__link">Nog geen account?</Link>
    </div>
</template>