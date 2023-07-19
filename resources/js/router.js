import { createRouter, createWebHistory } from "vue-router";

import Home from './pages/Home.vue'
import Dashboard from './pages/Dashboard.vue'
import DashboardApartments from './pages/dashboard-pages/DashboardApartments.vue'
import DashboardMessages from './pages/dashboard-pages/DashboardMessages.vue'
import DashboardStats from './pages/dashboard-pages/DashboardStats.vue'
import DashboardSponsorships from './pages/dashboard-pages/DashboardSponsorships.vue'
import ApartmentDetailAdmin from './pages/dashboard-pages/ApartmentDetailAdmin.vue'
import Error404 from './pages/Error404.vue'
import { store } from './store/store'
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

            beforeEnter: (to, from, next) => {
              if(store.user?.id){
                // store.errors = null;
                return next()
              }else {
                // store.errors = 'Per accedere a questa rotta bisogna essere loggati.'
                return next('/')

              }
            },

            children: [
              {
                path: '/my-apartments/apartments',
                name: 'apartments',
                component: DashboardApartments,
              },
              {
                path: '/my-apartments/apartment-detail',
                name: 'apartment-detail',
                component: ApartmentDetailAdmin,
              },
              {
                path: '/my-apartments/messages',
                name: 'messages',
                component: DashboardMessages,
              },
              {
                path: '/my-apartments/stats',
                name: 'stats',
                component: DashboardStats,
              },
              {
                path: '/my-apartments/sponsorships',
                name: 'sponsorships',
                component: DashboardSponsorships,
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
