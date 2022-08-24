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

const confirmEvent = () => {
  console.log('confirm!')
}
const cancelEvent = () => {
  console.log('cancel!')
}

</script>