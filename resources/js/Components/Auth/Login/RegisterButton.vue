<script setup>
import { Link } from '@inertiajs/vue3';
</script>

<template>
    <div class="register-link">
      <Link
          :href="route('register')"
          class="register-link__link">
          Don't have an account yet?
      </Link>
    </div>
</template>
