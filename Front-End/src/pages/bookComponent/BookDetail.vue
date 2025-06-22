<template>
  <div class="px-6 py-10 max-w-3xl mx-auto bg-white/80 backdrop-blur-md rounded-3xl shadow-2xl">
    <h1 class="text-3xl font-extrabold bg-gradient-to-r from-sky-400 to-indigo-600 text-transparent bg-clip-text mb-6 text-center">
      Book Detail 📖
    </h1>

    <div v-if="book" class="space-y-6">
      <!-- Image Preview -->
      <div v-if="book.image" class="flex justify-center">
        <img :src="book.image" alt="Book Cover"
             class="w-40 h-56 rounded-xl object-cover border-4 border-indigo-400 shadow-lg" />
      </div>

      <div class="grid gap-4 md:grid-cols-2">
        <div>
          <h3 class="text-sm font-semibold text-gray-500">Title</h3>
          <p class="text-lg text-gray-900">{{ book.title }}</p>
        </div>
        <div>
          <h3 class="text-sm font-semibold text-gray-500">Author</h3>
          <p class="text-lg text-gray-900">{{ book.author }}</p>
        </div>
        <div>
          <h3 class="text-sm font-semibold text-gray-500">Category</h3>
          <p class="text-lg text-gray-900">{{ book.category }}</p>
        </div>
        <div>
          <h3 class="text-sm font-semibold text-gray-500">Priority</h3>
          <p class="text-lg text-gray-900">{{ book.priority }}</p>
        </div>
        <div>
          <h3 class="text-sm font-semibold text-gray-500">Publication Year</h3>
          <p class="text-lg text-gray-900">{{ book.publication_year }}</p>
        </div>
        <div>
          <h3 class="text-sm font-semibold text-gray-500">Copies</h3>
          <p class="text-lg text-gray-900">{{ book.number_of_copies }}</p>
        </div>
      </div>

      <div class="pt-8 flex justify-center gap-4">
        <button
          @click="$router.push(`/books/${bookId}/edit`)"
          class="bg-sky-500 hover:bg-sky-600 text-white font-semibold px-6 py-3 rounded-xl shadow transition"
        >
          ✏️ Edit Book
        </button>
        <button
          @click="$router.push('/books')"
          class="bg-gray-100 hover:bg-gray-200 text-sky-600 font-semibold px-6 py-3 rounded-xl shadow transition"
        >
          🔙 Back to List
        </button>
      </div>
    </div>

    <div v-else class="text-center py-10 text-red-500 font-semibold">
      Failed to load book detail 😢
    </div>
  </div>
</template>

<script>
import axios from 'axios'

export default {
  props: {
    bookId: {
      type: [String, Number],
      required: true
    }
  },
  data() {
    return {
      book: null
    }
  },
  mounted() {
    axios.get(`http://localhost:8000/api/books/show/${this.bookId}`)
      .then(res => {
        const data = res.data.data || res.data.book || res.data
        this.book = {
          ...data,
          image: data.image ? `http://localhost:8000/${data.image}` : null
        }
      })
      .catch(err => {
        console.error('Failed to load book:', err)
      })
  }
}
</script>
