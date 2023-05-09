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
                <el-col :span="24">
                    <el-form-item
                            label="Password"
                            required
                            prop="password">
                        <el-input
                            type="password"
                            v-model="form.password"
                            autocomplete="off"
                        />
                        <el-collapse-transition>
                            <el-alert
                                v-if="form.error"
                                class="mt-4"
                                :title="form.error"
                                type="error"
                                :closable="false"/>
                        </el-collapse-transition>
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
import {reactive, ref, watch} from 'vue';

const props =  defineProps({
    modalShow: {
        type: Boolean,
        default: false
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

const masterPasswordForm = ref();

const state = reactive({});

const modal = {
    show: false
};

const form = reactive({
    password: null,
    error: null
});

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
    const dataToSubmit = {
        action: 'check_master_password',
        ...form
    }

    masterPasswordForm.value.validate((valid, fields) => {
        if (valid) {
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
        }
    })
    console.log({password: 'checked'});
};

const resetModal = () => {
    props.closeModalHandler();
    form.password = null;
};

watch(() => props.modalShow, (nv) => {
    modal.show = nv
});

watch(() => form.password, (nv) => {
    form.error = null;
});
</script>


<style scoped lang="scss">

</style>