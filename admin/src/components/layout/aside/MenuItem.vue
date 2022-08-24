<template>
    <el-menu-item :route="props.item.path">
            <el-icon>
                <component :is="props.item.icon" v-if="props.item.icon"  />
            </el-icon>
            <template #title>{{props.item.title}}</template>
    </el-menu-item>

</template>

<script setup>

// eslint-disable-next-line vue/require-prop-types
const props = defineProps(['item'])

</script>