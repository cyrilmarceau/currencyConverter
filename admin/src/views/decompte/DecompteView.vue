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
    axios.get("http://127.0.0.1:8000/api/decompte") 
        .then( response => state.pairs = response.data ) 
        .catch( error => console.log( 'error: ' + error ) ); 
})
</script>

<template>
    <main v-if="state.pairs !== null">
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

            <el-table-column label="Nombre total de convertion" width="900">
                <template #default="scope">
                    <div style="display: flex; align-items: center">
                        <span style="margin-left: 10px">{{ scope.row.convertion.count }}</span>
                    </div>
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