<template>
    <el-dialog
            :close-on-click-modal="false"
            v-model="modal.show"
            @close="resetModal"
            title="Move To Folder"
    >

        <el-form
                ref="credentialMoveForm"
                :model="form"
                label-width="100px"
                @submit.prevent="handleSubmit"
        >
            <el-row :gutter="20" style="width: 100%">
                <el-col :span="24">
                    <el-table
                        ref="selectedCredentials"
                        stripe
                        :data="state.credentials"
                    >
                        <el-table-column prop="type" label="Type"/>
                        <el-table-column prop="name" label="Name"/>
                        <el-table-column prop="username" label="Username"/>
                    </el-table>
                </el-col>
                <el-col :span="12" class="mt-4">
                    <el-form-item
                        label="Folder"
                    >
                        <el-select
                            v-model="form.folder_id"
                            clearable
                            placeholder="Select Folder">
                            <el-option
                                v-for="item in props.folders"
                                :key="item.id"
                                :label="item.name"
                                :value="item.id"
                            />
                        </el-select>
                    </el-form-item>
                </el-col>
            </el-row>

            <div class="dialog-footer-btns">
                <span class="dialog-footer">
                  <el-button @click="resetModal">Cancel</el-button>
                  <el-button type="primary" native-type="submit">
                    Confirm
                  </el-button>
                </span>
            </div>
        </el-form>

    </el-dialog>
</template>

<script setup>
import {onMounted, reactive, ref, watch} from 'vue';
import {Delete, Edit} from "@element-plus/icons-vue";

const props =  defineProps({
    modalShow: {
        type: Boolean,
        default: false
    },
    folders: {
        type: Array,
        default: () => [],
        required: true
    },
    selectedItems: {
        type: Array,
        default: () => [],
        required: true
    },
    closeModalHandler: {
        type: Function,
        default: () => {}
    },
    onSuccessHandler: {
        type: Function,
        default: () => {}
    }
});

const credentialMoveForm = ref();

const state = reactive({
    credentials: []
});

const modal = {
    show: false
};

const form = reactive({
    folder_id: null,
    items: []
});

const handleSubmit = () => {
    const dataToSubmit = {
        action: 'move_credential',
        ...form
    }

    const ajaxUrl = window.ajax_object.ajax_url;

    window.jQuery.ajax({
        url: ajaxUrl,
        data: dataToSubmit,
        method: 'POST'
    }).done((response) => {
        if (response) {
            resetModal();
            props.onSuccessHandler();
        }else {
            form.error = 'Password is incorrect';
        }
    });
};

const resetModal = () => {
    props.closeModalHandler();
    form.folder_id = null;
};

const populateItems = () => {
    form.items = state.credentials.map((item) => parseInt(item.id));
};

watch(() => props.modalShow, (nv) => {
    modal.show = nv
});

watch(() => props.selectedItems, (nv) => {
    state.credentials = nv;
    populateItems();
});
</script>


<style scoped lang="scss">

</style>