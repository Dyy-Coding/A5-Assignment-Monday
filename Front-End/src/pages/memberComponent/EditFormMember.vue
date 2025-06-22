<!-- /pages/memberComponent/EditFormMember.vue -->
<template>
  <div class="p-6 bg-white rounded shadow max-w-xl mx-auto">
    <h2 class="text-xl font-bold mb-4">Edit Member</h2>

    <form @submit.prevent="updateMember">
      <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
        <input v-model="form.FirstName" placeholder="First Name" class="border px-3 py-2 rounded" />
        <input v-model="form.LastName" placeholder="Last Name" class="border px-3 py-2 rounded" />
        <input v-model="form.Email" placeholder="Email" type="email" class="border px-3 py-2 rounded" />
        <input v-model="form.Phone" placeholder="Phone" class="border px-3 py-2 rounded" />
        <input v-model="form.Address" placeholder="Address" class="border px-3 py-2 rounded" />
        <input v-model="form.Image" placeholder="Image URL" class="border px-3 py-2 rounded" />
      </div>
      <button type="submit" class="mt-4 bg-indigo-600 text-white px-4 py-2 rounded hover:bg-indigo-700">
        Update
      </button>
    </form>
  </div>
</template>

<script>
import axios from 'axios';

export default {
  props: {
    memberId: String
  },
  data() {
    return {
      form: {
        FirstName: '',
        LastName: '',
        Email: '',
        Phone: '',
        Address: '',
        Image: ''
      }
    };
  },
  mounted() {
    axios.get(`http://localhost:8000/api/members/show/${this.memberId}`)
      .then(response => {
        this.form = response.data;
      });
  },
  methods: {
    updateMember() {
      axios.put(`http://localhost:8000/api/members/update/${this.memberId}`, this.form)
        .then(() => {
          this.$router.push('/members');
        });
    }
  }
};
</script>
