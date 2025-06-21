<!-- MemberPage.vue -->
<template>
  <div class="px-4 py-6 sm:px-0">
    <div class="bg-white shadow rounded-lg p-6">
      <div class="flex justify-between items-center mb-6">
        <h1 class="text-2xl font-bold text-gray-800 flex items-center">
          <span class="material-icons mr-2">people</span> Library Members
        </h1>
        <button 
          @click="showAddForm = true"
          class="bg-indigo-600 hover:bg-indigo-700 text-white px-4 py-2 rounded-lg flex items-center transition duration-200"
        >
          <span class="material-icons mr-1">add</span> Add Member
        </button>
      </div>
      
      <div class="mb-6">
        <div class="relative flex-grow max-w-lg">
          <span class="material-icons absolute left-3 top-3 text-gray-400">search</span>
          <input
            v-model="search"
            type="text"
            placeholder="Search members by name or email..."
            class="pl-10 pr-4 py-2 w-full border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 shadow-sm transition duration-200"
          />
        </div>
      </div>

      <!-- Add Member Form -->
      <div 
        v-if="showAddForm" 
        class="border border-gray-200 rounded-xl p-5 mb-6 bg-indigo-50"
      >
        <div class="flex justify-between items-start mb-3">
          <h3 class="text-lg font-semibold text-gray-800">Add New Member</h3>
          <button @click="showAddForm = false" class="text-gray-500 hover:text-gray-700">
            <span class="material-icons">close</span>
          </button>
        </div>
        
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
          <div>
            <label class="block text-sm font-medium text-gray-700 mb-1">Name</label>
            <input v-model="newMember.name" type="text" class="w-full px-3 py-2 border border-gray-300 rounded-md">
          </div>
          <div>
            <label class="block text-sm font-medium text-gray-700 mb-1">Email</label>
            <input v-model="newMember.email" type="email" class="w-full px-3 py-2 border border-gray-300 rounded-md">
          </div>
          <div>
            <label class="block text-sm font-medium text-gray-700 mb-1">Join Date</label>
            <input v-model="newMember.joinDate" type="date" class="w-full px-3 py-2 border border-gray-300 rounded-md">
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
            @click="addMember"
            class="px-4 py-2 bg-indigo-600 text-white rounded-md hover:bg-indigo-700"
          >
            Save Member
          </button>
        </div>
      </div>
      
      <div v-if="filteredMembers.length > 0" class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
        <div 
          v-for="member in filteredMembers" 
          :key="member.id" 
          class="border border-gray-200 rounded-xl p-5 hover:shadow-md transition duration-300 hover:-translate-y-1"
        >
          <div class="flex items-center space-x-4 mb-4">
            <div class="bg-indigo-100 text-indigo-800 rounded-full p-3">
              <span class="material-icons">person</span>
            </div>
            <div>
              <h3 class="text-lg font-semibold text-gray-800">{{ member.name }}</h3>
              <p class="text-sm text-gray-500">Member ID: #{{ member.id.toString().padStart(4, '0') }}</p>
            </div>
          </div>
          <div class="space-y-2 text-gray-600">
            <p class="flex items-center">
              <span class="material-icons text-sm mr-2 text-gray-400">email</span>
              {{ member.email }}
            </p>
            <p class="flex items-center">
              <span class="material-icons text-sm mr-2 text-gray-400">date_range</span>
              Joined: {{ member.joinDate || 'Jan 2023' }}
            </p>
          </div>
          <div class="mt-4 pt-3 border-t border-gray-100 flex justify-between">
            <button class="text-indigo-600 hover:text-indigo-800 text-sm font-medium flex items-center">
              View Profile <span class="material-icons text-sm ml-1">chevron_right</span>
            </button>
            <button class="text-gray-500 hover:text-gray-700 text-sm font-medium flex items-center">
              <span class="material-icons text-sm mr-1">mail</span> Message
            </button>
          </div>
        </div>
      </div>
      
      <div v-else class="text-center py-12">
        <span class="material-icons text-gray-400 text-5xl mb-4">person_off</span>
        <h3 class="text-lg font-medium text-gray-900">No members found</h3>
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
      newMember: {
        name: '',
        email: '',
        joinDate: new Date().toISOString().split('T')[0]
      },
      members: [
        { id: 1, name: 'Alice Johnson', email: 'alice.johnson@example.com', joinDate: '2022-03-15' },
        { id: 2, name: 'Bob Smith', email: 'bob.smith@example.com', joinDate: '2023-01-10' },
        { id: 3, name: 'Charlie Brown', email: 'charlie.brown@example.com', joinDate: '2021-11-22' },
        { id: 4, name: 'Diana Prince', email: 'diana.prince@example.com', joinDate: '2022-08-05' },
        { id: 5, name: 'Ethan Hunt', email: 'ethan.hunt@example.com', joinDate: '2023-05-18' }
      ]
    };
  },
  computed: {
    filteredMembers() {
      return this.members.filter(member => 
        member.name.toLowerCase().includes(this.search.toLowerCase()) ||
        member.email.toLowerCase().includes(this.search.toLowerCase())
      );
    }
  },
  methods: {
    addMember() {
      const newId = this.members.length > 0 ? Math.max(...this.members.map(m => m.id)) + 1 : 1;
      this.members.push({
        id: newId,
        ...this.newMember
      });
      this.showAddForm = false;
      this.resetNewMember();
    },
    resetNewMember() {
      this.newMember = {
        name: '',
        email: '',
        joinDate: new Date().toISOString().split('T')[0]
      };
    }
  }
};
</script>