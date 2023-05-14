import { createRouter, createWebHistory } from 'vue-router'

import LoginView from '../views/LoginView.vue'
import RegisterView from '../views/RegisterView.vue'

import GardenView from '../views/garden/GardenView.vue'

import AchatCoinsView from '../views/AchatCoinsView.vue'
import ResetPasswordView from '../views/ResetPasswordView.vue'
import SendEmailResetPasswordView from '../views/SendEmailResetPasswordView.vue'
import SuccessAchatView from '../views/SuccessAchatView.vue'
import ErrorAchatView from '../views/ErrorAchatView.vue'

import DevenirBloggerView from '../views/DevenirBloggerView.vue'

import BlogView from '../views/blog/BlogView.vue'
import MyBlogsView from '../views/blog/MyBlogsView.vue'
import BlogPostView from '../views/blog/BlogPostView.vue'
import BlogCreateView from '../views/blog/BlogCreateView.vue'

import PlanteView from '../views/PlanteView.vue'

import MarketView from '../views/market/MarketView.vue'
import MarketAddView from '../views/market/MarketAddView.vue'
import MarketEditView from '../views/market/MarketEditView.vue'
import MesVentesView from '../views/market/MesVentesView.vue'
import MesAchatsView from '../views/market/MesAchatsView.vue'

import AdminUsersView from '../views/admin/Users/AdminUsersView.vue';
import AdminUsersEditView from '../views/admin/Users/AdminUsersEditView.vue';

import AdminPlantesView from '../views/admin/Plantes/AdminPlantesView.vue';
import AdminPlantesEditView from '../views/admin/Plantes/AdminPlantesEditView.vue';

import AdminValidationBlogView from '../views/admin/Blogs/AdminValidationBlogView.vue';
import AdminBlogsView from '../views/admin/Blogs/AdminBlogsView.vue';

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
      path: '/plantes',
      name: 'plantes',
      component: PlanteView,
      beforeEnter: isAuthenticated,
    },
    {
      path: '/plantes/:id',
      name: 'plantes-create-blog',
      component: BlogCreateView,
      beforeEnter: isAuthenticated,
    },
    {
      path: '/blogs',
      name: 'blogs',
      component: BlogView,
      beforeEnter: isAuthenticated,
    },
    {
      path: '/blogs/:id',
      name: 'blogs-post',
      component: BlogPostView,
      beforeEnter: isAuthenticated
    },
    {
      path: '/mes-blogs',
      name: 'mes-blogs',
      component: MyBlogsView,
      beforeEnter: isAuthenticated,
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
      path: '/market',
      name: 'market',
      component: MarketView,
      beforeEnter: isAuthenticated
    },
    {
      path: '/market/add/:id',
      name: 'market-create',
      component: MarketAddView,
      beforeEnter: isAuthenticated
    },
    {
      path: '/market/edit/:id',
      name: 'market-edit',
      component: MarketEditView,
      beforeEnter: isAuthenticated
    },
    {
      path: '/market/ventes',
      name: 'market-ventes',
      component: MesVentesView,
      beforeEnter: isAuthenticated
    },
    {
      path: '/market/achats',
      name: 'market-achats',
      component: MesAchatsView,
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
      path: '/admin/blog',
      component: BaseRouterView,
      beforeEnter: isAuthenticatedAdmin,
      children: [
        {
          path: '',
          name: 'admin-blog',
          component: AdminBlogsView,
        },
        {
          path: 'edit/:id',
          name: 'admin-validation-blog',
          component: AdminValidationBlogView,
        }
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
