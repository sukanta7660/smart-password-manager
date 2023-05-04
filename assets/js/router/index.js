import { createRouter, createWebHistory } from 'vue-router';

import FolderMain from '../pages/Folder/Folder.vue';
import CredentialMain from '../pages/Credential/Credential.vue';

const routes = [
    {
        path: '/folders',
        name: 'FolderMain',
        component: FolderMain
    },

    {
        path: '/credentials',
        name: 'CredentialMain',
        component: CredentialMain
    }
];

const router = createRouter({
    history: createWebHistory(process.env.BASE_URL),
    routes
})

export default router