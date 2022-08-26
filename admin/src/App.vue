<template>
    <div v-if="state.isAuthenticated" class="common-layout">
            <el-container>
                    <el-aside><MenuL /></el-aside>
                    <el-container>
                        <el-header><Header /></el-header>
                        <el-main>
                            <el-row :gutter="20">
                                <el-col :span="24">
                                    <div class="grid-content ep-bg-purple">
                                        <RouterView />
                                    </div>
                                        
                                </el-col>
                            </el-row>
                        </el-main>
                    </el-container>
            </el-container>
    </div>
    <div v-else>
        <RouterView />
    </div>
</template>

<script setup>
import { RouterView } from "vue-router";
import MenuL from '@/components/layout/aside/MenuL.vue';
import Header from '@/components/layout/header/Header.vue';
import { useRouter } from 'vue-router'
import { onMounted, reactive, watch } from 'vue'

const router = useRouter()

const state = reactive({
    isAuthenticated: false,
})

const authRedirect = () => {
    const token = localStorage.getItem('token')

    if (token !== null) {
        state.isAuthenticated = true
    } else {
        router.push('/login')
    }
}


onMounted(() => {
    authRedirect();
})

watch(() => state, (isAuthenticated, oldIsAuthenticated) => {
    console.log(`isAuthenticated is: ${isAuthenticated}`)
  }
)



</script>

<style lang="scss">
    body {
        margin: 0;
    }

    .el-aside {
        height: 100vh;
        width: auto !important;
    }
</style>