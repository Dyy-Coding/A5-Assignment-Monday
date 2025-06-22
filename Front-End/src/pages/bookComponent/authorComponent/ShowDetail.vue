<template>
  <div class="px-4 py-10 max-w-4xl mx-auto bg-gradient-to-br from-purple-100 via-pink-100 to-yellow-100 rounded-3xl shadow-2xl transition-all duration-500">
    <!-- Loading -->
    <div v-if="loading" class="flex flex-col items-center justify-center py-20 animate-pulse">
      <span class="material-icons animate-spin text-pink-500 text-6xl mb-4">autorenew</span>
      <p class="text-xl font-semibold text-pink-600">Loading author details...</p>
    </div>

    <!-- Author Details -->
    <div
      v-else-if="author"
      class="bg-white rounded-2xl p-8 shadow-xl hover:shadow-2xl transition-all duration-300"
    >
      <h1 class="text-4xl font-black text-transparent bg-clip-text bg-gradient-to-r from-blue-400 to-indigo-600 mb-8">
        {{ author.name || 'N/A' }}
      </h1>

      <div class="flex flex-col md:flex-row items-center gap-8">
        <img
          v-if="author.image_url"
          :src="author.image_url"
          alt="Author Image"
          class="w-48 h-48 rounded-xl shadow-md object-cover border-4 border-blue-400 hover:scale-105 transition-transform duration-300"
        />
        <div class="flex-1 space-y-3 text-gray-700 text-lg">
          <p><span class="font-semibold text-sky-600">Name:</span> {{ author.name }}</p>
          <p><span class="font-semibold text-sky-600">Date of Birth:</span> {{ formatDate(author.dateofbirth) }}</p>
          <p><span class="font-semibold text-sky-600">Nationality:</span> {{ author.nationality }}</p>
          <p><span class="font-semibold text-sky-600">Number of Books:</span> {{ author.numberOfWrittenBook }}</p>
        </div>
      </div>

      <!-- Actions -->
      <div class="mt-10 flex flex-wrap gap-4 justify-center md:justify-start">
        <button
          @click="$router.push('/authors')"
          class="px-6 py-3 rounded-lg font-bold text-white bg-sky-500 hover:bg-sky-600 shadow-md"
        >
          Back
        </button>
        <button
          @click="editAuthor"
          class="px-6 py-3 rounded-lg font-bold text-white bg-yellow-500 hover:bg-yellow-600 shadow-md"
        >
          Edit
        </button>
        <button
          @click="deleteAuthor"
          class="px-6 py-3 rounded-lg font-bold text-white bg-red-600 hover:bg-red-700 shadow-md"
        >
          Delete
        </button>
      </div>
    </div>

    <!-- Error -->
    <div v-else class="text-center py-20 text-gray-600 font-bold text-lg">
      <span class="material-icons text-5xl text-gray-400 mb-4">error_outline</span>
      <p>Author details could not be loaded.</p>
    </div>
  </div>
</template>

<script>
import axios from 'axios'

export default {
  props: {
    authorId: {
      type: [String, Number],
      required: true
    }
  },
  data() {
    return {
      author: null,
      loading: false
    }
  },
  methods: {
    async fetchAuthor() {
      this.loading = true
      try {
        const response = await axios.get(`http://127.0.0.1:8000/api/authors/show/${this.authorId}`)
        const authorData = response.data.data
        authorData.image_url = authorData.image ? `http://127.0.0.1:8000/${authorData.image}` : null
        this.author = authorData
      } catch (error) {
        console.error('Error loading author details:', error)
        this.author = null
      } finally {
        this.loading = false
      }
    },
    formatDate(dateStr) {
      if (!dateStr) return 'N/A'
      const d = new Date(dateStr)
      return isNaN(d) ? 'N/A' : d.toLocaleDateString()
    },
    editAuthor() {
      this.$router.push({ name: 'EditAuthor', params: { id: this.authorId } })
    },
    async deleteAuthor() {
      if (!confirm('Are you sure you want to delete this author?')) return
      try {
        await axios.delete(`http://127.0.0.1:8000/api/authors/delete/${this.authorId}`)
        alert('Author deleted successfully.')
        this.$router.push('/authors')
      } catch (error) {
        console.error('Failed to delete author:', error)
        alert('Failed to delete author.')
      }
    }
  },
  watch: {
    authorId: {
      immediate: true,
      handler() {
        this.fetchAuthor()
      }
    }
  }
}
</script>

<style>
/* No scoped styles needed. All styling handled by Tailwind CSS */
</style>
