import {createRouter, createWebHashHistory} from 'vue-router';

import FolderMain from '../pages/Folder/Folder.vue';
import CredentialMain from '../pages/Credential/Credential.vue';
import Dashboard from '../pages/Dashboard.vue';
import PasswordGenerator from '../pages/Password/PasswordGenerator.vue';

const routes = [
    {
        path: '/',
        publicPath: '/',
        name: 'Dashboard',
        component: Dashboard
    },
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
    },
    {
        path: '/password',
        publicPath: '/',
        name: 'PasswordGenerator',
        component: PasswordGenerator
    }
];

const router = createRouter({
    history: createWebHashHistory(),
    routes
})

export default router