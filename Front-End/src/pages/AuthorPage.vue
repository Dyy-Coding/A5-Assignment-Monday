<template>
  <div class="px-4 py-6 sm:px-0">
    <div class="bg-white shadow rounded-lg p-6">
      <!-- Header with title and add button -->
      <div class="flex justify-between items-center mb-6">
        <h1 class="text-2xl font-bold text-gray-800 flex items-center">
          <span class="material-icons mr-2">person</span> Our Authors
        </h1>
        <button 
          @click="showAddForm = true"
          class="bg-indigo-600 hover:bg-indigo-700 text-white px-4 py-2 rounded-lg flex items-center transition duration-200"
        >
          <span class="material-icons mr-1">add</span> Add Author
        </button>
      </div>

      <!-- Search input -->
      <div class="mb-6">
        <div class="relative flex-grow max-w-lg">
          <span class="material-icons absolute left-3 top-3 text-gray-400">search</span>
          <input
            v-model="search"
            type="text"
            placeholder="Search authors by name..."
            class="pl-10 pr-4 py-2 w-full border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 shadow-sm transition duration-200"
          />
        </div>
      </div>

      <!-- Add Author Form -->
      <CreateForm 
        v-if="showAddForm"
        @close="showAddForm = false"
        @author-added="handleAuthorAdded"
      />

      <!-- Author Grid Display -->
      <DataShowGrid 
        :authors="authors"
        :search="search"
        @view-profile="handleViewProfile"
      />
    </div>
  </div>
</template>

<script>
import axios from 'axios'
import CreateForm from './authorComponent/CreateForm.vue'
import DataShowGrid from './authorComponent/DataShowGrid.vue'

export default {
  components: { CreateForm, DataShowGrid },
  data() {
    return {
      authors: [], // Will be populated from API
      search: '',
      showAddForm: false,
    }
  },
  methods: {
    // Fetch authors from API and parse book data
    async fetchAuthors() {
      try {
        const res = await axios.get('http://127.0.0.1:8000/api/authors')

        // Check if response is wrapped in { data: [...] }
        const authorsRaw = Array.isArray(res.data) ? res.data : res.data.data
        console.log(res.data);

        // Parse books from JSON string if needed
        this.authors = authorsRaw.map(author => ({
          ...author,
          books: typeof author.books === 'string'
            ? JSON.parse(author.books)
            : (author.books || [])
        }))
        
      } catch (err) {
        console.error('Error fetching authors:', err)
      }
    },

    // Handle new author added from CreateForm
    handleAuthorAdded(newAuthor) {
      const parsedAuthor = {
        ...newAuthor,
        books: typeof newAuthor.books === 'string'
          ? JSON.parse(newAuthor.books)
          : (newAuthor.books || [])
      }
      this.authors.push(parsedAuthor)
      this.showAddForm = false
    },

    // Navigate to author profile
    handleViewProfile(authorId) {
      this.$router.push({ name: 'AuthorDetail', params: { id: authorId } })
    }
  },

  // Lifecycle hook: fetch data on mount
  mounted() {
    this.fetchAuthors()
  }
}
</script>
