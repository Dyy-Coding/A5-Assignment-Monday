<template>
  <div class="px-6 py-10 max-w-3xl mx-auto bg-white/70 backdrop-blur-md rounded-3xl shadow-2xl">
    <h1 class="text-4xl font-extrabold bg-gradient-to-r from-sky-400 to-indigo-600 text-transparent bg-clip-text mb-8 text-center">
      Edit Book 📚
    </h1>

    <form @submit.prevent="updateBook" v-if="book" class="space-y-6" enctype="multipart/form-data">
      <!-- Image Preview -->
      <div v-if="book.image_url" class="flex justify-center">
        <img :src="book.image_url" alt="Book Cover"
             class="w-32 h-40 rounded-lg object-cover border-4 border-indigo-400 shadow-lg" />
      </div>

      <!-- Form Inputs -->
      <div class="grid gap-4 md:grid-cols-2">
        <div>
          <label class="block text-sm font-semibold text-gray-600 mb-1">ISBN</label>
          <input
            v-model="form.isbn"
            type="text"
            placeholder="ISBN"
            required
            class="w-full border border-gray-300 rounded-lg px-4 py-2 shadow-sm focus:outline-none focus:ring-2 focus:ring-indigo-400 focus:border-indigo-500"
          />
        </div>
        <div>
          <label class="block text-sm font-semibold text-gray-600 mb-1">Title</label>
          <input
            v-model="form.title"
            type="text"
            placeholder="Book Title"
            required
            class="w-full border border-gray-300 rounded-lg px-4 py-2 shadow-sm focus:outline-none focus:ring-2 focus:ring-indigo-400 focus:border-indigo-500"
          />
        </div>
        <div>
          <label class="block text-sm font-semibold text-gray-600 mb-1">Author</label>
          <input
            v-model="form.author"
            type="text"
            placeholder="Author"
            required
            class="w-full border border-gray-300 rounded-lg px-4 py-2 shadow-sm focus:outline-none focus:ring-2 focus:ring-indigo-400 focus:border-indigo-500"
          />
        </div>
        <div>
          <label class="block text-sm font-semibold text-gray-600 mb-1">Priority</label>
          <select
            v-model="form.priority"
            required
            class="w-full border border-gray-300 rounded-lg px-4 py-2 bg-white shadow-sm focus:outline-none focus:ring-2 focus:ring-indigo-400 focus:border-indigo-500"
          >
            <option value="High">🔥 High</option>
            <option value="Medium">✨ Medium</option>
            <option value="Low">🌙 Low</option>
          </select>
        </div>
        <div>
          <label class="block text-sm font-semibold text-gray-600 mb-1">Publication Year</label>
          <input
            v-model.number="form.publication_year"
            type="number"
            placeholder="e.g., 2023"
            required
            class="w-full border border-gray-300 rounded-lg px-4 py-2 shadow-sm focus:outline-none focus:ring-2 focus:ring-indigo-400 focus:border-indigo-500"
          />
        </div>
        <div>
          <label class="block text-sm font-semibold text-gray-600 mb-1">Number of Copies</label>
          <input
            v-model.number="form.number_of_copies"
            type="number"
            min="1"
            placeholder="Copies available"
            required
            class="w-full border border-gray-300 rounded-lg px-4 py-2 shadow-sm focus:outline-none focus:ring-2 focus:ring-indigo-400 focus:border-indigo-500"
          />
        </div>
        <div class="md:col-span-2">
          <label class="block text-sm font-semibold text-gray-600 mb-1">Category</label>
          <select
            v-model="form.category"
            required
            class="w-full border border-gray-300 rounded-lg px-4 py-2 bg-white shadow-sm focus:outline-none focus:ring-2 focus:ring-indigo-400 focus:border-indigo-500"
          >
            <option value="Fiction">📖 Fiction</option>
            <option value="Programming">💻 Programming</option>
            <option value="Science">🔬 Science</option>
            <option value="History">🏺 History</option>
          </select>
        </div>
        <div class="md:col-span-2">
          <label class="block text-sm font-semibold text-gray-600 mb-1">Update Book Cover</label>
          <input
            @change="handleImageUpload"
            type="file"
            accept="image/*"
            class="block w-full text-sm text-slate-500
              file:mr-4 file:py-2 file:px-4
              file:rounded-lg file:border-0
              file:text-sm file:font-semibold
              file:bg-indigo-50 file:text-indigo-700
              hover:file:bg-indigo-100"
          />
        </div>
      </div>

      <!-- Buttons -->
      <div class="flex flex-wrap justify-center gap-4 pt-6">
        <button
          type="submit"
          class="bg-yellow-400 hover:bg-yellow-500 text-white font-semibold rounded-lg py-3 px-8 shadow-lg transition-colors duration-250"
        >
          💾 Update
        </button>
        <button
          @click.prevent="$router.push('/books')"
          class="bg-red-400 hover:bg-red-500 text-white font-semibold rounded-lg py-3 px-8 shadow-lg transition-colors duration-250"
        >
          ↩️ Cancel
        </button>
      </div>
    </form>

    <!-- Error Display -->
    <div v-else class="text-center text-red-500 font-semibold mt-10">
      Failed to load book data. 😢
    </div>
  </div>
