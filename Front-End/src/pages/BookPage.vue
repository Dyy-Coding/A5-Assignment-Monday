<template>
  <div class="px-4 py-6 sm:px-0">
    <div class="bg-white shadow rounded-lg p-6">
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
            @click="filterCategory('All')" 
            :class="{'bg-indigo-600 text-white': category === 'All', 'bg-gray-100 hover:bg-gray-200': category !== 'All'}"
            class="px-4 py-2 rounded-lg transition duration-200 flex items-center"
          >
            <span class="material-icons text-sm mr-1">apps</span> All
          </button>
          <button 
            @click="filterCategory('Fiction')" 
            :class="{'bg-indigo-600 text-white': category === 'Fiction', 'bg-gray-100 hover:bg-gray-200': category !== 'Fiction'}"
            class="px-4 py-2 rounded-lg transition duration-200 flex items-center"
          >
            <span class="material-icons text-sm mr-1">auto_stories</span> Fiction
          </button>
          <button 
            @click="filterCategory('Programming')" 
            :class="{'bg-indigo-600 text-white': category === 'Programming', 'bg-gray-100 hover:bg-gray-200': category !== 'Programming'}"
            class="px-4 py-2 rounded-lg transition duration-200 flex items-center"
          >
            <span class="material-icons text-sm mr-1">code</span> Programming
          </button>
        </div>
      </div>

      <!-- Add Book Form (shown as first card when active) -->
      <div 
        v-if="showAddForm" 
        class="border border-gray-200 rounded-xl p-5 mb-6 bg-indigo-50"
      >
        <div class="flex justify-between items-start mb-3">
          <h3 class="text-lg font-semibold text-gray-800">Add New Book</h3>
          <button @click="showAddForm = false" class="text-gray-500 hover:text-gray-700">
            <span class="material-icons">close</span>
          </button>
        </div>
        
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
          <div>
            <label class="block text-sm font-medium text-gray-700 mb-1">Book Name</label>
            <input v-model="newBook.name" type="text" class="w-full px-3 py-2 border border-gray-300 rounded-md">
          </div>
          <div>
            <label class="block text-sm font-medium text-gray-700 mb-1">Author</label>
            <input v-model="newBook.author" type="text" class="w-full px-3 py-2 border border-gray-300 rounded-md">
          </div>
          <div>
            <label class="block text-sm font-medium text-gray-700 mb-1">Quality</label>
            <select v-model="newBook.quality" class="w-full px-3 py-2 border border-gray-300 rounded-md">
              <option value="High">High</option>
              <option value="Medium">Medium</option>
              <option value="Low">Low</option>
            </select>
          </div>
          <div>
            <label class="block text-sm font-medium text-gray-700 mb-1">Year</label>
            <input v-model="newBook.year" type="number" class="w-full px-3 py-2 border border-gray-300 rounded-md">
          </div>
          <div>
            <label class="block text-sm font-medium text-gray-700 mb-1">Category</label>
            <select v-model="newBook.category" class="w-full px-3 py-2 border border-gray-300 rounded-md">
              <option value="Fiction">Fiction</option>
              <option value="Programming">Programming</option>
              <option value="Science">Science</option>
              <option value="History">History</option>
            </select>
          </div>
        </div>
        
        <div class="flex justify-end space-x-3 pt-2">
          <button
            @click="showAddForm = false"
            class="px-4 py-2 border border-gray-300 rounded-md text-gray-700 hover:bg-gray-50"
          >
            Cancel
          </button>
          <button
            @click="addBook"
            class="px-4 py-2 bg-indigo-600 text-white rounded-md hover:bg-indigo-700"
          >
            Save Book
          </button>
        </div>
      </div>
      
      <div v-if="filteredBooks.length > 0" class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
        <div 
          v-for="book in filteredBooks" 
          :key="book.id" 
          class="border border-gray-200 rounded-xl p-5 hover:shadow-md transition duration-300 hover:-translate-y-1"
        >
          <div class="flex justify-between items-start mb-3">
            <h3 class="text-lg font-semibold text-gray-800">{{ book.name }}</h3>
            <span 
              :class="{
                'bg-green-100 text-green-800': book.quality === 'High',
                'bg-yellow-100 text-yellow-800': book.quality === 'Medium',
                'bg-red-100 text-red-800': book.quality === 'Low'
              }"
              class="px-2 py-1 text-xs rounded-full"
            >
              {{ book.quality }}
            </span>
          </div>
          <div class="space-y-2 text-gray-600">
            <p class="flex items-center">
              <span class="material-icons text-sm mr-2 text-gray-400">calendar_today</span>
              Published: {{ book.year }}
            </p>
            <p class="flex items-center">
              <span class="material-icons text-sm mr-2 text-gray-400">person</span>
              Author: {{ book.author }}
            </p>
            <p class="flex items-center">
              <span class="material-icons text-sm mr-2 text-gray-400">category</span>
              Category: {{ book.category }}
            </p>
          </div>
          <div class="mt-4 pt-3 border-t border-gray-100 flex justify-end">
            <button class="text-indigo-600 hover:text-indigo-800 text-sm font-medium flex items-center">
              View Details <span class="material-icons text-sm ml-1">chevron_right</span>
            </button>
          </div>
        </div>
      </div>
      
      <div v-else class="text-center py-12">
        <span class="material-icons text-gray-400 text-5xl mb-4">search_off</span>
        <h3 class="text-lg font-medium text-gray-900">No books found</h3>
        <p class="mt-1 text-sm text-gray-500">Try adjusting your search or filter criteria</p>
      </div>
    </div>
  </div>
</template>

<script>
export default {
  data() {
    return {
      search: '',
      category: 'All',
      showAddForm: false,
      newBook: {
        name: '',
        quality: 'High',
        year: new Date().getFullYear(),
        author: '',
        category: 'Fiction'
      },
      books: [
        { id: 1, name: 'Vue for Beginners', quality: 'High', year: 2023, author: 'John Doe', category: 'Fiction' },
        { id: 2, name: 'Advanced Vue', quality: 'Medium', year: 2022, author: 'Jane Smith', category: 'Fiction' },
        { id: 3, name: 'JavaScript Mastery', quality: 'High', year: 2021, author: 'Coder Dev', category: 'Programming' },
        { id: 4, name: 'CSS Artistry', quality: 'High', year: 2023, author: 'Designer Pro', category: 'Programming' },
        { id: 5, name: 'The Great Novel', quality: 'Medium', year: 2020, author: 'Literary Genius', category: 'Fiction' }
      ]
    };
  },
  computed: {
    filteredBooks() {
      return this.books.filter(book => {
        const matchSearch = book.name.toLowerCase().includes(this.search.toLowerCase()) || 
                          book.author.toLowerCase().includes(this.search.toLowerCase());
        const matchCategory = this.category === 'All' || book.category === this.category;
        return matchSearch && matchCategory;
      });
    }
  },
  methods: {
    filterCategory(category) {
      this.category = category;
    },
    addBook() {
      const newId = this.books.length > 0 ? Math.max(...this.books.map(b => b.id)) + 1 : 1;
      this.books.push({
        id: newId,
        ...this.newBook
      });
      this.showAddForm = false;
      this.resetNewBook();
    },
    resetNewBook() {
      this.newBook = {
        name: '',
        quality: 'High',
        year: new Date().getFullYear(),
        author: '',
        category: 'Fiction'
      };
    }
  }
};
</script>