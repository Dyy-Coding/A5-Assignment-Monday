<template>
  <div class="border border-gray-200 rounded-xl p-5 mb-6 bg-indigo-50">
    <div class="flex justify-between items-start mb-3">
      <h3 class="text-lg font-semibold text-gray-800">Add New Member</h3>
      <button @click="$emit('close')" class="text-gray-500 hover:text-gray-700">
        <span class="material-icons">close</span>
      </button>
    </div>

    <form @submit.prevent="create" enctype="multipart/form-data">
      <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
        <div>
          <label class="block text-sm font-medium text-gray-700 mb-1">First Name</label>
          <input v-model="form.FirstName" type="text" class="w-full px-3 py-2 border border-gray-300 rounded-md" />
          <p v-if="errors.FirstName" class="text-red-600 text-sm mt-1">{{ errors.FirstName }}</p>
        </div>
        <div>
          <label class="block text-sm font-medium text-gray-700 mb-1">Last Name</label>
          <input v-model="form.LastName" type="text" class="w-full px-3 py-2 border border-gray-300 rounded-md" />
          <p v-if="errors.LastName" class="text-red-600 text-sm mt-1">{{ errors.LastName }}</p>
        </div>
        <div>
          <label class="block text-sm font-medium text-gray-700 mb-1">Email</label>
          <input v-model="form.Email" type="email" class="w-full px-3 py-2 border border-gray-300 rounded-md" />
          <p v-if="errors.Email" class="text-red-600 text-sm mt-1">{{ errors.Email }}</p>
        </div>
        <div>
          <label class="block text-sm font-medium text-gray-700 mb-1">Phone</label>
          <input v-model="form.Phone" type="text" class="w-full px-3 py-2 border border-gray-300 rounded-md" />
          <p v-if="errors.Phone" class="text-red-600 text-sm mt-1">{{ errors.Phone }}</p>
        </div>
        <div class="md:col-span-2">
          <label class="block text-sm font-medium text-gray-700 mb-1">Address</label>
          <input v-model="form.Address" type="text" class="w-full px-3 py-2 border border-gray-300 rounded-md" />
          <p v-if="errors.Address" class="text-red-600 text-sm mt-1">{{ errors.Address }}</p>
        </div>
        <div class="md:col-span-2">
          <label class="block text-sm font-medium text-gray-700 mb-1">Photo (optional)</label>
          <input @change="handleFileUpload" type="file" accept="image/*" class="w-full px-3 py-2 border border-gray-300 rounded-md" />
        </div>
      </div>

      <div class="flex justify-end space-x-3 pt-2">
        <button type="button" @click="$emit('close')" class="px-4 py-2 border border-gray-300 rounded-md text-gray-700 hover:bg-gray-50">
          Cancel
        </button>
        <button type="submit" class="px-4 py-2 bg-indigo-600 text-white rounded-md hover:bg-indigo-700" :disabled="loading">
          <span v-if="loading" class="material-icons animate-spin text-sm mr-1">autorenew</span>
          Save Member
        </button>
      </div>
    </form>
  </div>
</template>

<script>
import axios from 'axios';

export default {
  data() {
    return {
      form: {
        FirstName: '',
        LastName: '',
        Email: '',
        Phone: '',
        Address: '',
        Image: null,  // will hold the file object
      },
      errors: {},
      loading: false,
    };
  },
  methods: {
    handleFileUpload(event) {
      this.form.Image = event.target.files[0]; // store the selected file
    },
    async create() {
      this.errors = {};
      this.loading = true;

      try {
        const formData = new FormData();
        formData.append('FirstName', this.form.FirstName);
        formData.append('LastName', this.form.LastName);
        formData.append('Email', this.form.Email);
        formData.append('Phone', this.form.Phone);
        formData.append('Address', this.form.Address);

        if (this.form.Image) {
          formData.append('Image', this.form.Image);
        }

        const response = await axios.post('http://localhost:8000/api/members/create', formData, {
          headers: { 'Content-Type': 'multipart/form-data' }
        });

        this.$emit('saved', response.data.member);
        this.$emit('close');
      } catch (error) {
        if (error.response && error.response.status === 422) {
          this.errors = error.response.data.errors || {};
        } else {
          alert('An error occurred while saving the member.');
          console.error(error);
        }
      } finally {
        this.loading = false;
      }
    }
  }
};
</script>
