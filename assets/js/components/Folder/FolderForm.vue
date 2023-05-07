<template>
    <el-dialog
        :close-on-click-modal="false"
        v-model="modal.show"
        @close="resetModal"
        :title="props.isUpdating ? 'Folder Updating' : 'Folder Creating'"
    >
        <el-form :model="form" @submit.prevent="handleSubmit">
            <el-form-item label="Name">
                <el-input
                    v-model="form.name"
                    autocomplete="off"
                />
            </el-form-item>

            <div class="dialog-footer-btns">
                <span class="dialog-footer">
                  <el-button @click="resetModal">Cancel</el-button>
                  <el-button type="primary" native-type="submit">
                    {{ props.isUpdating ? 'Save Changes' : 'Save Folder' }}
                  </el-button>
                </span>
            </div>
        </el-form>
    </el-dialog>
</template>

<script setup>
import {reactive, watch} from 'vue';

const props =  defineProps({
    folder: {
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
    id: null,
    name: ''
});

const modal = {
    title: props.isUpdating ? 'Updating Folder' : 'Creating Folder',
    confirmBtnText: props.isUpdating ? 'Save Changes' : 'Save Folder',
    show: false
};

const resetModal = () => {
    props.closeModalHandler();

    form.id = null;
    form.name = '';
}

const handleSubmit = () => {
    if (!props.isUpdating) {
        createFolder();
    } else {
        updateFolder();
    }
};

const createFolder = () => {
    const dataToSubmit = {
        action: 'create_folder',
        name: form.name
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


const updateFolder = () => {
    const dataToSubmit = {
        action: 'update_folder',
        id: form.id,
        name: form.name
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

watch(() => props.modalShow, (nv) => {
    modal.show = nv
});

watch(() => props.folder, (nv) => {
    if (!nv) {
        return;
    }

    form.id = nv.id;
    form.name = nv.folder;
});

</script>

<style scoped lang="scss">

</style>