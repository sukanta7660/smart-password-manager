<template>
    <el-dialog
        :close-on-click-modal="false"
        v-model="modal.show"
        @close="resetModal"
        :title="props.isUpdating ? 'Credential Updating' : 'Credential Creating'"
    >

        <el-form
            ref="credentialForm"
            :model="form"
            :rules="rules"
            label-width="100px"
            @submit.prevent="handleSubmit"
        >
            <el-row :gutter="20" style="width: 100%">
                <el-col :span="24">
                    <el-form-item
                        label="Name"
                        required
                        prop="name">
                        <el-input
                            v-model.trim="form.name"
                            autocomplete="off"
                        />
                    </el-form-item>
                </el-col>
                <el-col :span="12">
                    <el-form-item
                        label="Type"
                        required
                        prop="item_type"
                    >
                        <el-select
                            v-model.trim="form.item_type"
                            clearable
                            placeholder="Select Type">
                            <el-option
                                v-for="item in credentialTypes"
                                :key="item.value"
                                :label="item.label"
                                :value="item.value"
                            />
                        </el-select>
                    </el-form-item>
                </el-col>

                <el-col :span="12">
                    <el-form-item
                        label="Folder"
                    >
                        <el-select
                            v-model.trim="form.folder_id"
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

            <el-form-item label="Username">
                <el-input
                    v-model.trim="form.username"
                    autocomplete="off"
                />
            </el-form-item>

            <el-form-item label="Password">
                <el-input
                    v-model.trim="form.password"
                    autocomplete="off"
                />
            </el-form-item>

            <el-form-item label="Url">
                <el-input
                    v-model.trim="form.url"
                    autocomplete="off"
                />
            </el-form-item>

            <el-form-item label="Notes">
                <el-input
                    v-model.trim="form.notes"
                    autocomplete="off"
                />
            </el-form-item>

            <div class="dialog-footer-btns">
                <span class="dialog-footer">
                  <el-button @click="resetModal">Cancel</el-button>
                  <el-button type="primary" native-type="submit">
                    {{ props.isUpdating ? 'Save Changes' : 'Save Credential' }}
                  </el-button>
                </span>
            </div>
        </el-form>

    </el-dialog>
</template>

<script setup>
import {reactive, watch, ref} from 'vue';

const props =  defineProps({
    credential: {
        type: Object,
        default: () => {}
    },
    folders: {
      type: Array,
      default: () => []
    },
    modalShow: {
        type: Boolean,
        default: false
    },
    isUpdating: {
        type: Boolean,
        default: false
    },
    closeModalHandler: {
        type: Function,
        default: () => {}
    }

});

const credentialForm = ref();

const form = reactive({
    id: null,
    folder_id: null,
    name: null,
    username: null,
    password: null,
    url: null,
    notes: null,
    item_type: null
});

const rules = reactive({
    name: [
        {
            required: true,
            message: 'Please input name',
            trigger: 'blur'
        },
        {
            min: 3,
            message: 'Length should be 3 to 5',
            trigger: 'blur'
        },
    ],
    item_type: [
        {
            required: true,
            message: 'Please select a type',
            trigger: 'blur'
        }
    ]
})

const credentialTypes = [
    {
        value: 'login',
        label: 'Login'
    },
    {
        value: 'card',
        label: 'Card'
    },
    {
        value: 'identity',
        label: 'Identity'
    }
];

const modal = {
    title: props.isUpdating ? 'Updating Credential' : 'Creating Credential',
    confirmBtnText: props.isUpdating ? 'Save Changes' : 'Save Credential',
    show: false
};

const createCredential = () => {
    const dataToSubmit = {
        action: 'create_credential',
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
        }

    });
};

const updateCredential = () => {
    const dataToSubmit = {
        action: 'update_credential',
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
        }
    });
};

const handleSubmit = () => {
    credentialForm.value.validate((valid, fields) => {
        if (valid) {
            !props.isUpdating ? createCredential() : updateCredential()
        }
    })
};

const resetModal = () => {
    props.closeModalHandler();
    form.id =  null;
    form.folder_id = null;
    form.name = null;
    form.username = null;
    form.password = null;
    form.url = null;
    form.notes = null;
    form.item_type = null;
};

watch(() => props.modalShow, (nv) => {
    modal.show = nv
});

watch(() => props.credential, (nv) => {
    if (!nv) {
        return;
    }

    populateCredentialData(nv);
});

const populateCredentialData = (item = {}) => {
    if (!item) {
        return;
    }
    form.id = item.id;
    form.folder_id = item.folder_id;
    form.name = item.name;
    form.username = item.username;
    form.password = item.password;
    form.url = item.url;
    form.notes = item.notes;
    form.item_type = item.type;
};

</script>

<style scoped lang="scss">

</style>