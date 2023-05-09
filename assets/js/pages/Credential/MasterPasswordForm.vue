<template>
    <el-dialog
            :close-on-click-modal="false"
            v-model="modal.show"
            @close="resetModal"
            title="Master Password Check"
    >

        <el-form
                ref="masterPasswordForm"
                :model="form"
                :rules="rules"
                label-width="100px"
                @submit.prevent="handleSubmit"
        >
            <el-row :gutter="20" style="width: 100%">

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
import {reactive, watch} from 'vue';

const props =  defineProps({
    modalShow: {
        type: Boolean,
        default: false
    },
    closeModalHandler: {
        type: Function,
        default: () => {}
    }
});

const state = reactive({

});

const modal = {
    show: false
};

const form = reactive({});

const rules = reactive({
    password: [
        {
            required: true,
            message: 'Please input master password',
            trigger: 'blur'
        }
    ],
})

const handleSubmit = () => {
    console.log({password: 'checked'});
};

const resetModal = () => {
    props.closeModalHandler();
};

watch(() => props.modalShow, (nv) => {
    modal.show = nv
});
</script>


<style scoped lang="scss">

</style>