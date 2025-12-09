import { createRouter, createWebHistory } from 'vue-router';
import Registr from '../components/registr.vue';

const routes = [
    {
        path: '/register',
        name: 'Register',
        component: Registr // ✅ Компонент регистрации
    }
];

const router = createRouter({
    history: createWebHistory(),
    routes
});

export default router;
