<template>
  <div class="border border-gray-200 rounded-xl p-5 mb-6 bg-indigo-50">
    <div class="flex justify-between items-start mb-3">
      <h3 class="text-lg font-semibold text-gray-800">Add New Book</h3>
      <button @click="$emit('close')" class="text-gray-500 hover:text-gray-700">
        <span class="material-icons">close</span>
      </button>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
      <div>
        <label class="block text-sm font-medium text-gray-700 mb-1">Title</label>
        <input
          v-model="book.title"
          type="text"
          class="w-full px-3 py-2 border border-gray-300 rounded-md"
          placeholder="Enter book title"
        />
      </div>

      <div>
        <label class="block text-sm font-medium text-gray-700 mb-1">Author</label>
        <input
          v-model="book.author"
          type="text"
          class="w-full px-3 py-2 border border-gray-300 rounded-md"
          placeholder="Enter author name"
        />
      </div>

      <div>
        <label class="block text-sm font-medium text-gray-700 mb-1">Category</label>
        <input
          v-model="book.category"
          type="text"
          class="w-full px-3 py-2 border border-gray-300 rounded-md"
          placeholder="Enter book category"
        />
      </div>

      <div>
        <label class="block text-sm font-medium text-gray-700 mb-1">Publication Year</label>
        <input
          v-model.number="book.publication_year"
          type="number"
          min="0"
          class="w-full px-3 py-2 border border-gray-300 rounded-md"
          placeholder="Enter publication year"
        />
      </div>

      <div>
        <label class="block text-sm font-medium text-gray-700 mb-1">Priority</label>
        <select
          v-model="book.priority"
          class="w-full px-3 py-2 border border-gray-300 rounded-md"
        >
          <option disabled value="">Select priority</option>
          <option>High</option>
          <option>Medium</option>
          <option>Low</option>
        </select>
      </div>

      <div>
        <label class="block text-sm font-medium text-gray-700 mb-1">Number of Copies</label>
        <input
          v-model.number="book.number_of_copies"
          type="number"
          min="0"
          class="w-full px-3 py-2 border border-gray-300 rounded-md"
          placeholder="Enter number of copies"
        />
      </div>

      <div class="md:col-span-2">
        <label class="block text-sm font-medium text-gray-700 mb-1">Book Cover Image</label>
        <input
          type="file"
          @change="handleImageUpload"
          accept="image/jpeg,image/png"
          class="w-full px-3 py-2 border border-gray-300 rounded-md"
        />
      </div>
    </div>

    <div class="flex justify-end space-x-3 pt-2">
      <button
        @click="$emit('close')"
        class="px-4 py-2 border border-gray-300 rounded-md text-gray-700 hover:bg-gray-50"
      >
        Cancel
      </button>
      <button
        @click="submitBook"
        class="px-4 py-2 bg-indigo-600 text-white rounded-md hover:bg-indigo-700"
        :disabled="!book.title || !book.author || !book.category"
      >
        Save Book
      </button>
    </div>
  </div>
</template>

<script>
import axios from 'axios'

export default {
  data() {
    return {
      book: {
        title: '',
        author: '',
        category: '',
        publication_year: null,
        priority: '',
        number_of_copies: 0,
        image: null,
      },
    }
  },
  methods: {
    handleImageUpload(event) {
      const file = event.target.files[0]
      if (file && (file.type === 'image/jpeg' || file.type === 'image/png')) {
        this.book.image = file
      } else {
        alert('Please select a valid JPG or PNG image.')
        event.target.value = null
      }
    },
    async submitBook() {
      try {
        const formData = new FormData()
        formData.append('title', this.book.title)
        formData.append('author', this.book.author)
        formData.append('category', this.book.category)
        formData.append('publication_year', this.book.publication_year)
        formData.append('priority', this.book.priority)
        formData.append('number_of_copies', this.book.number_of_copies)
        if (this.book.image) {
          formData.append('image', this.book.image)
        }

        const res = await axios.post('http://127.0.0.1:8000/api/books/create', formData, {
          headers: { 'Content-Type': 'multipart/form-data' },
        })

        this.$emit('save', res.data.data)
        this.resetForm()
      } catch (err) {
        console.error('Failed to add book:', err.response?.data || err)
        alert('Failed to add book. Please check the console for details.')
      }
    },
    resetForm() {
      this.book = {
        title: '',
        author: '',
        category: '',
        publication_year: null,
        priority: '',
        number_of_copies: 0,
        image: null,
      }
    },
  },
}
</script>
