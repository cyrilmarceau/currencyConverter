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
                    <el-form-item label="Première devise - NOM" prop="currencyFromName">
                        <el-input placeholder="Ex. EURO" v-model="ruleForm.currencyFromName" />
                    </el-form-item>
                </div>
            </el-col>

            <el-col :span="12">
                <div class="grid-content" >
                    <el-form-item label="Première devise - SYMBOLE" prop="currencyFromSymbol">
                        <el-input placeholder="Ex. EUR" v-model="ruleForm.currencyFromSymbol" />
                    </el-form-item>
                </div>
            </el-col>
        </el-row>

        <el-row :gutter="20">
            <el-col :span="12">
                <div class="grid-content" >
                    <el-form-item label="Deuxième devise - NOM" prop="currencyToName">
                        <el-input placeholder="Ex. DOLLAR" v-model="ruleForm.currencyToName" />
                    </el-form-item>
                </div>
            </el-col>

            <el-col :span="12">
                <div class="grid-content" >
                    <el-form-item label="Deuxième devise - SYMBOLE" prop="currencyToSymbol">
                        <el-input placeholder="Ex. USD" v-model="ruleForm.currencyToSymbol" />
                    </el-form-item>
                </div>
            </el-col>

        </el-row>

        <el-row :gutter="20">
            <el-col :span="12">
                <div class="grid-content" >
                     <el-form-item label="Taux" prop="rate">
                        <el-input-number style="width: 100%" v-model="ruleForm.rate" :precision="8" :step="0.1" :min="0" :max="10" />
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
import { reactive, ref } from 'vue'
import { useRouter } from "vue-router";
import axios from 'axios'

const router = useRouter()

const ruleFormRef = ref()

const ruleForm = reactive({
    currencyFromName: '',
    currencyFromSymbol: '',
    currencyToName: '',
    currencyToSymbol: '',
    rate: 0
})

const rules = reactive({
    currencyFromName: [
        {required: true, message: 'Ce champ est obligatoire', trigger: 'blur'}
    ],

    currencyFromSymbol:[
        { required: true, message: 'Ce champ est obligatoire', trigger: 'blur' },
        { min: 3, max: 3, message: 'La longeur doit être de 3 caractères', trigger: 'blur' },
    ],

    currencyToName: [{required: true, message: 'Ce champ est obligatoire', trigger: 'blur'}],

    currencyToSymbol: [
        { required: true, message: 'Ce champ est obligatoire', trigger: 'blur'}, 
        { min: 3, max: 3, message: 'La longeur doit être de 3 caractères', trigger: 'blur' }
    ],

    rate: [{ trigger: 'blur', required: true }]
})

const submitForm = (formEl) => {
    if (!formEl) return

    formEl.validate((valid) => {
        if (valid) {
            let pairs = {
                currencies: {
                    from: {
                        symbol: '',
                        name: ''
                    },
                    to: {
                        symbol: '',
                        name: ''
                    }
                },
                rate: 0
            }
            pairs.currencies.from.symbol = ruleForm.currencyFromSymbol
            pairs.currencies.from.name = ruleForm.currencyFromName
            pairs.currencies.to.symbol = ruleForm.currencyToSymbol
            pairs.currencies.to.name = ruleForm.currencyToName
            pairs.rate = ruleForm.rate

            axios.post("http://127.0.0.1:8000/api/pairs/", pairs)
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
            }).catch(err => console.log(err));
        } else {
            return false
        }
    })
}

const resetForm = (formEl) => {
  if (!formEl) return
  formEl.resetFields()
}
</script>