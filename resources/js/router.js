import { createRouter, createWebHistory } from "vue-router";

import Home from './pages/Home.vue'
import Dashboard from './pages/Dashboard.vue'
import DashboardApartments from './pages/DashboardApartments.vue'
import DashboardMessages from './pages/DashboardMessages.vue'
import Error404 from './pages/Error404.vue'

const router = createRouter({

    history: createWebHistory(),
    linkExactActiveClass: 'active',

    routes:[
        {
            path: '/',
            name: 'home',
            component: Home,
        },
        {
            path: '/my-apartments',
            name: 'my-apartments',
            component: Dashboard,

            children: [
              {
                path: '/my-apartments/apartments',
                name: 'apartments',
                component: DashboardApartments,
              },
              {
                path: '/my-apartments/messages',
                name: 'messages',
                component: DashboardMessages,
              },
            ]
        },

        {
            path: '/:pathMatch(.*)*',
            component: Error404,
        }
    ]

})

export { router }
