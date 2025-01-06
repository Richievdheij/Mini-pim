<script setup>
import { Link } from '@inertiajs/vue3';
</script>

<template>
  <div class="forgot-password">
    <i class="forgot-password__icon fas fa-lock"></i>
        <Link
            :href="route('password.request')"
            class="forgot-password__link">
            Forgot password?
        </Link>
  </div>
</template>
