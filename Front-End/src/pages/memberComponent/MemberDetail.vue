<template>
  <div
    v-if="member"
    class="relative border border-gray-200 rounded-xl p-5 hover:shadow-md transition duration-300 max-w-md mx-auto"
  >
    <!-- Delete icon top-right -->
    <button
      @click="$emit('delete-member', member.id)"
      class="absolute top-3 right-3 text-red-600 hover:text-red-800 focus:outline-none"
      aria-label="Delete member"
      title="Delete member"
    >
      <span class="material-icons">delete</span>
    </button>

    <div class="flex items-center space-x-4 mb-4">
      <div
        class="bg-sky-100 text-sky-800 rounded-full p-3 cursor-pointer"
        @click="$emit('edit-member', member.id)"
      >
        <span class="material-icons">edit</span>
      </div>
      <div class="flex-shrink-0">
        <img
          v-if="member.Image"
          :src="member.Image"
          alt="Profile Image"
          class="w-16 h-16 rounded-full object-cover border border-sky-300"
        />
        <div
          v-else
          class="w-16 h-16 rounded-full bg-sky-200 flex items-center justify-center text-sky-800 font-semibold"
        >
          N/A
        </div>
      </div>
      <div>
        <h3 class="text-lg font-semibold text-gray-800">{{ member.FirstName }} {{ member.LastName }}</h3>
        <p class="text-sm text-gray-500 lowercase">{{ member.Email }}</p>
      </div>
    </div>

    <div class="space-y-2 text-gray-700 text-sm mb-4">
      <p><strong>Phone:</strong> {{ member.Phone }}</p>
      <p><strong>Address:</strong> {{ member.Address }}</p>
    </div>

    <div class="mt-4 pt-3 border-t border-gray-100 flex justify-between">
      <button
        @click="$emit('view-member', member.id)"
        class="text-indigo-600 hover:text-indigo-800 text-sm font-medium flex items-center"
      >
        View Details
        <span class="material-icons text-sm ml-1">chevron_right</span>
      </button>
      <button
        disabled
        class="text-gray-500 text-sm font-medium flex items-center cursor-default"
      >
        <span class="material-icons text-sm mr-1">badge</span> Member
      </button>
    </div>
  </div>

  <div v-else class="text-center py-12">
    <span class="material-icons text-gray-400 text-5xl mb-4">person_off</span>
    <h3 class="text-lg font-medium text-gray-900">No member selected</h3>
    <p class="mt-1 text-sm text-gray-500">Please select a member to view details</p>
  </div>
</template>

<script>
export default {
  props: {
    member: {
      type: Object,
      required: false,
      default: null
    }
  }
};
</script>
