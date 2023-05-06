<template>
    <el-dialog
            v-model="modal.show"
            @close="resetModal"
            :title="props.isUpdating ? 'Folder Updating' : 'Folder Creating'">

        <el-form :model="form">
            <el-form-item label="Name">
                <el-input
                    v-model="form.name"
                    autocomplete="off"
                />
            </el-form-item>
        </el-form>

        <template #footer>
          <span class="dialog-footer">
            <el-button @click="resetModal">Cancel</el-button>
            <el-button type="primary">
              {{ props.isUpdating ? 'Save Changes' : 'Save Folder' }}
            </el-button>
          </span>
        </template>

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
    name: ''
});

const modal = {
    title: props.isUpdating ? 'Updating Folder' : 'Creating Folder',
    confirmBtnText: props.isUpdating ? 'Save Changes' : 'Save Folder',
    show: false
};

const resetModal = () => {
    props.closeModalHandler();

    form.name = '';
}

watch(() => props.modalShow, (nv) => {
    modal.show = nv
});

watch(() => props.folder, (nv) => {
    if (!nv) {
        return;
    }

    form.name = nv.folder
});

</script>

<style scoped lang="scss">

</style>