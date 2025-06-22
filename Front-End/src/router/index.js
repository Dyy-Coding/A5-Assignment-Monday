import { createRouter, createWebHistory } from 'vue-router'

// Book Components
import BookPage from '@/pages/BookPage.vue'
import BookDetail from '@/pages/bookComponent/BookDetail.vue'
import EditFormBook from '@/pages/bookComponent/EditFormBook.vue'

// Author Components
import AuthorPage from '@/pages/AuthorPage.vue'
import ShowDetail from '@/pages/authorComponent/ShowDetail.vue'
import EditAuthor from '@/pages/authorComponent/EditAuthor.vue'

// Member Components
import MemberPage from '@/pages/MemberPage.vue'
import MemberDetail from '@/pages/memberComponent/MemberDetail.vue'
import EditFormMember from '@/pages/memberComponent/EditFormMember.vue'

const routes = [
  // Redirect to books as homepage
  { path: '/', redirect: '/books' },

  // ✅ Book Routes (updated)
  { path: '/books', component: BookPage },
  {
    path: '/books/:id',
    name: 'BookDetail',
    component: BookDetail,
    props: route => ({
      bookId: route.params.id,
      books: [],      // Avoid prop warning
      search: ''      // Avoid prop warning
    }),
  },
  {
    path: '/books/:id/edit',
    name: 'EditFormBook',
    component: EditFormBook,
    props: route => ({ bookId: route.params.id }),
  },

  // Author Routes
  { path: '/authors', component: AuthorPage },
  {
    path: '/authors/:id',
    name: 'AuthorDetail',
    component: ShowDetail,
    props: route => ({ authorId: route.params.id }),
  },
  {
    path: '/authors/:id/edit',
    name: 'EditAuthor',
    component: EditAuthor,
    props: route => ({ authorId: route.params.id }),
  },

  // Member Routes
  { path: '/members', component: MemberPage },
  {
    path: '/members/:id',
    name: 'MemberDetail',
    component: MemberDetail,
    props: route => ({ memberId: route.params.id }),
  },
  {
    path: '/members/:id/edit',
    name: 'EditFormMember',
    component: EditFormMember,
    props: route => ({ memberId: route.params.id }),
  },
]

const router = createRouter({
  history: createWebHistory(),
  routes,
})

export default router
