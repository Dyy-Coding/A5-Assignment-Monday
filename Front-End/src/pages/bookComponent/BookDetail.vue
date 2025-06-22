<template>
  <div>
    <div v-if="filteredBooks.length > 0" class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
      <div
        v-for="book in filteredBooks"
        :key="book.id"
        class="relative border border-gray-200 rounded-xl p-5 hover:shadow-md transition duration-300 hover:-translate-y-1"
      >
        <!-- Delete icon top-right -->
        <button
          @click="$emit('delete-book', book.id)"
          class="absolute top-3 right-3 text-red-600 hover:text-red-800 focus:outline-none"
          aria-label="Delete book"
          title="Delete book"
        >
          <span class="material-icons">delete</span>
        </button>

        <div class="flex items-center space-x-4 mb-4">
          <div class="bg-sky-100 text-sky-800 rounded-full p-3 cursor-pointer" @click="$emit('edit-book', book.id)">
            <span class="material-icons">edit</span>
          </div>
          <div>
            <h3 class="text-lg font-semibold text-gray-800">{{ book.title }}</h3>
            <p class="text-sm text-gray-500">{{ book.author }}</p>
          </div>
        </div>

        <div class="mt-4 pt-3 border-t border-gray-100 flex justify-between">
          <button
            @click="$emit('view-book', book.id)"
            class="text-indigo-600 hover:text-indigo-800 text-sm font-medium flex items-center"
          >
            View Details <span class="material-icons text-sm ml-1">chevron_right</span>
          </button>
          <button class="text-gray-500 hover:text-gray-700 text-sm font-medium flex items-center">
            <span class="material-icons text-sm mr-1">category</span> {{ book.category }}
          </button>
        </div>
      </div>
    </div>

    <div v-else class="text-center py-12">
      <span class="material-icons text-gray-400 text-5xl mb-4">search_off</span>
      <h3 class="text-lg font-medium text-gray-900">No books found</h3>
      <p class="mt-1 text-sm text-gray-500">Try adjusting your search criteria</p>
    </div>
  </div>
</template>

<script>
export default {
  props: {
    books: {
      type: Array,
      required: true,
      default: () => []
    },
    search: {
      type: String,
      required: true,
      default: ''
    }
  },
  computed: {
    filteredBooks() {
      if (!Array.isArray(this.books)) return [];
      const searchLower = this.search.toLowerCase();
      return this.books.filter(book =>
        (book.title?.toLowerCase().includes(searchLower) ||
         book.author?.toLowerCase().includes(searchLower))
      );
    }
  }
};
</script>
