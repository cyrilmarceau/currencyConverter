<template>
    <el-popconfirm
        confirm-button-text="Oui"
        cancel-button-text="Non"
        title="Etes-vous sur de vouloir vous deconnecter ?"
        @confirm="confirmEvent"
        @cancel="cancelEvent"
    >
        <template #reference>
            <el-button type="danger" :icon="User">Se deconnecter</el-button>
        </template>
    </el-popconfirm>
</template>


<script setup>
import { User} from '@element-plus/icons-vue'
import { useRouter } from 'vue-router'

const router = useRouter()

const confirmEvent = () => {
    localStorage.removeItem('token')
    router.push('/login')
}
const cancelEvent = () => {
    return false
}

</script>