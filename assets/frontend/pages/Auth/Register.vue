<template>
    <div class="custom-container">
        <el-card class="box-card">
            <template #header>
                <div class="card-header">
                    <span>Register</span>
                    <span>
                        Already have an account? Please
                        <router-link type="text" to="/login">
                          Login
                        </router-link>
                    </span>
                </div>
            </template>
            <el-form
                ref="registerForm"
                :model="form"
                :rules="rules"
                @submit.prevent="handleRegister"
                class="auth-form"
                label-position="top"
            >
                <el-alert
                    v-if="state.error"
                    class="mt-4 mb-4"
                    :title="state.error"
                    type="error"
                    :closable="false"
                />

                <el-form-item label="Username" required prop="username">
                    <el-input
                        v-model="form.username"
                        placeholder="Enter your username"
                    />
                </el-form-item>
                <el-form-item label="Email" required prop="email">
                    <el-input
                        type="email"
                        v-model="form.email"
                        placeholder="Enter your Email"
                    />
                </el-form-item>
                <el-form-item label="Password" required prop="password">
                    <el-input
                        v-model="form.password"
                        placeholder="Enter your password"
                        type="password"
                    />
                </el-form-item>
                <el-form-item class="form-footer">
                    <el-button
                        type="primary"
                        :loading="state.isLoading"
                        native-type="submit">
                        Register
                    </el-button>
                </el-form-item>
            </el-form>
        </el-card>
    </div>
</template>

<script setup>

import {reactive, ref} from "vue";
import {notify} from "../../utils/helpers";

const state = reactive({
    isLoading: false
});

const form = reactive({
    username: null,
    email: null,
    password: null
});

const registerForm = ref();


const rules = reactive({
    username: [
        {
            required: true,
            message: 'Please input username',
            trigger: 'blur'
        }
    ],
    email: [
        {
            required: true,
            message: 'Please input email',
            trigger: 'blur'
        }
    ],
    password: [
        {
            required: true,
            message: 'Please input password',
            trigger: 'blur'
        }
    ]
});

const handleRegister = () => {
    state.isLoading = true;
    registerForm.value.validate((valid, fields) => {
        if (valid) {
            state.isLoading = false;
            formSubmit();
        }else {
            state.isLoading = false;
        }
    })
};

const formSubmit = async () => {
    const dataToSubmit = {
        action: 'register',
        ...form
    }

    const ajaxUrl = window.ajax_object.ajax_url;

    await window.jQuery.ajax({
        url: ajaxUrl,
        data: dataToSubmit,
        method: 'POST'
    }).done((response) => {
        console.info(response)

    }).fail((error) => {
        console.warn('check');
    });
};

</script>

<style scoped lang="scss">
.card-header {
    display: flex;
    justify-content: space-between;
    align-items: center;
}
</style>