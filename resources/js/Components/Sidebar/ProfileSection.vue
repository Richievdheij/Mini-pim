<script setup>
import { defineProps } from 'vue';

const props = defineProps({
    isSidebarExpanded: Boolean,

});
</script>

<template>
  <div class="sidebar-profile-section">
    <div class="sidebar-profile-section__divider"></div>
    <div class="sidebar-profile-section__content">
      <div class="sidebar-profile-section__icon-container">
        <i class="fas fa-user sidebar-profile-section__icon"></i>
      </div>
      <div class="sidebar-profile-section__info">
        <span class="sidebar-profile-section__name">test</span>
        <span class="sidebar-profile-section__rank">test</span>
      </div>
    </div>
  </div>
</template>
