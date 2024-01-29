// src/router/index.js
import { createRouter, createWebHistory } from "vue-router";
import RegistrationForm from '../RegistrationForm.vue';
import LoginForm from '../LoginForm.vue';


const router = createRouter({
    history: createWebHistory(),
    routes:[
        {
            path: '/register',
            name: 'Register',
            component: RegistrationForm,
        },
        {
            path: '/login',
            name: 'Login',
            component: LoginForm,
        },
    ],
});



export default router;


