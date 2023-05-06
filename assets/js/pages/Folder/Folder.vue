<template>
  <div id="folder-div">
      <Breadcrumb current-page="Folders"/>

      <el-row class="mt-4">
          <el-button type="primary" @click="handleCreateFolder">
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
                      <template #default="scope">
                          <el-button
                              type="primary"
                              @click="handleAction('edit', scope.row)"
                          >
                              Edit
                          </el-button>
                          <el-button
                              @click="handleAction('delete', scope.row)"
                              type="danger">
                              Delete
                          </el-button>
                      </template>
                  </el-table-column>
              </el-table>
              </el-card>
          </el-col>
      </el-row>

      <FolderForm
          :modal-show="state.showCreateUpdate"
          :folder="state.selectedField"
          :is-updating="state.isUpdating"
          :close-modal-handler="closeModalHandler"
      />
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
        showCreateUpdate: false,
        isUpdating: false,
        selectedField: {}
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

   const closeModalHandler = () => {
       state.showCreateUpdate = false;
       state.isUpdating = false;
       state.selectedField = {};
   };

   const handleCreateFolder = () => {
       state.showCreateUpdate = !state.showCreateUpdate;
       state.isUpdating = false;
       state.selectedField = {};

   };

   const handleAction = (action, data) => {
       state.selectedField = data;

       if (action === 'edit') {
           state.isUpdating = true;
           state.showCreateUpdate = true;
       }

       if (action === 'delete') {
           console.log(action);
       }
   };

   // const modalCreate

    const getData = () => {
        fetchFolders();
    };

    onMounted(() => {
        getData();
    });

</script>

<style lang="scss">

</style>