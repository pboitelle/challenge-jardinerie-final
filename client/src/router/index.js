import { createRouter, createWebHistory } from 'vue-router'

import LoginView from '../views/LoginView.vue'
import RegisterView from '../views/RegisterView.vue'
import GardenView from '../views/GardenView.vue'
import AchatCoinsView from '../views/AchatCoinsView.vue'
import MarketView from '../views/MarketView.vue'
import ResetPasswordView from '../views/ResetPasswordView.vue'
import SendEmailResetPasswordView from '../views/SendEmailResetPasswordView.vue'

import { isAuthenticated } from '../middleware/userAuth'

const router = createRouter({
  history: createWebHistory(import.meta.env.BASE_URL),
  routes: [
    {
      path: '/',
      name: 'login',
      component: LoginView
    },
    {
      path: '/register',
      name: 'register',
      // route level code-splitting
      // this generates a separate chunk (About.[hash].js) for this route
      // which is lazy-loaded when the route is visited.
      component: RegisterView
    },
    {
      path: '/reset-password/:token',
      name: 'reset-password',
      component: ResetPasswordView,
    },
    {
      path: '/send-email-password',
      name: 'send-email-password',
      component: SendEmailResetPasswordView,
    },
    {
      path: '/blog',
      name: 'blog',
      component: () => import('../views/BlogView.vue'),
      beforeEnter: isAuthenticated
    },
    {
      path: '/garden',
      name: 'garden',
      component: GardenView,
      beforeEnter: isAuthenticated
    },
    {
      path: '/coins',
      name: 'coins',
      component: AchatCoinsView,
      beforeEnter: isAuthenticated
    },
    {
      path: '/blog/:id',
      name: 'blog-post',
      component: () => import('../views/BlogPostView.vue'),
      beforeEnter: isAuthenticated
    },
    {
      path: '/market',
      name: 'market',
      component: MarketView,
      beforeEnter: isAuthenticated
    },
  ]
})

export default router
