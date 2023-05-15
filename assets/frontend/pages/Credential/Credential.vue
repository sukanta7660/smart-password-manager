<template>
    <div id="credential-div">
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
                    <el-table
                        ref="selectedItems"
                        stripe
                        :data="filterableTableData"
                        @selection-change="handleSelectionChange"
                    >
                        <el-table-column type="selection"/>
                        <el-table-column prop="created_at" label="Date" sortable/>
                        <el-table-column prop="type" label="Type" sortable/>
                        <el-table-column prop="name" label="Name" sortable/>
                        <el-table-column prop="username" label="Username" sortable/>
                        <el-table-column align="right">
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
            :on-success-handler="fetchCredentials"
        />

        <!--Master Password Form-->
        <MasterPasswordForm
            :modal-show="state.showMasterPasswordForm"
            :close-modal-handler="closeMasterPasswordModalHandler"
            :on-success-handler="handleUpdateHandler"
        />

    </div>
</template>

<script setup>
import {computed, onMounted, reactive, ref} from 'vue';
import Breadcrumb from '../../components/Utils/BreadCrumb.vue';
import {confirmDelete, exportCsv, formatDateTime, notify} from '../../utils/helpers';
import CredentialForm from '../../components/Credential/CredentialForm.vue';
import MasterPasswordForm from "../../components/Credential/MasterPasswordForm.vue";
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
    selectedField: {},
    search: null
});

const search = ref('');
const selectedItems = ref([]);

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

    state.credentials = data.map((credential) => {
        return {
            id: credential.id,
            folder_id: credential.folder_id,
            user_id: credential.user_id,
            name: credential.name,
            username: credential.username,
            password: credential.password,
            url: credential.url,
            notes: credential.notes,
            type: credential.item_type,
            user: credential.display_name,
            created_at: formatDateTime(credential.created_at),
            updated_at: formatDateTime(credential.created_at)
        }
    });

};

const closeModalHandler = () => {
    state.showCreateUpdate = false;
    state.isUpdating = false;
    state.selectedField = {};
};

const closeMasterPasswordModalHandler = () => {
    state.showMasterPasswordForm = false;
};

const handleCreateCredential = () => {
    state.showCreateUpdate = !state.showCreateUpdate;
    state.selectedField = {};
};

const handleUpdateHandler = () => {
    state.isUpdating = true;
    state.showCreateUpdate = true;
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
        notify('success', 'Credential Deleted')
        fetchCredentials();
    });
};

const handleAction = (action, data) => {
    state.selectedField = data;

    if (action === 'edit') {
        state.showMasterPasswordForm = true;
    }

    if (action === 'delete') {
        confirmDelete({ onConfirm: () => deleteCredential(data.id) });
    }
};

const handleExportCsv = () => {

    const exportableData = selectedItems.value.length
        ? selectedItems.value
        : state.credentials
    ;

    if (!exportableData.length) {
        return;
    }

    const data = exportableData.map(item => ({
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

};

const handleSelectionChange = (val) => {
    selectedItems.value = val;
};

const filterableTableData = computed(() => {
    return state.credentials?.filter(
        (data) => !search.value || data.name.toLocaleLowerCase().includes(search.value.toLowerCase())
    );
});

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