<template>
  <div>
      <div class="nav-links">
          <router-link to="/folders">Folder</router-link>
          <router-link to="/credentials">Credential</router-link>
      </div>
      <router-view></router-view>
  </div>
</template>

<script setup>
import {reactive, toRef} from 'vue';

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