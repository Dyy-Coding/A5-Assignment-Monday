import { createRouter, createWebHistory } from 'vue-router'
import BookPage from '@/pages/BookPage.vue'
import AuthorPage from '@/pages/AuthorPage.vue'
import MemberPage from '@/pages/MemberPage.vue'
import ShowDetail from '@/pages/authorComponent/ShowDetail.vue'

const routes = [
  { path: '/', redirect: '/books' },
  { path: '/books', component: BookPage },
  { path: '/authors', component: AuthorPage },
  { 
    path: '/authors/:id', 
    name: 'AuthorDetail', 
    component: ShowDetail,
    // 👇 This line maps the route param `id` to the `authorId` prop
    props: route => ({ authorId: route.params.id })
  },
  { path: '/members', component: MemberPage },
]

const router = createRouter({
  history: createWebHistory(),
  routes,
})

export default router
