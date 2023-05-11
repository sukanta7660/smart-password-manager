<template>
    <el-container>
        <el-row :gutter="0" style="width: 100%; padding: 20px">
            <el-col :span="24">
                <NavMenu />
            </el-col>
            <el-col :span="24" style="padding: 1rem">
                <router-view></router-view>
            </el-col>
        </el-row>
    </el-container>
</template>

<script setup>
import {reactive, ref} from 'vue';
import NavMenu from "../components/Utils/NavMenu.vue";

const state = reactive({});
</script>

<style scoped>
</style>