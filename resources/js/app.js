import Vue from 'vue';
import VueRouter from 'vue-router';
import App from './views/App';
import Home from './views/Home';
import ProductCreate from './views/ProductCreate';
import CategoryManagement from './views/CategoryManagement';

Vue.use(VueRouter);

const router = new VueRouter({
    mode: 'history',
    routes: [
        {
            path: '/',
            name: 'home',
            component: Home
        },
        {
            path: '/product/create',
            name: 'createProduct',
            component: ProductCreate,
        },
        {
            path: '/categories',
            name: 'manageCategories',
            component: CategoryManagement,
        },
    ],
});

const app = new Vue({
    el: '#app',
    components: { App },
    router,
});
