<template>
  <div
    class="border border-gray-200 rounded-xl p-5 hover:shadow-md transition duration-300 hover:-translate-y-1 relative"
  >
    <div class="flex justify-between items-start mb-3">
      <!-- Use book.title -->
      <h3 class="text-lg font-semibold text-gray-800">{{ book.title }}</h3>
      <span
        :class="qualityClasses[book.priority] || defaultQualityClass"
        class="px-2 py-1 text-xs rounded-full"
      >
        {{ book.priority }}
      </span>
    </div>
    <div class="space-y-2 text-gray-600">
      <p class="flex items-center">
        <span class="material-icons text-sm mr-2 text-gray-400">calendar_today</span>
        Published: {{ book.publication_year }}
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

    <!-- Bottom action bar -->
    <div
      class="mt-4 pt-3 border-t border-gray-100 flex justify-between items-center"
    >
      <div class="flex space-x-3">
        <!-- Edit Button -->
        <button
          @click="$emit('edit', book.id)"
          class="text-blue-600 hover:text-blue-800 text-sm font-medium flex items-center"
          aria-label="Edit book"
          title="Edit book"
        >
          <span class="material-icons text-sm mr-1">edit</span> Edit
        </button>

        <!-- Delete Button -->
        <button
          @click="$emit('delete', book.id)"
          class="text-red-600 hover:text-red-800 text-sm font-medium flex items-center"
          aria-label="Delete book"
          title="Delete book"
        >
          <span class="material-icons text-sm mr-1">delete</span> Delete
        </button>
      </div>

      <!-- View Details Button -->
      <button
        @click="$emit('view', book.id)"
        class="text-indigo-600 hover:text-indigo-800 text-sm font-medium flex items-center"
      >
        View Details
        <span class="material-icons text-sm ml-1">chevron_right</span>
      </button>
    </div>
  </div>
</template>

<script>
export default {
  props: {
    book: {
      type: Object,
      required: true,
    },
  },
  data() {
    return {
      qualityClasses: {
        High: 'bg-green-100 text-green-800',
        Medium: 'bg-yellow-100 text-yellow-800',
        Low: 'bg-red-100 text-red-800',
      },
      defaultQualityClass: 'bg-gray-100 text-gray-600',
    };
  },
};
</script>
