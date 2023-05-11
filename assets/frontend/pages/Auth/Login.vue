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
            <el-form class="auth-form">
                <el-form-item label="Username">
                    <el-input v-model="username" placeholder="Enter your username"></el-input>
                </el-form-item>
                <el-form-item label="Password">
                    <el-input v-model="password" placeholder="Enter your password" type="password"></el-input>
                </el-form-item>
                <el-form-item class="form-footer">
                    <el-button type="primary" @click="login">Login</el-button>
                </el-form-item>
            </el-form>
        </el-card>
    </div>
</template>

<script setup>

</script>

<style scoped lang="scss">
.card-header {
    display: flex;
    justify-content: space-between;
    align-items: center;
}
</style>