<template>
    <el-form
        ref="ruleFormRef"
        :model="state"
        status-icon
        :rules="rules"
        label-width="120px"
        class="demo-state"
        label-position="top"
    >
        <el-row :gutter="20">
            <el-col :span="24">
                <div class="grid-content">
                   <el-form-item label="Sélectionner une paire de devise" prop="pair">
                        <el-select v-model="state.pair" placeholder="Votre paire">
                            <el-option v-for="(item, index) in state.options" :label="item.from.symbol + ' (' + item.from.name + ') ' +' --> ' + item.to.symbol + ' (' + item.to.name + ')'" :value="item.pairId" />
                        </el-select>
                    </el-form-item>
                </div>
            </el-col>
        </el-row>

        <el-row :gutter="20">
            <el-col :span="12">
                <div class="grid-content" >
                     <el-form-item label="Prix" prop="price">
                        <el-input-number style="width: 100%" v-model="state.price" />
                    </el-form-item>
                </div>
            </el-col>
        </el-row>

        <el-form-item>
            <el-button type="primary" @click="submitForm(ruleFormRef)">Calculer</el-button>
        </el-form-item>
    </el-form>

    <el-row v-if="state.convertionResult.success === true" :gutter="20">
        <el-col :span="12">
            <div class="grid-content" >
                    <el-result
                        icon="success"
                        :title="convertionResult.data.message"
                    >
                        <template #extra>
                        <el-button type="primary">Back</el-button>
                        </template>
                    </el-result>
            </div>
        </el-col>
    </el-row>


</template>

<style lang="scss" scoped>
    .el-select{
        width: 50%
    }
</style>

<script setup>
import { reactive, ref, onMounted, watch } from 'vue'
import axios from 'axios'

const ruleFormRef = ref()

const state = reactive({
    pair: '',
    price: 0,
    options: [],
    isReverse: false,
    convertionResult: {}
})

const rules = reactive({
    pair: [{
        required: true,
        message: 'Sélectionner une option',
        trigger: 'change',
    }],
    price: [{ trigger: 'blur', required: true }]
})

watch(() => state.convertionResult,(convertionResult, prevConvertionResult) => {
    console.log('convertionResult', convertionResult)
  }
)

onMounted(() => {
    axios.get("http://127.0.0.1:8000/api/pairs") 
        .then( response => {
            if(response.data.success) {
                const { data } = response.data;

                data.forEach(el => {
                    let opt = {}
                    opt.from = el.currency_from_id
                    opt.to = el.currency_to_id
                    opt.pairId = el.id

                    state.options.push(opt);
                });
                
            } 
        })
        .catch( error => console.log( 'error: ' + error ) ); 
})

const submitForm = (formEl) => {
  if (!formEl) return

  formEl.validate((valid) => {
        if (valid) {
            const result = {
                price: state.price,
                pairId: state.pair,
                isReverse: state.isReverse,
            }
            axios.post("http://127.0.0.1:8000/api/pairs/convert", result)
                .then(response => {
                    const { success } = response.data

                    if(success) {
                        formEl.resetFields()

                        state.convertionResult = {...response.data}
                    }
                })
                .catch(err => console.log(err));
        }
        return false
  })
}

const resetForm = (formEl) => {
  if (!formEl) return
  formEl.resetFields()
}
</script>