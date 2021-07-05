import Vue from 'vue'
import Router from 'vue-router'
import HelloWorld from '@/components/HelloWorld'
import Login from '@/components/Login'
import Profile from '@/components/Profile'
Vue.use(Router)

export default new Router({
    routes: [{
            path: '/',
            name: 'HelloWorld',
            component: HelloWorld
        },
        {
            path: '/login',
            name: 'Login',
            component: Login
        },
        {
            path: '/index',
            component: () => import('@/components/Index.vue')
        },
        {
            path: '/profile',
            component: () => import('@/components/Profile.vue')
        },
        {
            path: '/product',
            component: () => import('@/components/product.vue')
        }
    ]
})
