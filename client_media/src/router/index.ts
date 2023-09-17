import { createRouter, createWebHistory, RouteRecordRaw } from 'vue-router'


const routes: Array<RouteRecordRaw> = [
 
  {
    path: '/',
    redirect: to => {
      return { path: '/loginPage'}
    }
  },
  {
    path: '/home', 
    name: 'home',
    component: () => import('../views/HomePage.vue')
  },
  {
    path: '/posts', 
    name: 'posts',
    component: () => import('../views/PostPage.vue')
  },
  {
    path: '/comment/:id',
    name: 'comment',
    component: () => import('../views/CommentPage.vue')
  },
  {
    path: '/postDetail/:id',
    name: 'postDetail',
    component: () => import('../views/DetailPage.vue')
  },
  {
    path: '/loginPage',
    name: 'loginPage',
    component: () => import('../views/LoginPage.vue')
  },
  {
    path: '/registerPage',
    name: 'registerPage',
    component: () => import('../views/RegisterPage.vue')
  }
]

const router = createRouter({
  history: createWebHistory(process.env.BASE_URL),
  routes
})

export default router
