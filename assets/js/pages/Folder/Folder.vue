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
                  <el-table :data="filterableTableData">
                      <el-table-column prop="created_at" label="Date" />
                      <el-table-column prop="folder" label="Name" />
                      <el-table-column align="right" >
                          <template #header>
                              <el-input
                                  clearable
                                  v-model="search"
                                  placeholder="Type to search"
                              />
                          </template>
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
          :on-success-handler="fetchFolders"
          :close-modal-handler="closeModalHandler"
      />
  </div>
</template>

<script setup>
import {computed, onMounted, reactive, ref} from 'vue';
import Breadcrumb from "../../components/Utils/BreadCrumb.vue";
import {confirmDelete, formatDateTime, notify} from '../../utils/helpers';
import FolderForm from '../../components/Folder/FolderForm.vue';

    const state = reactive({
        folders: [],
        showCreateUpdate: false,
        isUpdating: false,
        selectedField: {}
    });

    const search = ref('');

    const fetchFolders = () => {

        const dataToSubmit = {
            action: 'get_folder'
        }

        const ajaxUrl = window.ajax_object.ajax_url;

        window.jQuery.ajax({
            url: ajaxUrl,
            data: dataToSubmit,
            method: 'POST'
        }).done((response) => {
            formatFolderTableData(response);
        });

   }

   const deleteFolder = (id) => {
       const dataToSubmit = {
           action: 'delete_folder',
           id
       }

       const ajaxUrl = window.ajax_object.ajax_url;

       window.jQuery.ajax({
           url: ajaxUrl,
           data: dataToSubmit,
           method: 'POST'
       }).done((response) => {
           notify('success', 'Folder Deleted')
           fetchFolders();
       });
   };

   const formatFolderTableData = (data = []) => {
        if (!data.length) {
            return;
        }

       state.folders = data.map((folder) => {
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
           confirmDelete({ onConfirm: () => deleteFolder(data.id) });
       }
   };

    const filterableTableData = computed(() => {
        return state.folders?.filter(
            (data) => !search.value || data.folder.toLocaleLowerCase().includes(search.value.toLowerCase())
        );
    });

    const getData = () => {
        fetchFolders();
    };

    onMounted(() => {
        getData();
    });

</script>

<style lang="scss">

</style>