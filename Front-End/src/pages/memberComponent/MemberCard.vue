<template>
  <div class="border border-gray-200 rounded-xl p-5 hover:shadow-md transition duration-300 hover:-translate-y-1 bg-white">
    <div class="flex items-center space-x-4 mb-4">
      <div class="bg-indigo-100 text-indigo-800 rounded-full p-3">
        <span class="material-icons">person</span>
      </div>
      <div>
        <h3 class="text-lg font-semibold text-gray-800">{{ member.FirstName }} {{ member.LastName }}</h3>
        <p class="text-sm text-gray-500">Member ID: #{{ member.id.toString().padStart(4, '0') }}</p>
      </div>
    </div>
    <div class="space-y-2 text-gray-600 mb-4">
      <p class="flex items-center">
        <span class="material-icons text-sm mr-2 text-gray-400">email</span>
        {{ member.Email }}
      </p>
      <p class="flex items-center">
        <span class="material-icons text-sm mr-2 text-gray-400">phone</span>
        {{ member.Phone }}
      </p>
      <p class="flex items-center">
        <span class="material-icons text-sm mr-2 text-gray-400">home</span>
        {{ member.Address }}
      </p>
    </div>
    <div class="flex justify-end space-x-3 pt-2 border-t border-gray-100">
      <button
        @click="$emit('view-detail', member.id)"
        class="text-indigo-600 hover:text-indigo-800 text-sm font-medium flex items-center"
      >
        View Detail
        <span class="material-icons text-sm ml-1">chevron_right</span>
      </button>

      <button
        @click="$emit('edit-member', member.id)"
        class="text-yellow-600 hover:text-yellow-800 text-sm font-medium flex items-center"
      >
        <span class="material-icons text-sm mr-1">edit</span> Edit
      </button>

      <button
        @click="$emit('delete-member', member.id)"
        class="text-red-600 hover:text-red-800 text-sm font-medium flex items-center"
      >
        <span class="material-icons text-sm mr-1">delete</span> Delete
      </button>
    </div>
  </div>
</template>

<script>
export default {
  name: 'MemberCard',
  props: {
    member: {
      type: Object,
      required: true,
    },
  },
};
</script>
