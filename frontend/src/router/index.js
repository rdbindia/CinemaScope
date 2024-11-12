import {createRouter, createWebHistory} from 'vue-router'
import TopSales from "../components/TopSales.vue";
import TheaterTrend from "../components/TheaterTrend.vue";

const router = createRouter({
    history: createWebHistory(import.meta.env.BASE_URL),
    routes: [
        {
            path: '/',
            name: 'TopSales',
            component: TopSales
        },
        {
            path: '/trend',
            name: 'TheaterTrend',
            component: TheaterTrend,
        },
    ]
})

export default router
