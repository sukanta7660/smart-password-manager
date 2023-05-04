<template>
    <div>
        <Breadcrumb current-page="Credential"/>

        <el-row class="mt-4">
            <el-button type="primary">Add New</el-button>
        </el-row>

        <el-row class="mt-4">
            <el-table :data="tableData" style="width: 98%">
                <el-table-column prop="name" label="Name" />
                <el-table-column prop="username" label="Username" />
                <el-table-column prop="url" label="URL" />
                <el-table-column prop="notes" label="Notes" />
                <el-table-column prop="folder" label="Folder" />
                <el-table-column label="Action" >
                    <el-button type="primary">Edit</el-button>
                    <el-button type="danger">Delete</el-button>
                </el-table-column>
            </el-table>
        </el-row>
    </div>
</template>

<script setup>
import {reactive} from 'vue';
import Breadcrumb from "../../components/Utils/BreadCrumb.vue";

const state = reactive({});

const tableData = [
    {
        name: 'Tom',
        username: 'username',
        url: 'url',
        notes: 'test notes',
        folder: 'test folder'
    },
    {
        name: 'Tom',
        username: 'username',
        url: 'url',
        notes: 'test notes',
        folder: 'test folder'
    },
    {
        name: 'Tom',
        username: 'username',
        url: 'url',
        notes: 'test notes',
        folder: 'test folder'
    },
    {
        name: 'Tom',
        username: 'username',
        url: 'url',
        notes: 'test notes',
        folder: 'test folder'
    },
    {
        name: 'Tom',
        username: 'username',
        url: 'url',
        notes: 'test notes',
        folder: 'test folder'
    },
    {
        name: 'Tom',
        username: 'username',
        url: 'url',
        notes: 'test notes',
        folder: 'test folder'
    },
    {
        name: 'Tom',
        username: 'username',
        url: 'url',
        notes: 'test notes',
        folder: 'test folder'
    }
];
</script>

<style lang="scss">

</style>