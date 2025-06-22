<template>
  <div>
    <div v-if="filteredAuthors.length > 0" class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
      <div
        v-for="author in filteredAuthors"
        :key="author.id"
        class="border border-gray-200 rounded-xl p-5 hover:shadow-md transition duration-300 hover:-translate-y-1"
      >
        <div class="flex items-center space-x-4 mb-4">
          <div class="bg-purple-100 text-purple-800 rounded-full p-3">
            <span  @click="$emit('edit-author', author.id)" class="material-icons">edit</span>
          </div>
          <div>
            <h3 class="text-lg font-semibold text-gray-800">{{ author.name }}</h3>
            <p class="text-sm text-gray-500">{{ (author.numberOfWrittenBook) }} published books</p>
          </div>
        </div>
       
        <div class="mt-4 pt-3 border-t border-gray-100 flex justify-between">
          <button
            @click="$emit('view-profile', author.id)"
            class="text-indigo-600 hover:text-indigo-800 text-sm font-medium flex items-center"
          >
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
</template>

<script>
export default {
  props: {
    authors: {
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
    filteredAuthors() {
      if (!Array.isArray(this.authors)) return [];
      return this.authors.filter(author =>
        author.name.toLowerCase().includes(this.search.toLowerCase())
      );
    }
  }
};
</script>
