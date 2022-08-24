import { createRouter, createWebHistory } from 'vue-router'
const routes = [
    {
        path: '/',
        name: 'Home',
        component: () => import("../views/home")
    },
    {
        path: '/about',
        name: 'About',
        component: () => import("../views/about")
    }
]
const router = createRouter({
    history: createWebHistory(process.env.BASE_URL),
    routes
})
export default router
