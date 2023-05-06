<template>
    <el-dialog
        :close-on-click-modal="false"
        v-model="modal.show"
        @close="resetModal"
        :title="props.isUpdating ? 'Credential Updating' : 'Credential Creating'"
    >

        <el-form
            label-width="100px"
            :model="form"
        >
            <el-form-item label="Name">
                <el-input
                    v-model="form.name"
                    autocomplete="off"
                />
            </el-form-item>

            <el-form-item label="Username">
                <el-input
                    v-model="form.username"
                    autocomplete="off"
                />
            </el-form-item>

            <el-form-item label="Password">
                <el-input
                    v-model="form.password"
                    autocomplete="off"
                />
            </el-form-item>

            <el-form-item label="Url">
                <el-input
                    v-model="form.url"
                    autocomplete="off"
                />
            </el-form-item>

            <el-form-item label="Notes">
                <el-input
                    v-model="form.notes"
                    autocomplete="off"
                />
            </el-form-item>
        </el-form>

        <template #footer>
          <span class="dialog-footer">
            <el-button @click="resetModal">Cancel</el-button>
            <el-button type="primary">
              {{ props.isUpdating ? 'Save Changes' : 'Save Credential' }}
            </el-button>
          </span>
        </template>

    </el-dialog>
</template>

<script setup>
import {reactive, watch} from 'vue';

const props =  defineProps({
    credential: {
        type: Object,
        default: () => {}
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

})

const form = reactive({
    name: '',
    username: '',
    password: '',
    url: '',
    notes: '',
    item_type: '',
    folder_id: null,
});

const modal = {
    title: props.isUpdating ? 'Updating Credential' : 'Creating Credential',
    confirmBtnText: props.isUpdating ? 'Save Changes' : 'Save Credential',
    show: false
};

const resetModal = () => {
    props.closeModalHandler();

    form.name = '';
}

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