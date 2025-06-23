<template>
  <div class="p-6 bg-sky-50 rounded-2xl shadow-lg max-w-xl mx-auto">
    <h2 class="text-2xl font-extrabold mb-6 text-sky-700 flex items-center">
      <span class="material-icons mr-2 text-sky-500">edit</span>
      Edit Member
    </h2>

    <form @submit.prevent="updateMember" class="space-y-5" enctype="multipart/form-data">
      <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
        <input
          v-model="form.FirstName"
          placeholder="First Name"
          class="border border-sky-300 focus:ring-2 focus:ring-sky-400 focus:outline-none px-4 py-3 rounded-xl bg-white shadow-sm text-gray-800 placeholder-sky-300 transition"
        />
        <input
          v-model="form.LastName"
          placeholder="Last Name"
          class="border border-sky-300 focus:ring-2 focus:ring-sky-400 focus:outline-none px-4 py-3 rounded-xl bg-white shadow-sm text-gray-800 placeholder-sky-300 transition"
        />
        <input
          v-model="form.Email"
          type="email"
          placeholder="Email"
          class="border border-sky-300 focus:ring-2 focus:ring-sky-400 focus:outline-none px-4 py-3 rounded-xl bg-white shadow-sm text-gray-800 placeholder-sky-300 transition"
        />
        <input
          v-model="form.Phone"
          placeholder="Phone"
          class="border border-sky-300 focus:ring-2 focus:ring-sky-400 focus:outline-none px-4 py-3 rounded-xl bg-white shadow-sm text-gray-800 placeholder-sky-300 transition"
        />
        <input
          v-model="form.Address"
          placeholder="Address"
          class="md:col-span-2 border border-sky-300 focus:ring-2 focus:ring-sky-400 focus:outline-none px-4 py-3 rounded-xl bg-white shadow-sm text-gray-800 placeholder-sky-300 transition"
        />

        <!-- 👇 Image Preview Section -->
        <div class="md:col-span-2">
          <label class="block mb-2 text-sm font-medium text-sky-700">Current Image:</label>
          <div v-if="previewImage" class="mb-4">
            <img
              :src="previewImage"
              alt="Preview"
              class="w-24 h-24 object-cover rounded-full border border-sky-300"
            />
          </div>
          <input
            type="file"
            @change="handleFileUpload"
            class="w-full border border-sky-300 focus:ring-2 focus:ring-sky-400 focus:outline-none px-4 py-3 rounded-xl bg-white shadow-sm text-gray-800 transition
                   file:mr-3 file:py-2 file:px-4 file:rounded-full file:border-0 file:bg-sky-600 file:text-white hover:file:bg-sky-700"
          />
        </div>
      </div>

      <!-- Buttons -->
      <div class="flex justify-between gap-4 pt-4">
        <button
          type="submit"
          class="w-full bg-sky-600 hover:bg-sky-700 text-white font-semibold py-3 rounded-2xl shadow-md flex items-center justify-center space-x-2 transition"
        >
          <span class="material-icons">save</span>
          <span>Update</span>
        </button>

        <button
          type="button"
          @click="cancelEdit"
          class="w-full bg-white text-sky-600 hover:bg-sky-100 border border-sky-300 font-semibold py-3 rounded-2xl shadow flex items-center justify-center space-x-2 transition"
        >
          <span class="material-icons">arrow_back</span>
          <span>Cancel</span>
        </button>
      </div>
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
        Address: ''
      },
      imageFile: null,
      previewImage: null
    };
  },
  mounted() {
    axios.get(`http://localhost:8000/api/members/show/${this.memberId}`)
      .then(response => {
        const member = response.data.member || response.data;
        this.form = {
          FirstName: member.FirstName,
          LastName: member.LastName,
          Email: member.Email,
          Phone: member.Phone,
          Address: member.Address
        };
        this.previewImage = member.Image?.startsWith('http')
          ? member.Image
          : `http://localhost:8000/${member.Image}`;
      })
      .catch(error => {
        console.error('Error loading member:', error);
        alert('Could not load member data.');
      });
  },
  methods: {
    handleFileUpload(event) {
      this.imageFile = event.target.files[0];
      if (this.imageFile) {
        const reader = new FileReader();
        reader.onload = e => {
          this.previewImage = e.target.result;
        };
        reader.readAsDataURL(this.imageFile);
      }
    },
    async updateMember() {
      try {
        const formData = new FormData();

        // Append non-null fields
        for (const key in this.form) {
          if (this.form[key] !== null && this.form[key] !== undefined) {
            formData.append(key, this.form[key]);
          }
        }

        if (this.imageFile) {
          formData.append('Image', this.imageFile);
        }

        formData.append('_method', 'PUT');

        console.log('Submitting form data:', [...formData.entries()]); // Debug

        await axios.post(
          `http://localhost:8000/api/members/update/${this.memberId}`,
          formData,
          {
            headers: {
              'Content-Type': 'multipart/form-data'
            }
          }
        );

        alert('✅ Member updated successfully!');
        this.$router.push('/members');
      } catch (error) {
        if (error.response && error.response.status === 422) {
          console.error('Validation errors:', error.response.data.errors);
          const errorMessages = Object.values(error.response.data.errors).flat().join('\n');
          alert('❌ Validation failed:\n' + errorMessages);
        } else {
          console.error('Update failed:', error);
          alert('❌ Failed to update member.');
        }
      }
    },
    cancelEdit() {
      this.$router.push('/members');
    }
  }
};
</script>
