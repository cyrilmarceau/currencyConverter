<template>
  <el-page-header title="retour" @back="goBack" :icon="ArrowLeft" :content="route.toto"></el-page-header>
</template>

<script setup>
import { ref, computed } from 'vue'
import { useRoute, useRouter } from 'vue-router'
import { ArrowLeft } from '@element-plus/icons-vue'
import { onMounted, reactive } from 'vue'

const route = useRoute();
const router = useRouter();

const goBack = () => router.back();

</script>

<style lang="scss">
.el-page-header {
    display: flex;
    align-items: center;
    &__left {
        align-items: center;
    }
}
</style>