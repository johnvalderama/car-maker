import Vue from 'vue'
import VueRouter from 'vue-router'
import store from '../store'
import Admin from '../components/Admin'
import Login from '../components/Login'
import Cars from '../components/Cars'

Vue.use(VueRouter)
const routes = [
  {
    path: '/admin',
    name: 'Admin',
    component: Admin
  },
  {
    path: '/login',
    name: "Login",
    component: Login,
    meta: { guest: true },
  },
  {
    path: '/cars',
    name: "Cars",
    component: Cars,
    meta: {requiresAuth: true},
  }
]
const router = new VueRouter({
  mode: 'history',
  base: process.env.BASE_URL,
  routes
})

router.beforeEach((to, from, next) => {
  if(to.matched.some(record => record.meta.requiresAuth)) {
    if (store.getters.isAuthenticated) {
      next()
      return
    }
    next('/login')
  } else {
    next()
  }
})

export default router