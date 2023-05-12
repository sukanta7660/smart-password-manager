<template>

    <el-row :gutter="10" style="width: 100%">
        <el-col :span="12">
            <el-card
                class="card-content"
                body-style="danger"
                shadow="hover">
                <h1>
                    Total Folder
                </h1>
                <h1>
                    {{ state.folders }}
                </h1>
            </el-card>
        </el-col>
        <el-col :span="12">
            <el-card
                class="card-content"
                body-style="danger"
                shadow="hover">
                <h1>
                    Total Credential
                </h1>
                <h1>
                    {{ state.credentials }}
                </h1>
            </el-card>
        </el-col>
    </el-row>
</template>

<script setup>
  import Breadcrumb from '../components/Utils/BreadCrumb.vue';
  import {reactive, onMounted} from 'vue';
  import axios from 'axios';

  const state = reactive({
      folders: 0,
      credentials: 0
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
          state.folders = response?.length
      });
  }

  const fetchCredentials = () => {

      const dataToSubmit = {
          action: 'get_credential',
      }

      const ajaxUrl = window.ajax_object.ajax_url;

      window.jQuery.ajax({
          url: ajaxUrl,
          data: dataToSubmit,
          method: 'POST'
      }).done((response) => {
          state.credentials = response.length
      });
  };

  const getData = () => {
      fetchCredentials();
      fetchFolders();
  };

  onMounted(() => {
      getData();
  });
</script>

<style lang="scss">
    .card-content {
        .el-card__body {
            display: flex !important;
            justify-content: space-between;
        }
    }
</style>