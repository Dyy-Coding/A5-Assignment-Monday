<template>
  <div class="border border-gray-200 rounded-xl p-5 mb-6 bg-indigo-50">
    <div class="flex justify-between items-start mb-3">
      <h3 class="text-lg font-semibold text-gray-800">Add New Author</h3>
      <button @click="$emit('close')" class="text-gray-500 hover:text-gray-700">
        <span class="material-icons">close</span>
      </button>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
      <div>
        <label class="block text-sm font-medium text-gray-700 mb-1">Name</label>
        <input
          v-model="author.name"
          type="text"
          class="w-full px-3 py-2 border border-gray-300 rounded-md"
          placeholder="Enter author name"
        />
      </div>

      <div>
        <label class="block text-sm font-medium text-gray-700 mb-1">Date of Birth</label>
        <input
          v-model="author.dateofbirth"
          type="date"
          class="w-full px-3 py-2 border border-gray-300 rounded-md"
        />
      </div>

      <div>
        <label class="block text-sm font-medium text-gray-700 mb-1">Nationality</label>
        <input
          v-model="author.nationality"
          type="text"
          class="w-full px-3 py-2 border border-gray-300 rounded-md"
          placeholder="Enter nationality"
        />
      </div>

      <div>
        <label class="block text-sm font-medium text-gray-700 mb-1">Number of Written Books</label>
        <input
          v-model.number="author.numberOfWrittenBook"
          type="number"
          min="0"
          class="w-full px-3 py-2 border border-gray-300 rounded-md"
        />
      </div>

      <div class="md:col-span-2">
        <label class="block text-sm font-medium text-gray-700 mb-1">Author Image</label>
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
        @click="submitAuthor"
        class="px-4 py-2 bg-indigo-600 text-white rounded-md hover:bg-indigo-700"
        :disabled="!author.name || !author.dateofbirth"
      >
        Save Author
      </button>
    </div>
  </div>
</template>

<script>
import axios from 'axios'

export default {
  data() {
    return {
      author: {
        name: '',
        dateofbirth: '',
        nationality: '',
        numberOfWrittenBook: 0,
        image: null,
      },
    }
  },
  methods: {
    handleImageUpload(event) {
      const file = event.target.files[0]
      if (file && (file.type === 'image/jpeg' || file.type === 'image/png')) {
        this.author.image = file
      } else {
        alert('Please select a valid JPG or PNG image.')
        event.target.value = null
      }
    },
    async submitAuthor() {
      try {
        const formData = new FormData()
        formData.append('name', this.author.name)
        formData.append('dateofbirth', this.author.dateofbirth)
        formData.append('nationality', this.author.nationality)
        formData.append('numberOfWrittenBook', this.author.numberOfWrittenBook)
        if (this.author.image) {
          formData.append('image', this.author.image)
        }

        const res = await axios.post('http://127.0.0.1:8000/api/authors/create', formData, {
          headers: { 'Content-Type': 'multipart/form-data' },
        })

        this.$emit('author-added', res.data.data)
        this.resetForm()
      } catch (err) {
        console.error('Failed to add author:', err.response?.data || err)
        alert('Failed to add author. Please check the console for details.')
      }
    },
    resetForm() {
      this.author = {
        name: '',
        dateofbirth: '',
        nationality: '',
        numberOfWrittenBook: 0,
        image: null,
      }
    },
  },
}
</script>
