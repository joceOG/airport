import Vue from 'vue'
import VueRouter, { RouteConfig } from 'vue-router'
import FirstPage from '@/pages/FirstPage.vue'
import AxiosTest from '@/pages/AxiosTest.vue'

Vue.use(VueRouter)

const routes: Array<RouteConfig> = [
    {
        path: '/',
        name: 'FirsPage',
        component: FirstPage
    },
    {
        path: '/AxiosTest',
        name: 'AxiosTest',
        component: AxiosTest
    }
]

const router = new VueRouter({
    routes,
    mode: 'history'
})

export default router
