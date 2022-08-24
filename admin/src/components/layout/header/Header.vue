<template>
  <div class="header">
      <Back />
      <Logout />
  </div>
</template>


<script setup>
import Back from "@/components/layout/header/Back.vue"
import Logout from "@/components/layout/header/Logout.vue"
</script>

<style lang="scss">
  .header {
    display: flex;
    justify-content: space-between;
    padding: 25px 0;
  }
</style>