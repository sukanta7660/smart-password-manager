<template>
  <div id="folder-div">
      <Breadcrumb current-page="Folders"/>

      <el-row class="mt-4">
          <el-button type="primary" @click="state.isModalOpened = true">
              Add New
          </el-button>
      </el-row>

      <el-row :gutter="20" class="mt-4" style="width: 100%">
          <el-col :span="24">
              <el-card>
              <el-table :data="state.tableData">
                  <el-table-column prop="created_at" label="Date" />
                  <el-table-column prop="folder" label="Name" />
                  <el-table-column label="Action" >
                      <el-button type="primary">Edit</el-button>
                      <el-button type="danger">Delete</el-button>
                  </el-table-column>
              </el-table>
              </el-card>
          </el-col>
      </el-row>

      <FolderForm :modal-show="state.isModalOpened"/>
  </div>
</template>

<script setup>
import {onMounted, reactive} from 'vue';
import Breadcrumb from "../../components/Utils/BreadCrumb.vue";
import {formatDateTime} from '../../utils/helpers';
import FolderForm from '../../components/Folder/FolderForm.vue';

    const state = reactive({
        folders: [],
        tableData: [],
        isModalOpened: false
    });

    const fetchFolders = () => {

        const dataToSubmit = {
            action: 'get_folder',
        }

        const ajaxUrl = window.ajax_object.ajax_url;

        window.jQuery.ajax({
            url: ajaxUrl,
            data: dataToSubmit,
            method: 'POST'
        }).done((response) => {
            state.folders = response;
            formatFolderTableData(response);
        });

   }

   const formatFolderTableData = (data = []) => {
        if (!data.length) {
            return;
        }

       state.tableData = data.map((folder) => {
           return {
               id: folder.id,
               folder: folder.name,
               user: folder.display_name,
               created_at: formatDateTime(folder.created_at)
           }
       });

   };

    const getData = () => {
        fetchFolders();
    };

    onMounted(() => {
        getData();
    });

</script>

<style lang="scss">

</style>