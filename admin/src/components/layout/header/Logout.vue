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
import { ElNotification } from 'element-plus'
import { useRouter } from 'vue-router'
import axios from 'axios'

const router = useRouter()

const confirmEvent = () => {
    axios.post("http://127.0.0.1:8000/api/logout/")
            .then(response => {
                if(response.data.success) {
                    localStorage.removeItem('token')

                    ElNotification({
                        title: 'Succès',
                        message: response.data.message,
                        type: 'success',
                        onClose: () => router.push('/login'),
                        duration: 1500
                    })
                }
            }).catch(err => console.log(err));

    
}
const cancelEvent = () => {
    return false
}

</script>