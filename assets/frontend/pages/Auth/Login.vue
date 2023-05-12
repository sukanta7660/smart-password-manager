<template>
    <div class="custom-container">
        <el-card class="box-card">
            <template #header>
                <div class="card-header">
                    <span>Login</span>
                    <span>
                        Don't have an account? Please
                        <router-link type="text" to="/register">
                          Register
                        </router-link>
                    </span>
                </div>
            </template>
            <el-form
                ref="loginForm"
                :model="form"
                :rules="rules"
                @submit.prevent="handleLogin"
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
                <el-form-item label="Password" required prop="password">
                    <el-input
                        v-model="form.password"
                        placeholder="Enter your password"
                        type="password"
                    />
                </el-form-item>
                <el-form-item>
                    <el-checkbox label="Remember me" v-model="form.remember"/>
                </el-form-item>
                <el-form-item class="form-footer">
                    <el-button
                        type="primary"
                        :loading="state.isLoading"
                        native-type="submit">
                        Login
                    </el-button>
                </el-form-item>
            </el-form>
        </el-card>
    </div>
</template>

<script setup>

import {reactive, ref, watch} from 'vue';
import {notify} from "../../utils/helpers";

const state = reactive({
    isLoading: false,
    error: null
});

const form = reactive({
    username: null,
    password: null,
    remember: false
});

const loginForm = ref();


const rules = reactive({
    username: [
        {
            required: true,
            message: 'Please input username',
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

const handleLogin = () => {
    state.isLoading = true;
    loginForm.value.validate((valid, fields) => {
        if (valid) {
            formSubmit();
        }else {
            state.isLoading = false;
        }
    })
};

const formSubmit = async () => {
    const dataToSubmit = {
        action: 'login',
        ...form
    }

    const ajaxUrl = window.ajax_object.ajax_url;

    await window.jQuery.ajax({
        url: ajaxUrl,
        data: dataToSubmit,
        method: 'POST'
    }).done((response) => {
        if (response) {
            state.isLoading = false;
            notify('success', 'Login Successful');
            window.location.reload();
        }

    }).fail((error) => {
        state.error = error?.responseJSON?.message;
        state.isLoading = false;
    });
};

watch(() => form.username || form.password, (nv) => {
    state.error = null;
})

</script>

<style scoped lang="scss">
.card-header {
    display: flex;
    justify-content: space-between;
    align-items: center;
}
</style>