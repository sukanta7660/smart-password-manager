<template>
  <div>
      <h1>Folder {{ state.txt }}</h1>
  </div>
</template>

<script>
import {reactive, toRef} from 'vue';

export default {
    name: 'FolderMain',
    components: {},

    setup() {
        const state = reactive({
            txt: 'Main'
        });
        return {
            state
        }
    }
}
</script>

<style scoped>

</style>