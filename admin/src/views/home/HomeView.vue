<script setup>
import { ElButton, ElNotification } from 'element-plus'
import Table from '@/components/Table.vue'
import axios from 'axios'
import { onMounted, ref, reactive, watch } from 'vue'
import { Timer, Edit, Delete } from '@element-plus/icons-vue'
import { useRouter } from "vue-router";

const state = reactive({
    pairs: null,
})

onMounted(() => {
    axios.get("http://127.0.0.1:8000/api/pairs") 
        .then( response => state.pairs = response.data ) 
        .catch( error => console.log( 'error: ' + error ) ); 
})


const props = defineProps(['pairs'])
const router = useRouter()

const handleEdit = (index, row) => {
    router.push({ name: 'pairs/update', params: { id: row.id } })
}

const handleDelete = (index, row) => {
    axios.delete("http://127.0.0.1:8000/api/pairs/" + row.id)
            .then(response => {
                ElNotification({
                    title: 'Succès',
                    message: response.data.message,
                    type: 'success'
                })
            });
}

</script>

<template>
    <main v-if="state.pairs !== null">
        
        <el-button class="addPairBtn" type="primary" @click="router.push('pairs/create')">Ajouter une paire</el-button>

        <el-table :data="state.pairs.data" style="width: 100%; height: 85vh">

            <el-table-column label="ID" width="100">
                <template #default="scope">
                    <div style="display: flex; align-items: center">
                        <span style="margin-left: 10px">{{ scope.row.id }}</span>
                    </div>
                </template>
            </el-table-column>

            <el-table-column label="de" width="450">
                <template #default="scope">
                    <div style="display: flex; align-items: center">
                        <span style="margin-left: 10px">{{ scope.row.currency_from_id.symbol }} ({{ scope.row.currency_from_id.name }})</span>
                    </div>
                </template>
            </el-table-column>

            <el-table-column label="vers" width="450">
                <template #default="scope">
                    <div style="display: flex; align-items: center">
                        <span style="margin-left: 10px">{{ scope.row.currency_to_id.symbol }} ({{ scope.row.currency_to_id.name }})</span>
                    </div>
                </template>
            </el-table-column>

            <el-table-column label="taux" width="150">
                <template #default="scope">
                    <div style="display: flex; align-items: center">
                        <span style="margin-left: 10px">{{ scope.row.rate }}</span>
                    </div>
                </template>
            </el-table-column>

            <el-table-column label="Opérations" align="right">
                <template #default="scope">

                    <el-button size="small" type="warning" @click="handleEdit(scope.$index, scope.row)">
                        <el-icon>
                            <Edit />
                        </el-icon>
                    </el-button>
                    <el-button
                        size="small"
                        type="danger"
                        @click="handleDelete(scope.$index, scope.row)">
                            <el-icon>
                                <Delete />
                            </el-icon>
                    </el-button>
                </template>
            </el-table-column>
        </el-table>
    </main>
</template>

<style lang="scss" scoped>
    .addPairBtn {
        margin-bottom: 25px;
    }
</style>