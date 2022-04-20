import Vue from 'vue'
import VueRouter, { RouteConfig } from 'vue-router'
import FirstPage from '@/pages/FirstPage.vue'
import DashBoard from '@/pages/DashBoard.vue'
import AxiosTest from '@/pages/AxiosTest.vue'
import SignIn from '@/pages/SignIn.vue'
import SignUp from '@/pages/SignUp.vue'

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
    },
    {
        path: '/DashBoard',
        name: 'DashBoard',
        component: DashBoard
    },
    {
        path: '/SignIn',
        name: 'SignIn',
        component: SignIn
    },
    {
        path: '/SignUp',
        name: 'SignUp',
        component: SignUp
    }
]

const router = new VueRouter({
    routes,
    mode: 'history'
})

export default router
