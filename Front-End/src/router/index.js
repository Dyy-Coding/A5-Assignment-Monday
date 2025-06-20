import { createRouter, createWebHistory } from 'vue-router'
import BookPage from '@/pages/BookPage.vue'
import AutherPage from '@/pages/AutherPage.vue'
import MemberPage from '@/pages/MemberPage.vue'

const routes = [
  { path: '/books', component: BookPage },
  { path: '/authors', component: AutherPage },
  { path: '/members', component: MemberPage },
]

const router = createRouter({
  history: createWebHistory(),
  routes,
})

export default router
