/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');

window.Vue = require('vue').default;

/**
 * The following block of code may be used to automatically register your
 * Vue components. It will recursively scan this directory for the Vue
 * components and automatically register them with their "basename".
 *
 * Eg. ./components/ExampleComponent.vue -> <example-component></example-component>
 */

// const files = require.context('./', true, /\.vue$/i)
// files.keys().map(key => Vue.component(key.split('/').pop().split('.')[0], files(key).default))
// import vue router
import Vue from 'vue'
import VueRouter from 'vue-router'
import Profile from './Components/Profile.vue'
import Products from './Components/Products.vue'
import Main from './Components/Main.vue'
import Index from './Components/Index.vue'
import Search from './Components/Search.vue'
import ProductDetails from './Components/ProductDetails.vue'
import OrderDetail from './Components/OrderDetail.vue'
import ListOrder from './Components/ListOrder.vue'
import Category from './Components/Category.vue'
Vue.use(VueRouter);
window.axios = require('axios');
const router = new VueRouter({
    mode: 'history',
    routes: [{
            path: '/profile',
            name: 'Profile',
            component: Profile,
        },
        {
            path: '/product',
            name: 'Product',
            component: Main,
            children: [{
                    path: '/products',
                    name: 'Products',
                    component: Products,
                },

                {
                    path: '/index',
                    name: 'Home',
                    component: Index,
                },
                {
                    path: 'search/:keyword',
                    name: 'search',
                    component: Search,
                    props: true,
                },
                {
                    path: ':id',
                    name: 'ProductDetails',
                    component: ProductDetails,
                    props: true
                },
                {
                    path: '/category/:id',
                    name: 'Category',
                    component: Category,
                    props: true
                },
            ]
        },
        {
            path: '/order/:id',
            name: 'orderdetail',
            component: OrderDetail,
            props: true
        },
        {
            path: '/listorder',
            name: 'ListOrder',
            component: ListOrder,
        }

    ],
})

Vue.component('example-component', require('./components/ExampleComponent.vue').default);

/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */
Vue.prototype.eventBus = new Vue();
const app = new Vue({
    el: '#app',
    router,
});
