import { createRouter, createWebHistory } from 'vue-router'
const routes = [
  {
    path: '/',
    component: () => import('@/views/Fines.vue'),
    meta: {
      layout: 'main'
    }
  },
  {
    path: '/test',
    component: () => import('@/views/Test.vue'),
    meta: {
      layout: 'main'
    }
  },
]

const router = createRouter({
  history: createWebHistory(process.env.BASE_URL),
  routes
})

export default router
