<template>
    <el-form
        ref="ruleFormRef"
        :model="ruleForm"
        status-icon
        :rules="rules"
        label-width="120px"
        class="demo-ruleForm"
        label-position="top"
    >
        <el-row :gutter="20">
            <el-col :span="12">
                <div class="grid-content" >
                    <el-form-item label="NOM" prop="currencyName">
                        <el-input placeholder="Ex. EURO" v-model="ruleForm.currencyName" />
                    </el-form-item>
                </div>
            </el-col>

            <el-col :span="12">
                <div class="grid-content" >
                    <el-form-item label="SYMBOLE" prop="currencySymbol">
                        <el-input placeholder="Ex. EUR" v-model="ruleForm.currencySymbol" />
                    </el-form-item>
                </div>
            </el-col>
        </el-row>

        <el-form-item>
            <el-button type="primary" @click="submitForm(ruleFormRef)">Créer cette devise</el-button>
            <el-button @click="resetForm(ruleFormRef)">Réinitialiser</el-button>
        </el-form-item>
  </el-form>
</template>

<script setup>
import { ElButton, ElNotification } from 'element-plus'
import { reactive, ref } from 'vue'
import { useRouter } from "vue-router";
import axios from 'axios'

const router = useRouter()

const ruleFormRef = ref()

const ruleForm = reactive({
    currencyName: '',
    currencySymbol: '',
})

const rules = reactive({
    currencyName: [
        {required: true, message: 'Ce champ est obligatoire', trigger: 'blur'}
    ],

    currencySymbol:[
        { required: true, message: 'Ce champ est obligatoire', trigger: 'blur' },
        { min: 3, max: 3, message: 'La longeur doit être de 3 caractères', trigger: 'blur' },
    ],
})

const submitForm = (formEl) => {
    if (!formEl) return

    formEl.validate((valid) => {
        if (valid) {
            let obj = {
                currency: {
                    symbol: '',
                    name: ''
                }
            }
            obj.currency.symbol = ruleForm.currencySymbol
            obj.currency.name = ruleForm.currencyName

            axios.post("http://127.0.0.1:8000/api/currencies/", obj)
            .then(response => {
                console.log('response', response)
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
            console.log('here')
            return false
        }
    })
}

const resetForm = (formEl) => {
  if (!formEl) return
  formEl.resetFields()
}
</script>