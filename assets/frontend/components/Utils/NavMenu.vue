<template>
    <el-menu
            :default-active="activeIndex"
            class="el-menu-demo"
            mode="horizontal"
            :router="true"
            :ellipsis="false"
            @select="handleSelect"
    >
        <el-menu-item index="/">
            Password Vault
        </el-menu-item>
        <div class="flex-grow" />
        <el-menu-item
                v-for="route in routes"
                :index="route.url"
        >
            {{ route.name }}
        </el-menu-item>
    </el-menu>
</template>

<script setup>
import {reactive, ref} from 'vue';
import {routes} from '../../utils/routeMap';
const activeIndex = ref('1');

const handleSelect = (key, keyPath) => {
    console.log(key, keyPath)
}
</script>

<style scoped lang="scss">
.flex-grow {
    flex-grow: 1;
}
</style>