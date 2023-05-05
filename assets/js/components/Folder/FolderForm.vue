<template>
    <el-dialog v-model="props.modalShow" title="Folder Create">
        <el-form :model="form">
            <el-form-item label="Name">
                <el-input v-model="form.name" autocomplete="off" />
            </el-form-item>
        </el-form>
        <template #footer>
          <span class="dialog-footer">
            <el-button>Cancel</el-button>
            <el-button type="primary">
              Confirm
            </el-button>
          </span>
        </template>
    </el-dialog>
</template>

<script setup>
import {reactive} from 'vue';

const props =  defineProps({
    modalShow: {
        type: Boolean,
        default: false
    },
})

const form = reactive({
    name: '',
})
</script>

<style scoped lang="scss">

</style>