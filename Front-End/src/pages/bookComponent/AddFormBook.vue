<template>
  <div class="border border-gray-200 rounded-xl p-5 mb-6 bg-indigo-50">
    <div class="flex justify-between items-start mb-3">
      <h3 class="text-lg font-semibold text-gray-800">Add New Book</h3>
      <button @click="$emit('close')" class="text-gray-500 hover:text-gray-700">
        <span class="material-icons">close</span>
      </button>
    </div>

    <form @submit.prevent="saveBook" enctype="multipart/form-data">
      <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
        <div>
          <label class="block text-sm font-medium text-gray-700 mb-1">ISBN</label>
          <input v-model="form.isbn" type="text" class="w-full px-3 py-2 border border-gray-300 rounded-md" required />
        </div>
        <div>
          <label class="block text-sm font-medium text-gray-700 mb-1">Title</label>
          <input v-model="form.title" type="text" class="w-full px-3 py-2 border border-gray-300 rounded-md" required />
        </div>
        <div>
          <label class="block text-sm font-medium text-gray-700 mb-1">Author</label>
          <input v-model="form.author" type="text" class="w-full px-3 py-2 border border-gray-300 rounded-md" required />
        </div>
        <div>
          <label class="block text-sm font-medium text-gray-700 mb-1">Publication Year</label>
          <input v-model.number="form.publication_years" type="number" class="w-full px-3 py-2 border border-gray-300 rounded-md" required />
        </div>
        <div>
          <label class="block text-sm font-medium text-gray-700 mb-1">Number of Copies</label>
          <input v-model.number="form.number_of_copies" type="number" class="w-full px-3 py-2 border border-gray-300 rounded-md" required />
        </div>
        <div>
          <label class="block text-sm font-medium text-gray-700 mb-1">Category</label>
          <select v-model="form.categories" class="w-full px-3 py-2 border border-gray-300 rounded-md">
            <option value="Fiction">Fiction</option>
            <option value="Programming">Programming</option>
            <option value="Science">Science</option>
            <option value="History">History</option>
          </select>
        </div>
        <div>
          <label class="block text-sm font-medium text-gray-700 mb-1">Priority</label>
          <select v-model="form.priority" class="w-full px-3 py-2 border border-gray-300 rounded-md" required>
            <option value="Low">Low</option>
            <option value="Medium">Medium</option>
            <option value="High">High</option>
          </select>
        </div>
        <div class="md:col-span-2">
          <label class="block text-sm font-medium text-gray-700 mb-1">Book Cover (optional)</label>
          <input @change="handleImageUpload" type="file" accept="image/*" class="w-full px-3 py-2 border border-gray-300 rounded-md" />
        </div>
      </div>

      <div class="flex justify-end space-x-3 pt-2">
        <button type="button" @click="$emit('close')" class="px-4 py-2 border border-gray-300 rounded-md text-gray-700 hover:bg-gray-50">Cancel</button>
        <button type="submit" class="px-4 py-2 bg-indigo-600 text-white rounded-md hover:bg-indigo-700" :disabled="isSubmitting">
          {{ isSubmitting ? 'Saving...' : 'Save Book' }}
        </button>
      </div>
    </form>
  </div>
</template>

<script>
import axios from 'axios';

export default {
  data() {
    return {
      isSubmitting: false,
      form: {
        isbn: '',
        title: '',
        author: '',
        publication_years: new Date().getFullYear(),
        number_of_copies: 1,
        categories: 'Fiction',
        priority: 'Medium',
        image: null,
      },
    };
  },
  methods: {
    handleImageUpload(event) {
      this.form.image = event.target.files[0];
    },
    async saveBook() {
      this.isSubmitting = true;
      try {
        const formData = new FormData();
        formData.append('isbn', this.form.isbn);
        formData.append('title', this.form.title);
        formData.append('author', this.form.author);
        formData.append('publication_year', this.form.publication_years); // corrected key
        formData.append('number_of_copies', this.form.number_of_copies);
        formData.append('category', this.form.categories); // corrected key
        formData.append('priority', this.form.priority);
        if (this.form.image) {
          formData.append('image', this.form.image);
        }

        const response = await axios.post('http://127.0.0.1:8000/api/books/create', formData, {
          headers: { 'Content-Type': 'multipart/form-data' },
        });

        if (response.data.data) {
          this.$emit('save', response.data.data); // emit created book data to parent
          this.resetForm();
          this.$emit('close');
        }
        this.isSubmitting = false;
      } catch (error) {
        this.isSubmitting = false;
        console.error('Failed to add book:', error.response?.data || error);
        alert('Failed to add book. Please check your input.');
      }
    },
    resetForm() {
      this.form = {
        isbn: '',
        title: '',
        author: '',
        publication_years: new Date().getFullYear(),
        number_of_copies: 1,
        categories: 'Fiction',
        priority: 'Medium',
        image: null,
      };
    },
  },
};
</script>
