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

      <!-- Add Member Form Component -->
      <AddFormMember
        v-if="showAddForm"
        :modelValue="newMember"
        @close="showAddForm = false"
        @saved="handleAddMember"
      />

      <!-- Members List -->
      <div v-if="filteredMembers.length > 0" class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
        <MemberCard
          v-for="member in filteredMembers"
          :key="member.id"
          :member="member"
          @view-detail="handleViewDetail"
          @edit-member="handleEditMember"
          @delete-member="handleDeleteMember"
        />
      </div>

      <div v-else class="text-center py-12">
        <span class="material-icons text-gray-400 text-5xl mb-4">person_off</span>
        <h3 class="text-lg font-medium text-gray-900">No members found</h3>
        <p class="mt-1 text-sm text-gray-500">Try adjusting your search criteria</p>
      </div>

      <!-- Optional error message -->
      <p v-if="errorMessage" class="text-red-600 mt-4">{{ errorMessage }}</p>

      <!-- Optional loading indicator -->
      <div v-if="loading" class="text-center mt-4 text-indigo-600 font-semibold">
        Loading...
      </div>
    </div>
  </div>
</template>

<script>
import axios from 'axios';
import AddFormMember from './memberComponent/AddFormMember.vue';
import MemberCard from './memberComponent/MemberCard.vue';

export default {
  components: {
    AddFormMember,
    MemberCard,
  },
  data() {
    return {
      search: '',
      showAddForm: false,
      newMember: {
        FirstName: '',
        LastName: '',
        Email: '',
        Phone: '',
        Address: '',
        Image: ''
      },
      members: [],
      loading: false,
      errorMessage: ''
    };
  },
  computed: {
    filteredMembers() {
      const lowerSearch = this.search.toLowerCase();
      return this.members.filter(member =>
        (member.FirstName + ' ' + member.LastName).toLowerCase().includes(lowerSearch) ||
        member.Email.toLowerCase().includes(lowerSearch)
      );
    }
  },
  methods: {
    fetchMembers() {
      this.loading = true;
      this.errorMessage = '';
      axios.get('http://localhost:8000/api/members')
        .then(res => {
          this.members = res.data.members || [];
        })
        .catch(err => {
          console.error(err);
          this.errorMessage = 'Failed to load members.';
        })
        .finally(() => {
          this.loading = false;
        });
    },
    resetNewMember() {
      this.newMember = {
        FirstName: '',
        LastName: '',
        Email: '',
        Phone: '',
        Address: '',
        Image: ''
      };
    },
    handleAddMember(member) {
      this.members.push(member);
      this.showAddForm = false;
      this.resetNewMember();
    },
    handleViewDetail(memberId) {
      this.$router.push({ name: 'MemberDetail', params: { id: memberId } });
    },
    handleEditMember(memberId) {
      this.$router.push({ name: 'EditFormMember', params: { id: memberId } });
    },
    handleDeleteMember(memberId) {
      if (confirm('Are you sure you want to delete this member?')) {
        axios.delete(`http://localhost:8000/api/members/delete/${memberId}`)
          .then(() => {
            this.members = this.members.filter(m => m.id !== memberId);
          })
          .catch(err => {
            alert('Failed to delete member.');
            console.error(err);
          });
      }
    }
  },
  mounted() {
    this.fetchMembers();
  }
};
</script>
