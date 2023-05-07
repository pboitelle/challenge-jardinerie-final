import { createRouter, createWebHistory } from 'vue-router'

import LoginView from '../views/LoginView.vue'
import RegisterView from '../views/RegisterView.vue'
import GardenView from '../views/GardenView.vue'
import AchatCoinsView from '../views/AchatCoinsView.vue'
import MarketView from '../views/MarketView.vue'
import ResetPasswordView from '../views/ResetPasswordView.vue'
import SendEmailResetPasswordView from '../views/SendEmailResetPasswordView.vue'
import SuccessAchatView from '../views/SuccessAchatView.vue'
import ErrorAchatView from '../views/ErrorAchatView.vue'
import DevenirBloggerView from '../views/DevenirBloggerView.vue'

import AdminUsersView from '../views/admin/Users/AdminUsersView.vue';
import AdminUsersEditView from '../views/admin/Users/AdminUsersEditView.vue';

import AdminPlantesView from '../views/admin/Plantes/AdminPlantesView.vue';
import AdminPlantesEditView from '../views/admin/Plantes/AdminPlantesEditView.vue';

import AdminValidationBlogView from '../views/admin/AdminValidationBlogView.vue';

import AdminDemandeBloggersView from '../views/admin/DemandeBloggers/AdminDemandeBloggersView.vue';

import BaseRouterView from '../views/admin/BaseRouterView.vue';
import AdminView from '../views/admin/AdminView.vue';

import { isAuthenticated, isAuthenticatedAdmin } from '../middleware/userAuth'

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
      path: '/success-achat',
      name: 'success-achat',
      component: SuccessAchatView,
      beforeEnter: isAuthenticated
    },
    {
      path: '/error-achat',
      name: 'error-achat',
      component: ErrorAchatView,
      beforeEnter: isAuthenticated
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
      path: '/devenir-blogger',
      name: 'devenir-blogger',
      component: DevenirBloggerView,
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
    {
      path: '/admin',
      component: BaseRouterView,
      beforeEnter: isAuthenticatedAdmin,
      children: [
        {
          path: '',
          name: 'admin',
          component: AdminView,
        },
      ],
    },
    {
      path: '/admin/users',
      component: BaseRouterView,
      beforeEnter: isAuthenticatedAdmin,
      children: [
        {
          path: '',
          name: 'admin-users',
          component: AdminUsersView,
        },
        {
          name: 'admin-users-edit',
          path: 'edit/:id',
          component: AdminUsersEditView,
        }
      ],
    },
    {
      path: '/admin/plantes',
      component: BaseRouterView,
      beforeEnter: isAuthenticatedAdmin,
      children: [
        {
          path: '',
          name: 'admin-plantes',
          component: AdminPlantesView,
        },
        {
          name: 'admin-plantes-edit',
          path: 'edit/:id',
          component: AdminPlantesEditView,
        }
      ],
    },
    {
      path: '/admin/validation-blog',
      component: BaseRouterView,
      beforeEnter: isAuthenticatedAdmin,
      children: [
        {
          path: '',
          name: 'admin-validation-blog',
          component: AdminValidationBlogView,
        },
      ],
    },
    {
      path: '/admin/demande-bloggers',
      component: BaseRouterView,
      beforeEnter: isAuthenticatedAdmin,
      children: [
        {
          path: '',
          name: 'admin-demande-bloggers',
          component: AdminDemandeBloggersView,
        }
      ],
    },
  ]
})

export default router
