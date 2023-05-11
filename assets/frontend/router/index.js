import {createRouter, createWebHashHistory} from 'vue-router';

import FolderMain from '../pages/Folder/Folder.vue';
import CredentialMain from '../pages/Credential/Credential.vue';
import Dashboard from '../pages/Dashboard.vue';
import PasswordGenerator from '../pages/Password/PasswordGenerator.vue';
import authenticated from '../middlewares/auth';
import Login from '../pages/Auth/Login.vue';
import Register from '../pages/Auth/Register.vue';

const routes = [
    {
        path: '/login',
        publicPath: '/',
        name: 'Login',
        component: Login,
    },
    {
        path: '/register',
        publicPath: '/',
        name: 'Register',
        component: Register,
    },
    {
        path: '/',
        publicPath: '/',
        name: 'Dashboard',
        component: Dashboard,
        // beforeEnter: (to, from, next) => {
        //     authenticated(to, from, next)
        // }
    },
    {
        path: '/folders',
        publicPath: '/',
        name: 'FolderMain',
        component: FolderMain,
        // beforeEnter: (to, from, next) => {
        //     authenticated(to, from, next)
        // }
    },

    {
        path: '/credentials',
        publicPath: '/',
        name: 'CredentialMain',
        component: CredentialMain,
        // beforeEnter: (to, from, next) => {
        //     authenticated(to, from, next)
        // }
    },
    {
        path: '/password',
        publicPath: '/',
        name: 'PasswordGenerator',
        component: PasswordGenerator,
        // beforeEnter: (to, from, next) => {
        //     authenticated(to, from, next)
        // }
    }
];

const router = createRouter({
    history: createWebHashHistory(),
    routes
})

export default router