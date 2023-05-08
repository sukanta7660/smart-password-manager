<template>
    <div class="password-generate">
        <Breadcrumb current-page="Password Generator"/>

        <el-row class="mt-4">
            <el-button
                type="primary">
                Add New
            </el-button>
        </el-row>

        <el-row :gutter="20" class="mt-4" style="width: 100%">
            <el-col :span="24">
                <el-card shadow="hover">
                    <el-row :gutter="20">
                        <b>What would you like to generate?</b>

                        <el-col :span="24">
                            <el-radio-group v-model="state.generationType">
                                <el-radio label="password">Password</el-radio>
                            </el-radio-group>
                        </el-col>
                    </el-row>

                    <el-row :gutter="20">
                        <b>Password Type?</b>

                        <el-col :span="24">
                            <el-radio-group v-model="state.passwordType">
                                <el-radio label="password">Password</el-radio>
                                <el-radio label="passphrase">Passphrase</el-radio>
                            </el-radio-group>
                        </el-col>

                        <el-collapse-transition>
                            <el-col
                                v-if="state.passwordType === 'password'"
                                :span="24"
                                class="mt-4"
                            >
                                <el-row :gutter="20">
                                    <el-col :span="8">
                                        <el-form-item label="Length">
                                            <el-input
                                                type="number"
                                                v-model.number="state.passwordGenerator.length"
                                                placeholder="Length"
                                            />
                                        </el-form-item>
                                    </el-col>

                                    <el-col :span="8">
                                        <el-form-item label="Minimum Number">
                                            <el-input
                                                type="number"
                                                v-model.number="state.passwordGenerator.minimumNumber"
                                                placeholder="Minimum number"
                                            />
                                        </el-form-item>
                                    </el-col>

                                    <el-col :span="8">
                                        <el-form-item label="Minimum Special Char">
                                            <el-input
                                                type="number"
                                                v-model.number="state.passwordGenerator.minimumSpecialCharacter"
                                                placeholder="Minimum special character"
                                            />
                                        </el-form-item>
                                    </el-col>
                                </el-row>

                                <el-row :gutter="20">
                                    <b class="mb-4">Options</b>
                                    <el-col :span="24">
                                        <el-checkbox
                                            v-model="state.passwordGenerator.options.uppercase"
                                            :label="passwordOptions.uppercase.label"
                                            :value="passwordOptions.uppercase.value"
                                            size="large"
                                        /> <br>
                                        <el-checkbox
                                            v-model="state.passwordGenerator.options.numbers"
                                            :label="passwordOptions.numbers.label"
                                            :value="passwordOptions.numbers.value"
                                            size="large"
                                        /> <br>
                                        <el-checkbox
                                            v-model="state.passwordGenerator.options.special"
                                            :label="passwordOptions.special.label"
                                            :value="passwordOptions.special.value"
                                            size="large"
                                        /> <br>
                                        <el-checkbox
                                            v-model="state.passwordGenerator.options.ambiguous"
                                            :label="passwordOptions.ambiguous.label"
                                            :value="passwordOptions.ambiguous.value"
                                            size="large"
                                        />
                                    </el-col>
                                </el-row>
                            </el-col>

                            <el-col
                                v-else
                                :span="24"
                                class="mt-4"
                            >
                                <el-row :gutter="20">
                                    <el-col :span="12">
                                        <el-form-item label="Number of Words">
                                            <el-input
                                                type="text"
                                                v-model.number="state.passPhraseGenerator.numberOfWords"
                                                placeholder="Number of Words"
                                            />
                                        </el-form-item>
                                    </el-col>

                                    <el-col :span="12">
                                        <el-form-item label="Separator">
                                            <el-input
                                                type="text"
                                                v-model="state.passPhraseGenerator.wordSeparator"
                                                placeholder="Separator"
                                            />
                                        </el-form-item>
                                    </el-col>
                                </el-row>

                                <el-row :gutter="20">
                                    <b class="mb-4">Options</b>
                                    <el-col :span="24">
                                        <el-checkbox
                                            v-model="state.passPhraseGenerator.capitalize"
                                            label="Capitalize"
                                            size="large"
                                        /> <br>
                                        <el-checkbox
                                            v-model="state.passPhraseGenerator.isIncludeNumber"
                                            label="Include Number"
                                            size="large"
                                        /> <br>
                                    </el-col>
                                </el-row>
                            </el-col>
                        </el-collapse-transition>
                    </el-row>
                </el-card>
            </el-col>
        </el-row>
    </div>
</template>

<script setup>
import Breadcrumb from '../../components/Utils/BreadCrumb.vue';
import {reactive} from 'vue';

const state = reactive({
    generationType: 'password',

    passwordType: 'password',

    passwordGenerator: {
        length: 14,
        minimumNumber: 1,
        minimumSpecialCharacter: 1,
        options: {
            uppercase: true,
            numbers: true,
            special: true,
            ambiguous: true
        }
    },
    passPhraseGenerator: {
        numberOfWords: 4,
        wordSeparator: '-',
        capitalize: false,
        isIncludeNumber: false
    },
});

const passwordOptions = {
    uppercase: {
        label: 'A-Z',
        value: true,
    },
    numbers: {
        label: '0-9',
        value: true,
    },
    special: {
        label: '!@#$%^&*',
        value: true,
    },
    ambiguous: {
        label: 'Avoid ambiguous characters',
        value: true,
    },
};
</script>

<style scoped lang="scss">

</style>