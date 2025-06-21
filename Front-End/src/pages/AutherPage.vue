<!-- AuthorPage.vue -->
<template>
  <div class="px-4 py-6 sm:px-0">
    <div class="bg-white shadow rounded-lg p-6">
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
      <div 
        v-if="showAddForm" 
        class="border border-gray-200 rounded-xl p-5 mb-6 bg-indigo-50"
      >
        <div class="flex justify-between items-start mb-3">
          <h3 class="text-lg font-semibold text-gray-800">Add New Author</h3>
          <button @click="showAddForm = false" class="text-gray-500 hover:text-gray-700">
            <span class="material-icons">close</span>
          </button>
        </div>
        
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
          <div>
            <label class="block text-sm font-medium text-gray-700 mb-1">Name</label>
            <input v-model="newAuthor.name" type="text" class="w-full px-3 py-2 border border-gray-300 rounded-md">
          </div>
          <div class="md:col-span-2">
            <label class="block text-sm font-medium text-gray-700 mb-1">Books (comma separated)</label>
            <input 
              v-model="newAuthor.booksInput" 
              type="text" 
              placeholder="Book 1, Book 2, Book 3"
              class="w-full px-3 py-2 border border-gray-300 rounded-md"
            >
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
            @click="addAuthor"
            class="px-4 py-2 bg-indigo-600 text-white rounded-md hover:bg-indigo-700"
          >
            Save Author
          </button>
        </div>
      </div>
      
      <div v-if="filteredAuthors.length > 0" class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
        <div 
          v-for="author in filteredAuthors" 
          :key="author.id" 
          class="border border-gray-200 rounded-xl p-5 hover:shadow-md transition duration-300 hover:-translate-y-1"
        >
          <div class="flex items-center space-x-4 mb-4">
            <div class="bg-purple-100 text-purple-800 rounded-full p-3">
              <span class="material-icons">edit</span>
            </div>
            <div>
              <h3 class="text-lg font-semibold text-gray-800">{{ author.name }}</h3>
              <p class="text-sm text-gray-500">{{ author.books.length }} published works</p>
            </div>
          </div>
          <div class="mb-3">
            <h4 class="text-sm font-medium text-gray-700 mb-1">Notable Works:</h4>
            <div class="flex flex-wrap gap-2">
              <span 
                v-for="(book, index) in author.books.slice(0, 3)" 
                :key="index"
                class="bg-gray-100 text-gray-800 text-xs px-2 py-1 rounded"
              >
                {{ book }}
              </span>
              <span 
                v-if="author.books.length > 3" 
                class="bg-gray-100 text-gray-800 text-xs px-2 py-1 rounded"
              >
                +{{ author.books.length - 3 }} more
              </span>
            </div>
          </div>
          <div class="mt-4 pt-3 border-t border-gray-100 flex justify-between">
            <button class="text-indigo-600 hover:text-indigo-800 text-sm font-medium flex items-center">
              View Profile <span class="material-icons text-sm ml-1">chevron_right</span>
            </button>
            <button class="text-gray-500 hover:text-gray-700 text-sm font-medium flex items-center">
              <span class="material-icons text-sm mr-1">book</span> Works
            </button>
          </div>
        </div>
      </div>
      
      <div v-else class="text-center py-12">
        <span class="material-icons text-gray-400 text-5xl mb-4">person_search</span>
        <h3 class="text-lg font-medium text-gray-900">No authors found</h3>
        <p class="mt-1 text-sm text-gray-500">Try adjusting your search criteria</p>
      </div>
    </div>
  </div>
</template>

<script>
export default {
  data() {
    return {
      search: '',
      showAddForm: false,
      newAuthor: {
        name: '',
        booksInput: ''
      },
      authors: [
        { 
          id: 1, 
          name: 'John Doe', 
          books: ['Vue for Beginners', 'Advanced Components', 'State Management Patterns'] 
        },
        { 
          id: 2, 
          name: 'Jane Smith', 
          books: ['Advanced Vue', 'Frontend Architecture', 'Responsive Design'] 
        },
        { 
          id: 3, 
          name: 'Coder Dev', 
          books: ['JavaScript Mastery', 'ES6 and Beyond', 'Functional Programming'] 
        },
        { 
          id: 4, 
          name: 'Designer Pro', 
          books: ['CSS Artistry', 'UI/UX Principles', 'Design Systems'] 
        }
      ]
    };
  },
  computed: {
    filteredAuthors() {
      return this.authors.filter(author => 
        author.name.toLowerCase().includes(this.search.toLowerCase())
      );
    }
  },
  methods: {
    addAuthor() {
      const newId = this.authors.length > 0 ? Math.max(...this.authors.map(a => a.id)) + 1 : 1;
      this.authors.push({
        id: newId,
        name: this.newAuthor.name,
        books: this.newAuthor.booksInput.split(',').map(book => book.trim()).filter(book => book)
      });
      this.showAddForm = false;
      this.resetNewAuthor();
    },
    resetNewAuthor() {
      this.newAuthor = {
        name: '',
        booksInput: ''
      };
    }
  }
};
</script>