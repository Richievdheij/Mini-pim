<script setup>
// Optional: Add any props or logic if needed
</script>

<template>
  <nav class="navbar">
    <!-- Left side: Icon + Title -->
    <div class="navbar__left">
      <i class="fas fa-pen-to-square navbar__icon"></i>
      <h1 class="navbar__title">BLOG.</h1>
    </div>

    <!-- Right side: Menu and profile picture -->
    <div class="navbar__right">
      <ul class="navbar__menu">
        <li><a href="#" class="navbar__menu--link">Home</a></li>
        <li><a href="#" class="navbar__menu--link">Ontdek</a></li>
        <li><a href="#" class="navbar__menu--link">Volgend</a></li>
        <li><a href="#" class="navbar__menu--link">Categorieën</a></li>
        <li><a href="#" class="navbar__menu--link">Top posts</a></li>
      </ul>
      <div class="navbar__profile">
        <img src="/images/blog/profilePicture.jpg" alt="Profile Picture" class="navbar__profile-image" />
      </div>
    </div>
  </nav>
</template>