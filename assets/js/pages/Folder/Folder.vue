<template>
  <div id="folder-div">
      <Breadcrumb current-page="Folders"/>

      <el-row class="mt-4">
          <el-button type="primary">Add New</el-button>
      </el-row>

      <el-row :gutter="20" class="mt-4" style="width: 100%">
          <el-col :span="24">
              <el-card>
              <el-table :data="tableData">
                  <el-table-column prop="name" label="Name" />
                  <el-table-column prop="address" label="Address" />
                  <el-table-column label="Action" >
                      <el-button type="primary">Edit</el-button>
                      <el-button type="danger">Delete</el-button>
                  </el-table-column>
              </el-table>
              </el-card>
          </el-col>
      </el-row>
  </div>
</template>

<script setup>
import {reactive} from 'vue';
import Breadcrumb from "../../components/Utils/BreadCrumb.vue";

const state = reactive({
    txt: 'Main'
});

const tableData = [
    {
        name: 'Tom',
        address: 'No. 189, Grove St, Los Angeles',
    },
    {
        name: 'Tom',
        address: 'No. 189, Grove St, Los Angeles',
    },
    {
        name: 'Tom',
        address: 'No. 189, Grove St, Los Angeles',
    },
    {
        name: 'Tom',
        address: 'No. 189, Grove St, Los Angeles',
    },
    {
        name: 'Tom',
        address: 'No. 189, Grove St, Los Angeles',
    },
    {
        name: 'Tom',
        address: 'No. 189, Grove St, Los Angeles',
    },
    {
        name: 'Tom',
        address: 'No. 189, Grove St, Los Angeles',
    }
];
</script>

<style lang="scss">

</style>