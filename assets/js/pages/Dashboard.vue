<template>
  <el-row class="mt-4">
      <Breadcrumb current-page="Dashboard"/>
  </el-row>
</template>

<script setup>
  import Breadcrumb from '../components/Utils/BreadCrumb.vue';
  import {reactive} from 'vue';

  const state = reactive({});
</script>

<style scoped>

</style>