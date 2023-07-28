import { createRouter, createWebHistory } from "vue-router";

import Home from './pages/Home.vue'
import AdvancedSearch from './pages/AdvancedSearch.vue'
import Dashboard from './pages/Dashboard.vue'
import DashboardApartments from './pages/dashboard-pages/DashboardApartments.vue'
import DashboardMessages from './pages/dashboard-pages/DashboardMessages.vue'
import DashboardStats from './pages/dashboard-pages/DashboardStats.vue'
import DashboardSponsorships from './pages/dashboard-pages/DashboardSponsorships.vue'
import ApartmentDetailAdmin from './pages/dashboard-pages/ApartmentDetailAdmin.vue'
import ApartmentDetailGuest from './pages/ApartmentDetailGuest.vue'
import Checkout from './pages/Checkout.vue'
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
            path: '/advanced-search',
            name: 'advanced-search',
            component: AdvancedSearch,
        },
        {
          path: '/apartment-detail/:slug',
          name: 'apartment-detail-guest',
          component: ApartmentDetailGuest,
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
                path: '/my-apartments/apartment-detail/:slug',
                name: 'apartment-detail-admin',
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
            path: '/checkout/:apartmentId/:id',
            name: 'Checkout',
            component: Checkout,
        },

        {
            path: '/:pathMatch(.*)*',
            component: Error404,
        }
    ]

});

// Memorizza l'ultima route visitata prima del refresh della pagina
let lastRoute = null;
window.addEventListener('beforeunload', () => {
  const currentRoute = router.currentRoute.value;
  if (currentRoute && currentRoute.name) {
    lastRoute = currentRoute.name;
  }
});

router.isReady().then(() => {
  // Reindirizza l'utente all'ultima route memorizzata dopo il completamento del caricamento del router
  if (lastRoute && store.user?.id) {
    router.push({ name: lastRoute });
  } else if (!store.user?.id && router.currentRoute.value.matched.some(record => record.meta.requiresAuth)) {
    // Se l'utente non è autenticato e sta cercando di accedere a una route protetta,
    // reindirizza l'utente alla home
    router.push({ name: 'home' });
  }
});

export { router }
