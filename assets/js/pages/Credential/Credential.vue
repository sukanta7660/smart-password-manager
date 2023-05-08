<template>
    <div id="credential-div">
        <Breadcrumb current-page="Credential"/>

        <el-row class="mt-4">
            <el-button
                @click="handleCreateCredential"
                type="primary">
                Add New
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

        <CredentialForm
            :modal-show="state.showCreateUpdate"
            :credential="state.selectedField"
            :is-updating="state.isUpdating"
            :close-modal-handler="closeModalHandler"
        />
    </div>
</template>

<script setup>
import {onMounted, reactive} from 'vue';
import Breadcrumb from '../../components/Utils/BreadCrumb.vue';
import {confirmDelete, formatDateTime} from '../../utils/helpers';
import CredentialForm from '../../components/Credential/CredentialForm.vue';

const state = reactive({
    credentials: [],
    tableData: [],
    showCreateUpdate: false,
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

}

const formatCredentialTableData = (data = []) => {
    if (!data.length) {
        return;
    }

    state.tableData = data.map((credential) => {
        return {
            id: credential.id,
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
        state.isUpdating = true;
        state.showCreateUpdate = true;
    }

    if (action === 'delete') {
        confirmDelete({ onConfirm: () => deleteCredential(data.id) });
    }
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