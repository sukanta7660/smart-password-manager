<template>
    <Breadcrumb current-page="Dashboard"/>

    <el-row :gutter="20" style="width: 100%">
        <el-col :span="8">
            <el-card shadow="always"> Always </el-card>
        </el-col>
        <el-col :span="8">
            <el-card shadow="hover"> Hover </el-card>
        </el-col>
        <el-col :span="8">
            <el-card shadow="never"> Never </el-card>
        </el-col>
    </el-row>
</template>

<script setup>
  import Breadcrumb from '../components/Utils/BreadCrumb.vue';
  import {reactive} from 'vue';

  const state = reactive({});
</script>

<style scoped>

</style>