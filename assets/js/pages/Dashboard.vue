<template>
    <Breadcrumb current-page="Dashboard"/>

    <el-row :gutter="20" style="width: 100%">
        <el-col :span="8">
            <el-card
                class="card-content"
                body-style="danger"
                shadow="hover">
                <h1>
                    Total User
                </h1>
                <h1>
                    {{ state.users.length }}
                </h1>
            </el-card>
        </el-col>
        <el-col :span="8">
            <el-card
                class="card-content"
                body-style="danger"
                shadow="hover">
                <h1>
                    Total Folder
                </h1>
                <h1>
                    {{ state.users.length }}
                </h1>
            </el-card>
        </el-col>
        <el-col :span="8">
            <el-card
                class="card-content"
                body-style="danger"
                shadow="hover">
                <h1>
                    Total Credential
                </h1>
                <h1>
                    {{ state.users.length }}
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
      users: [],
      posts: [],

  });

  const handleGetUserData = async () => {
      let response = await axios.get('/wp-json/wp/v2/users');
      state.users = response.data;
  };

  const handleGetPostData = async () => {
      let response = await axios.get('/wp-json/wp/v2/posts');
      state.posts = response.data;
  };

  const getData = () => {
      handleGetUserData();
      handleGetPostData();
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