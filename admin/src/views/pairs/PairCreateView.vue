<template>
    <el-form
        ref="ruleFormRef"
        :model="state"
        status-icon
        :rules="rules"
        label-width="120px"
        label-position="top"
    >
        <el-row :gutter="20">
            <el-col :span="12">
                <div class="grid-content" >
                    <el-form-item label="de" >
                        <el-select style="width: 100%" v-if="state.loaded" v-model="state.currencyFromId" placeholder="Sélectionner une devise">
                            <el-option v-for="(option, index) in state.options" :label="option.symbol + ' - ' + option.name" :value="option.id" />
                        </el-select>
                    </el-form-item>
                </div>
            </el-col>

            <el-col :span="12">
                <div class="grid-content" >
                    <el-form-item label="vers">
                        <el-select style="width: 100%" v-model="state.currencyToId" placeholder="Selectionner une devise">
                            <el-option v-for="(option, index) in state.options" :label="option.name" :value="option.id" />
                        </el-select>
                    </el-form-item>
                </div>
            </el-col>
        </el-row>

        <el-row :gutter="20">
            <el-col :span="12">
                <div class="grid-content" >
                     <el-form-item label="Taux" prop="rate">
                        <el-input-number style="width: 100%" v-model="state.rate" :precision="8" :step="0.1" :min="0" :max="10" />
                    </el-form-item>
                </div>
            </el-col>
        </el-row>

        <el-form-item>
            <el-button type="primary" @click="submitForm(ruleFormRef)">Créer cette paire</el-button>
            <el-button @click="resetForm(ruleFormRef)">Réinitialiser</el-button>
        </el-form-item>
  </el-form>
</template>

<script setup>
import { ElButton, ElNotification } from 'element-plus'
import { reactive, ref, onMounted } from 'vue'
import { useRouter } from "vue-router";
import axios from 'axios'

const router = useRouter()

const ruleFormRef = ref()

const state = reactive({
    currencyFromId: '',
    currencyToId: '',
    options: [],
    loaded: false,
    rate: 0
})

const submitForm = (formEl) => {
    if (!formEl) return

    formEl.validate((valid) => {
        if (valid) {
            if(state.currencyFromId === state.currencyToId) {

                ElNotification({
                    title: 'Erreur',
                    message: 'Les 2 devises ne peuvent pas être identique',
                    type: 'error',
                    duration: 3500
                })
                return false
            }

            let pair = {
                currency_from_id: state.currencyFromId,
                currency_to_id: state.currencyToId,
                rate: state.rate
            }

            console.log(pair)

            axios.post("http://127.0.0.1:8000/api/pairs/", pair)
            .then(response => {
                if(response.data.success) {
                    formEl.resetFields()

                    ElNotification({
                        title: 'Succès',
                        message: response.data.message,
                        type: 'success',
                        onClose: () => router.push('/'),
                        duration: 1500
                    })
                }
            }).catch(err => {
                ElNotification({
                        title: 'Erreur',
                        message: err.response.data.message,
                        type: 'error',
                        duration: 1500
                    })
            });
        } else {
            return false
        }
    })
}

const resetForm = (formEl) => {
  if (!formEl) return
  formEl.resetFields()
}


onMounted(() => {
    axios.get("http://127.0.0.1:8000/api/currencies") 
    .then(response => {
        state.options.push(...response.data.data)
        state.loaded = true
    }) 
    .catch( error => console.log( 'error: ' + error ) ); 
})

</script>