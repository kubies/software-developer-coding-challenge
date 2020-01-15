import auctions from './views/auctions'
import login from "./views/login";
import register from "./views/register";
import create_auction from "./views/create_auction";
import user from './views/user'
import VueRouter from "vue-router";
import store from "./store";
import auction from "./views/auction";
const routes = [
  {
    path: '/',
    component: auctions,
    name: 'auctions'
  },
  {
    path: '/login',
    component: login,
    name: 'login'
  },
  {
    path: '/register',
    component: register,
    name: 'register'
  },
  {
    path: '/create',
    component: create_auction,
    name: 'create'
  },
  {
    path: '/auction/:auction_id',
    component: auction,
    name: 'auction'
  },
  {
    path: '/user/:user_id',
    component: user,
    name: 'user'
  }
]

const protected_routes = [
  '/create'
]

const router = new VueRouter({routes: routes})
router.beforeEach((to, from, next) => {
  if(store.getters.authenticated) {
    if (to.path === '/login' || to.path === '/register') {
      next({path: '/'})
    } else {
      const hasUser = store.getters.user !== null
      if (hasUser) {
        next()
      } else {
        store.dispatch('user/me')
        next()
      }
    }
  } else {
    if(protected_routes.indexOf(to.path) !== -1) {
      next('/login')
    } else {
      next()
    }
  }
})

export default router
