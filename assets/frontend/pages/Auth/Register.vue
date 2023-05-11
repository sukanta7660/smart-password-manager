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
            <el-form class="auth-form">
                <el-form-item label="Username">
                    <el-input v-model="username" placeholder="Enter your username"></el-input>
                </el-form-item>
                <el-form-item label="Password">
                    <el-input v-model="password" placeholder="Enter your password" type="password"></el-input>
                </el-form-item>
                <el-form-item class="form-footer">
                    <el-button type="primary" @click="login">Register</el-button>
                </el-form-item>
            </el-form>
        </el-card>
    </div>
</template>

<script setup>

import {reactive} from "vue";

const state = reactive({});

const form = reactive({
    name: null,
    username: null,

});

</script>

<style scoped lang="scss">
.card-header {
    display: flex;
    justify-content: space-between;
    align-items: center;
}
</style>