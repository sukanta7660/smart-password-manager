<template>
    <div class="password-generate">
        <Breadcrumb current-page="Password Generator"/>

        <el-row :gutter="20" class="mt-4" style="width: 100%">
            <el-col :span="24">
                <el-card shadow="always">
                    <el-row :gutter="20">
                        <el-col :span="24" class="aligncenter">
                            <el-button text @click="copyToClipboard">
                                {{ state.passwordType === 'password' ? state.generatedPassword : state.generatedPassPhrase }}
                            </el-button>
                        </el-col>
                    </el-row>
                </el-card>
            </el-col>
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

                        <el-col :span="24">
                            <el-button @click="handleGenerate">Generate Password</el-button>
                            <el-button @click="copyToClipboard">Copy Password</el-button>
                        </el-col>
                    </el-row>
                </el-card>
            </el-col>
        </el-row>
    </div>
</template>

<script setup>
import {onMounted, reactive, watch} from 'vue';
import Breadcrumb from '../../components/Utils/BreadCrumb.vue';
import {CHARACTER_SET, POSSIBLE_CHARACTER_SET, WORD_LIST} from '../../utils/constants';
import { ElNotification } from 'element-plus'
import { copyText } from 'vue3-clipboard';
import { notify } from '../../utils/helpers';

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

    generatedPassword: null,
    generatedPassphrase: null,
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

const generatePassword = () => {
    let generatedPassword = '';
    let numberOfSpecialChar = 0;
    let numberOfNumericChar = 0;
    let options = state.passwordGenerator.options;
    while (generatedPassword.length < state.passwordGenerator.length) {
        let randomIndex = Math.floor(Math.random() * POSSIBLE_CHARACTER_SET.length);
        let characters = POSSIBLE_CHARACTER_SET.charAt(randomIndex);

        if (options.numbers) {
            characters = Math.random() > 0.5 ? characters + Math.floor(Math.random() * 10) : characters;
            if (!isNaN(parseInt(characters))) {
                numberOfNumericChar++;
            }
        }

        if (options.uppercase) {
            characters = Math.random() > 0.5 ? characters.toUpperCase() : characters;
        }

        if (options.special) {
            if (options.special && CHARACTER_SET.symbol.indexOf(characters) !== -1) {
                numberOfSpecialChar++;
            }
        }

        if (!options.ambiguous) {
            characters = "{}[]()/\"'`<>,;:.?\\|"
        }

        if (options.special && numberOfSpecialChar < state.passwordGenerator.minimumSpecialCharacter) {
            let diff = state.passwordGenerator.minimumSpecialCharacter - numberOfSpecialChar;
            for (let i = 0; i < diff; i++) {
                let randomSpecialCharIndex = Math.floor(Math.random() * CHARACTER_SET.symbol.length);
                generatedPassword = generatedPassword
                    .slice(0, randomSpecialCharIndex) + CHARACTER_SET.symbol
                    .charAt(randomSpecialCharIndex) + generatedPassword
                    .slice(randomSpecialCharIndex);
            }
        }

        if (options.numbers && numberOfNumericChar < state.passwordGenerator.minimumNumber) {
            let diff = state.passwordGenerator.minimumNumber - numberOfNumericChar;
            for (let i = 0; i < diff; i++) {
                let randomNumberIndex = Math.floor(Math.random() * (generatedPassword.length - 1));
                let randomNumber = Math.floor(Math.random() * 10);
                generatedPassword = generatedPassword
                    .slice(0, randomNumberIndex) + randomNumber + generatedPassword
                    .slice(randomNumberIndex);
            }
        }
        generatedPassword += characters;
    }
    state.generatedPassword = generatedPassword;

};

const generatePassphrase = () => {
    let generatedPassword = '';
    let options = state.passPhraseGenerator;
    for (let i = 0; i < options.numberOfWords; i++) {
        let word = options.capitalize
            ? WORD_LIST[Math.floor(Math.random() * WORD_LIST.length)].charAt(0).toUpperCase() + WORD_LIST[Math.floor(Math.random() * WORD_LIST.length)].slice(1) :
            WORD_LIST[Math.floor(Math.random() * WORD_LIST.length)].charAt(0).toLowerCase() + WORD_LIST[Math.floor(Math.random() * WORD_LIST.length)].slice(1);
        generatedPassword += word;
        if (i < options.numberOfWords - 1) {
            generatedPassword += options.wordSeparator;
        }
    }
    if (options.isIncludeNumber) {
        const splitPhrase = generatedPassword.split(options.wordSeparator);
        const randomIndex = Math.floor(Math.random() * splitPhrase.length);
        const randomNum = Math.floor(Math.random() * 10);
        splitPhrase[randomIndex] = splitPhrase[randomIndex] + randomNum;
        generatedPassword = splitPhrase.join(options.wordSeparator);
    }
    state.generatedPassPhrase = generatedPassword;
};


const handleGenerate = () => {
    state.passwordType === 'password' ? generatePassword() : generatePassphrase();
};

const copyToClipboard = () => {
    let textToCopy = state.passwordType === 'password' ? state.generatedPassword : state.generatedPassPhrase;
    copyText(textToCopy, undefined, (error, event) => {
        if (error) {
            notify('error', 'Can not copy')
        } else {
            notify('success', 'Password copied');
        }
    })
};

watch(state.passwordGenerator, () => {
    if (state.passwordType === 'password') {
        generatePassword();
    }
});

watch(state.passPhraseGenerator, () => {
    if (state.passwordType === 'passphrase') {
        generatePassphrase();
    }
});

onMounted(() => {
    generatePassword();
    generatePassphrase();
})
</script>

<style scoped lang="scss">

</style>