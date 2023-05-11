import { createApp } from 'vue'
import App from './Layout/Main.vue';

import ElementPlus from 'element-plus';
import 'element-plus/dist/index.css';
import '../scss/custom.scss';

import VueClipboard from 'vue3-clipboard'

import router from './router';

const app = createApp(App, {});

app.use(router)
    .use(ElementPlus)
    .use(VueClipboard, {
        autoSetContainer: true,
        appendToBody: true
    })
    .mount('#user-platform');