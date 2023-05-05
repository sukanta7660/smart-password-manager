<template>
    <div id="folder-div">
        <Breadcrumb current-page="Credential"/>

        <el-row class="mt-4">
            <el-button type="primary">Add New</el-button>
        </el-row>

        <el-row :gutter="20" class="mt-4" style="width: 100%">
            <el-col :span="24">
                <el-card>
                    <el-table :data="state.tableData">
                        <el-table-column prop="created_at" label="Date" />
                        <el-table-column prop="type" label="Type" />
                        <el-table-column prop="name" label="Name" />
                        <el-table-column prop="username" label="Username" />
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
import {onMounted, reactive} from 'vue';
import Breadcrumb from "../../components/Utils/BreadCrumb.vue";
import {formatDateTime} from '../../utils/helpers';

const state = reactive({
    credentials: [],
    tableData: []
});

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
        state.credentials = response;
        formatFolderTableData(response);
    });

}

const formatFolderTableData = (data = []) => {
    if (!data.length) {
        return;
    }

    state.tableData = data.map((credential) => {
        return {
            id: credential.id,
            name: credential.name,
            username: credential.username,
            type: credential.item_type,
            user: credential.display_name,
            created_at: formatDateTime(credential.created_at)
        }
    });

};

const getData = () => {
    fetchCredentials();
};

onMounted(() => {
    getData();
});

</script>

<style lang="scss">

</style>