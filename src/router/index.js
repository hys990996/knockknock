import { createRouter, createWebHistory } from 'vue-router'
import Home from '@/views/home.vue'


const routes = [
    {
        // 前台 首頁
        path: '/',
        name: 'home',
        component: Home
    },
    {
        // 前台 聊天大廳
        path: '/chatting_room',
        name: 'chatting_room',
        component: () => import('../views/chatting_room.vue')
    },
    {
        // 前台 遊樂場
        path: '/playground',
        name: 'playground',
        component: () => import('../views/playground.vue')
    },
    {
        // 前台 主題活動
        path: '/activity',
        name: 'activity',
        component: () => import('../views/activity.vue')
    },
    {
        // 前台 關於我們
        path: '/about-us',
        name: 'about-us',
        component: () => import('../views/about_us.vue')
    },
    {
        // 前台 我有問題
        path: '/customer-service',
        name: 'service',
        component: () => import('../views/service.vue')
    },

]


const router = createRouter({
    history: createWebHistory(),
    routes
})



export default router

