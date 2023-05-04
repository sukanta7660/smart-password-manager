<template>
    <el-row class="mt-4">
        <el-breadcrumb :separator-icon="ArrowRight">
            <el-breadcrumb-item>Home</el-breadcrumb-item>
            <el-breadcrumb-item>{{ props.currentPage }}</el-breadcrumb-item>
        </el-breadcrumb>
    </el-row>
</template>

<script setup>
  import { ArrowRight } from '@element-plus/icons-vue';
  const props =  defineProps({
      currentPage: {
          type: String,
          default: ''
      },
  })
</script>

<style scoped>

</style>