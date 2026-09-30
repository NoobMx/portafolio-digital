<template>
  <div id="app">
    <router-view></router-view>
  </div>
</template>

<script>
import Login from './components/Login.vue'

export default {
  name: 'App',
}
</script>

<style>
body {
  background-color: #f8f9fa;
}
</style>