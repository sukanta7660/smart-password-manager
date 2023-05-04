import {createRouter, createWebHashHistory} from 'vue-router';

import FolderMain from '../pages/Folder/Folder.vue';
import CredentialMain from '../pages/Credential/Credential.vue';

const routes = [
    {
        path: '/folders',
        publicPath: '/',
        name: 'FolderMain',
        component: FolderMain
    },

    {
        path: '/credentials',
        publicPath: '/',
        name: 'CredentialMain',
        component: CredentialMain
    }
];

const router = createRouter({
    history: createWebHashHistory(process.env.BASE_URL),
    mode: 'history',
    routes
})

export default router