</template>

<script>
import axios from 'axios';

export default {
  name: 'EditBook',
  props: {
    bookId: {
      type: [String, Number],
      required: true,
    },
  },
  data() {
    return {
      book: null,
      form: {
        isbn: '',
        title: '',
        author: '',
        priority: '',
        publication_year: '',
        number_of_copies: '',
        category: '',
        image: null,
      },
    };
  },
  methods: {
    async fetchBook() {
      try {
        const res = await axios.get(`http://127.0.0.1:8000/api/books/show/${this.bookId}`);
        const book = res.data.data;
        book.image_url = book.image ? `http://127.0.0.1:8000/${book.image}` : null;
        this.book = book;

        // Map API data to form
        this.form.isbn = book.isbn || '';
        this.form.title = book.title || '';
        this.form.author = book.author || '';
        this.form.priority = book.priority || '';
        this.form.publication_year = book.publication_year || '';
        this.form.number_of_copies = book.number_of_copies || '';
        this.form.category = book.category || '';
      } catch (err) {
        console.error("Failed to load book data:", err);
      }
    },
    handleImageUpload(event) {
      this.form.image = event.target.files[0];
    },
    async updateBook() {
      try {
        const formData = new FormData();
        formData.append('isbn', this.form.isbn);
        formData.append('title', this.form.title);
        formData.append('author', this.form.author);
        formData.append('priority', this.form.priority);
        formData.append('publication_year', this.form.publication_year);
        formData.append('number_of_copies', this.form.number_of_copies);
        formData.append('category', this.form.category);

        if (this.form.image) {
          formData.append('image', this.form.image);
        }

        formData.append('_method', 'PUT');

        await axios.post(
          `http://127.0.0.1:8000/api/books/update/${this.bookId}`,
          formData,
          { headers: { 'Content-Type': 'multipart/form-data' } }
        );

        alert('✅ Book updated successfully!');
        this.$router.push('/books');
      } catch (error) {
        if (error.response && error.response.status === 422) {
          const errors = error.response.data.errors || error.response.data;
          console.error('Validation errors:', errors);
          alert(
            'Validation errors:\n' +
            Object.entries(errors)
              .map(([field, msgs]) =>
                Array.isArray(msgs) ? `${field}: ${msgs.join(', ')}` : `${field}: ${msgs}`
              )
              .join('\n')
          );
        } else {
          console.error('Update failed:', error);
          alert('❌ Failed to update book.');
        }
      }
    }
  },
  mounted() {
    this.fetchBook();
  }
};
</script>
