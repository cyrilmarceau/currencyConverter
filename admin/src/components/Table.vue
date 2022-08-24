<template>

  <el-table :data="props.pairs.data" style="width: 100%; height: 85vh">

    <el-table-column label="ID" width="50">
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
</template>

<script setup>
import { Timer, Edit, Delete } from '@element-plus/icons-vue'
import {useRouter} from "vue-router";

const props = defineProps(['pairs'])
const router = useRouter()

const handleEdit = (index, row) => {
  // router.push({ name: 'users/user', params: { id: 123 } })
  console.log(index, row)
  
}
const handleDelete = (index, row) => {
  console.log(index, row)
}

// const tableData = [
//   {
//     date: '2016-05-03',
//     name: 'Tom',
//     address: 'No. 189, Grove St, Los Angeles',
//   },
//   {
//     date: '2016-05-02',
//     name: 'Tom',
//     address: 'No. 189, Grove St, Los Angeles',
//   },
//   {
//     date: '2016-05-04',
//     name: 'Tom',
//     address: 'No. 189, Grove St, Los Angeles',
//   },
//   {
//     date: '2016-05-01',
//     name: 'Tom',
//     address: 'No. 189, Grove St, Los Angeles',
//   },
// ]
</script>