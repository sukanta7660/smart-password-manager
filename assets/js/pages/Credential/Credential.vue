<template>
    <div id="credential-div">
        <Breadcrumb current-page="Credential"/>

        <el-row class="mt-4">
            <el-button
                @click="handleCreateCredential"
                :icon="Plus"
                type="primary">
                Add New
            </el-button>

            <el-button
                :icon="Download"
                @click="handleExportCsv"
                type="primary">
                Export as CSV
            </el-button>

            <el-button
                @click="handleCreateCredential"
                :icon="UploadFilled"
                type="primary">
                Import CSV File
            </el-button>

            <el-button
                @click="handleCreateCredential"
                :icon="FolderRemove"
                type="primary">
                Move selected item
            </el-button>
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
                            <template #default="scope">
                                <el-button
                                    type="primary"
                                    @click="handleAction('edit', scope.row)"
                                    :icon="Edit"
                                >
                                    Edit
                                </el-button>
                                <el-button
                                    @click="handleAction('delete', scope.row)"
                                    :icon="Delete"
                                    type="danger">
                                    Delete
                                </el-button>
                            </template>
                        </el-table-column>
                    </el-table>
                </el-card>
            </el-col>
        </el-row>

        <!--Credential Create Update Form-->
        <CredentialForm
            :folders="state.folders"
            :modal-show="state.showCreateUpdate"
            :credential="state.selectedField"
            :is-updating="state.isUpdating"
            :close-modal-handler="closeModalHandler"
        />

        <!--Master Password Form-->
        <MasterPasswordForm
            :modal-show="state.showMasterPasswordForm"
            :close-modal-handler="closeModalHandler"
        />

    </div>
</template>

<script setup>
import {onMounted, reactive} from 'vue';
import Breadcrumb from '../../components/Utils/BreadCrumb.vue';
import {confirmDelete, exportCsv, formatDateTime} from '../../utils/helpers';
import CredentialForm from '../../components/Credential/CredentialForm.vue';
import MasterPasswordForm from "./MasterPasswordForm.vue";
import {
    Plus, Download, UploadFilled, FolderRemove,
    Delete, Edit
} from '@element-plus/icons-vue'

const state = reactive({
    credentials: [],
    folders: [],
    tableData: [],
    showCreateUpdate: false,
    showMasterPasswordForm: false,
    isUpdating: false,
    selectedField: {}
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
        formatCredentialTableData(response);
    });

};

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
    });

};

const formatCredentialTableData = (data = []) => {
    if (!data.length) {
        return;
    }

    state.tableData = data.map((credential) => {
        return {
            id: credential.id,
            folder_id: credential.folder_id,
            name: credential.name,
            username: credential.username,
            password: credential.password,
            url: credential.url,
            notes: credential.notes,
            type: credential.item_type,
            user: credential.display_name,
            created_at: formatDateTime(credential.created_at)
        }
    });

};

const closeModalHandler = () => {
    state.showCreateUpdate = false;
    state.isUpdating = false;
    fetchCredentials();
    state.selectedField = {};
};

const handleCreateCredential = () => {
    state.showCreateUpdate = !state.showCreateUpdate;
    state.isUpdating = false;
    state.selectedField = {};
};

const deleteCredential = (id) => {
    const dataToSubmit = {
        action: 'delete_credential',
        id
    }

    const ajaxUrl = window.ajax_object.ajax_url;

    window.jQuery.ajax({
        url: ajaxUrl,
        data: dataToSubmit,
        method: 'POST'
    }).done((response) => {
        fetchCredentials();
    });
};

const handleAction = (action, data) => {
    state.selectedField = data;

    if (action === 'edit') {
        state.showMasterPasswordForm = true;
        // state.isUpdating = true;
        // state.showCreateUpdate = true;
    }

    if (action === 'delete') {
        confirmDelete({ onConfirm: () => deleteCredential(data.id) });
    }
};

const handleExportCsv = () => {

    if (!state.credentials.length) {
        return;
    }

    const data = state.credentials.map(item => ({
        id: item.id,
        folder_id: item.folder_id,
        user_id: item.user_id,
        item_type: item.item_type,
        name: item.name,
        username: item.username,
        password: item.password,
        url: item.url,
        notes: item.notes,
        created_at: item.created_at,
        updated_at: item.updated_at,
    }))

    let fileName = String('credentials-'+new Date().toLocaleString());

    exportCsv(data, fileName);
    // state.selectedItems = [];

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

</style>