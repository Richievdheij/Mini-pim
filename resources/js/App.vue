<template>
    <router-link to="/" exact>home</router-link>
    <router-link to="/about">about</router-link>
    <router-view></router-view>
</template>

<script>
export default {
    name: "app"
}
</script>
