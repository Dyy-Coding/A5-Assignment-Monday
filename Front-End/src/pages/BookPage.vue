<template>
  <div class="px-4 py-6 sm:px-0">
    <div class="bg-white shadow rounded-lg p-6">
      <!-- Header -->
      <div class="flex justify-between items-center mb-6">
        <h1 class="text-2xl font-bold text-gray-800 flex items-center">
          <span class="material-icons mr-2">menu_book</span> Book Collection
        </h1>
        <button
          @click="showAddForm = true"
          class="bg-indigo-600 hover:bg-indigo-700 text-white px-4 py-2 rounded-lg flex items-center transition duration-200"
        >
          <span class="material-icons mr-1">add</span> Add Book
        </button>
      </div>

      <!-- Search and Category Filters -->
      <div class="flex flex-col md:flex-row gap-4 mb-6">
        <div class="relative flex-grow">
          <span class="material-icons absolute left-3 top-3 text-gray-400">search</span>
          <input
            v-model="search"
            type="text"
            placeholder="Search books by title or author..."
            class="pl-10 pr-4 py-2 w-full border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 shadow-sm transition duration-200"
          />
        </div>
        <div class="flex gap-2">
          <button
            v-for="cat in categories"
            :key="cat.value"
            @click="filterCategory(cat.value)"
            :class="buttonClass(cat.value)"
            class="px-4 py-2 rounded-lg transition duration-200 flex items-center"
          >
            <span class="material-icons text-sm mr-1">{{ cat.icon }}</span> {{ cat.label }}
          </button>
        </div>
      </div>

      <!-- Add Book Form Modal -->
      <AddFormBook
        v-if="showAddForm"
        @close="showAddForm = false"
        @save="handleAddBook"
      />

      <!-- Books Grid -->
      <div
        v-if="filteredBooks.length > 0"
        class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6"
      >
        <BookCard
          v-for="book in filteredBooks"
          :key="book.id"
          :book="book"
          @delete="deleteBook"
          @view="viewBookDetails"
          @edit="editBook"
        />
      </div>

      <!-- No Books Found Message -->
      <div v-else class="text-center py-12">
        <span class="material-icons text-gray-400 text-5xl mb-4">search_off</span>
        <h3 class="text-lg font-medium text-gray-900">No books found</h3>
        <p class="mt-1 text-sm text-gray-500">Try adjusting your search or filter criteria</p>
      </div>
    </div>
  </div>
</template>

<script>
import axios from 'axios';
import AddFormBook from './bookComponent/AddFormBook.vue';
import BookCard from './bookComponent/BookCard.vue';

axios.defaults.baseURL = 'http://127.0.0.1:8000/api';

export default {
  name: 'BookPage',
  components: { AddFormBook, BookCard },
  data() {
    return {
      search: '',
      category: 'All',
      showAddForm: false,
      books: [],
      categories: [
        { label: 'All', value: 'All', icon: 'apps' },
        { label: 'Fiction', value: 'Fiction', icon: 'auto_stories' },
        { label: 'Programming', value: 'Programming', icon: 'code' },
      ],
    };
  },
  computed: {
    filteredBooks() {
      const lowerSearch = this.search.toLowerCase();
      return this.books.filter(book => {
        const matchesSearch =
          (book.title && book.title.toLowerCase().includes(lowerSearch)) ||
          (book.author && book.author.toLowerCase().includes(lowerSearch));
        const matchesCategory = this.category === 'All' || book.category === this.category;
        return matchesSearch && matchesCategory;
      });
    }
  },
  methods: {
    buttonClass(cat) {
      return this.category === cat
        ? 'bg-indigo-600 text-white'
        : 'bg-gray-100 hover:bg-gray-200 text-gray-700';
    },
  async fetchBooks() {
  try {
    const response = await axios.get('/books');
    const books = (response.data.books || []).map(book => ({
      ...book,
      image_url: book.image 
        ? `http://127.0.0.1:8000/storage/${book.image}` 
        : null,
    }));

    console.log(books);

    this.books = books;
  } catch (error) {
    console.error('Failed to fetch books:', error);
  }
}


,
    filterCategory(category) {
      this.category = category;
    },
    async deleteBook(id) {
      try {
        await axios.delete(`/books/delete/${id}`);
        this.books = this.books.filter(book => book.id !== id);
      } catch (error) {
        console.error('Error deleting book:', error);
      }
    },
    viewBookDetails(id) {
      this.$router.push({ name: 'BookDetail', params: { id } });
    },
    editBook(id) {
      this.$router.push({ name: 'EditFormBook', params: { id } });
    },
    // NEW method to handle book addition from AddFormBook
    handleAddBook(newBook) {
      this.books.push(newBook);
      this.showAddForm = false;
    }
  },
  mounted() {
    this.fetchBooks();
  }
};
</script>
