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

        <!-- ------------- PASSWORD -------------- -->
        <el-form-item label="Password" prop="pass">
            <el-input v-model="ruleForm.pass" type="password" autocomplete="off" />
        </el-form-item>

        <!-- ------------- EMAIL -------------- -->
        <el-form-item label="Email" prop="email">
            <el-input v-model="ruleForm.email" type="email" />
        </el-form-item>

        <!-- ------------- NUMBER -------------- -->
        <el-form-item label="Age" prop="age">
            <el-input v-model.number="ruleForm.age" />
        </el-form-item>

        <!-- ------------- CHECKBOX -------------- -->
        <el-form-item label="Activity type" prop="type">
            <el-checkbox-group v-model="ruleForm.type">
                <el-checkbox label="Online activities" name="type" />
                <el-checkbox label="Promotion activities" name="type" />
                <el-checkbox label="Offline activities" name="type" />
                <el-checkbox label="Simple brand exposure" name="type" />
            </el-checkbox-group>
        </el-form-item>

        <!-- ------------- SELECT -------------- -->
        <el-form-item label="Activity zone" prop="region">
            <el-select v-model="ruleForm.region" placeholder="Activity zone">
                <el-option label="shanghai" value="shanghai" />
                <el-option label="Beijing" value="beijing" />
            </el-select>
        </el-form-item>

        <!-- ------------- RADIO -------------- -->
        <el-form-item label="Resources" prop="resource">
            <el-radio-group v-model="ruleForm.resource">
                <el-radio label="Sponsorship" />
                <el-radio label="Venue" />
            </el-radio-group>
        </el-form-item>


        <!-- ------------- SWITCH -------------- -->
        <el-form-item label="Instant delivery" prop="delivery">
            <el-switch v-model="ruleForm.delivery" />
        </el-form-item>

        <el-form-item>
            <el-button type="primary" @click="submitForm(ruleFormRef)">Submit</el-button>
            <el-button @click="resetForm(ruleFormRef)">Reset</el-button>
        </el-form-item>
  </el-form>
</template>

<script setup>
import { reactive, ref } from 'vue'

const ruleFormRef = ref()

const checkAge = (rule, value, callback) => {
  if (!value) {
        return callback(new Error('Please input the age'))
  }
  setTimeout(() => {
        if (!Number.isInteger(value)) {
            callback(new Error('Please input digits'))
        } else {
            if (value < 1) {
                callback(new Error('Age must be greater than 1'))
            } else {
                callback()
            }
        }
  }, 1000)
}

const ruleForm = reactive({
  pass: '', // password
  email: '', // email
  age: '', // number
  type: [], // Checkbox
  region: '', // Select
  resource: '', // radio
  delivery: false, // switch
})

const rules = reactive({
    pass: [{
          required: true,
          message: 'Please input password',
          trigger: 'blur',
    }],
    age: [{ validator: checkAge, trigger: 'blur', required: true }],
    email: [
        {
            required: true,
            message: 'Please input email address',
            trigger: 'blur',
        },
        {
            type: 'email',
            message: 'Please input correct email address',
            trigger: ['blur', 'change'],
        },
    ],
    type: [{
        type: 'array',
        required: true,
        message: 'Sélectionner au moin une activité',
        trigger: 'change',
    }],
    region: [{
        required: true,
        message: 'Sélectionner une option',
        trigger: 'change',
    }],
    resource: [{
        required: true,
        message: 'Sélectionner une option',
        trigger: 'change',
    }],
})

const submitForm = (formEl) => {
  if (!formEl) return

  formEl.validate((valid) => {
        if (valid) {
            console.log('submit!', {...ruleForm})
        } else {
            console.log('error submit!')
        return false
        }
  })
}

const resetForm = (formEl) => {
  if (!formEl) return
  formEl.resetFields()
}
</script>