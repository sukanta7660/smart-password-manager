<template>
    <router-view></router-view>
</template>

<script setup>
import {reactive} from 'vue';

const state = reactive({
    txt: 'Main'
});

</script>

<style scoped>
.nav-links {
    display: inline-block;
    padding: 18px;
    background: #ccc;
    text-align: center;
}
</style>