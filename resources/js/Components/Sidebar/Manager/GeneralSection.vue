<script setup>
import { defineProps, defineEmits } from 'vue';
import { Link } from '@inertiajs/vue3';

const props = defineProps(['isGeneralExpanded', 'isSidebarExpanded']);
const emit = defineEmits(['toggle-section']);
</script>

<template>
  <div class="sidebar-general-section">

    <h3 class="sidebar-general-section__title" @click="$emit('toggle-section', 'general')" :class="{ 'sidebar-general-section__title--disabled': !isSidebarExpanded }">
      <span class="sidebar-general-section-title">General</span>
      <i class="sidebar-general-section__chevron fas"
         :class="isGeneralExpanded ? 'fa-chevron-down' : 'fa-chevron-right'">
      </i>
    </h3>

    <div class="sidebar-general-section__button-container" v-show="isGeneralExpanded">
      <Link class="sidebar-general-section__button"
          :href="route('users.index')"
      >
          <div class="sidebar-general-section__icon-container">
              <i class="sidebar-general-section__icon fas fa-users"></i>
          </div>
          <span>Users</span>
      </Link>
      <Link class="sidebar-general-section__button"
          :href="route('profiles.index')"
      >
          <div class="sidebar-general-section__icon-container">
              <i class="sidebar-general-section__icon fas fa-user-circle"></i>
          </div>
          <span>Profiles</span>
      </Link>
      <Link class="sidebar-general-section__button"
          :href="route('user-rights.index')"
      >
          <div class="sidebar-general-section__icon-container">
              <i class="sidebar-general-section__icon fas fa-user-shield"></i>
          </div>
          <span>User rights</span>
      </Link>
    </div>
  </div>
</template>
