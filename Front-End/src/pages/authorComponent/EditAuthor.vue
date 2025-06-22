<template>
  <div class="px-6 py-10 max-w-3xl mx-auto bg-white/70 backdrop-blur-md rounded-3xl shadow-2xl">
    <h1 class="text-4xl font-extrabold bg-gradient-to-r from-sky-400 to-indigo-600 text-transparent bg-clip-text mb-8 text-center">
      Edit Author ✍️
    </h1>

    <form @submit.prevent="updateAuthor" v-if="author" class="space-y-6">
      <!-- Image Preview -->
      <div v-if="author.image_url" class="flex justify-center">
        <img :src="author.image_url" alt="Author Image" class="w-32 h-32 rounded-full object-cover border-4 border-indigo-400 shadow-lg" />
      </div>

      <!-- Form Inputs -->
      <div class="grid gap-4 md:grid-cols-2">
        <div>
          <label class="block text-sm font-semibold text-gray-600 mb-1">Name</label>
          <input v-model="form.name" type="text" placeholder="Author Name" class="w-full input-field" required />
        </div>
        <div>
          <label class="block text-sm font-semibold text-gray-600 mb-1">Date of Birth</label>
          <input v-model="form.dateofbirth" type="date" class="w-full input-field" required />
        </div>
        <div>
          <label class="block text-sm font-semibold text-gray-600 mb-1">Nationality</label>
          <input v-model="form.nationality" type="text" placeholder="Nationality" class="w-full input-field" required />
        </div>
        <div>
          <label class="block text-sm font-semibold text-gray-600 mb-1">Books Written</label>
          <input v-model.number="form.numberOfWrittenBook" type="number" class="w-full input-field" required />
        </div>
        <div class="md:col-span-2">
          <label class="block text-sm font-semibold text-gray-600 mb-1">Update Image</label>
          <input @change="handleImageUpload" type="file" accept="image/*" class="block w-full text-sm text-slate-500
            file:mr-4 file:py-2 file:px-4
            file:rounded-lg file:border-0
            file:text-sm file:font-semibold
            file:bg-indigo-50 file:text-indigo-700
            hover:file:bg-indigo-100
          " />
        </div>
      </div>

      <!-- Buttons -->
      <div class="flex flex-wrap justify-center gap-4 pt-6">
        <button type="submit"           class="bg-yellow-400 hover:bg-yellow-500 text-white font-semibold rounded-lg py-3 px-8 shadow-lg transition-colors duration-250"
>💾 Update</button>
        <button @click.prevent="$router.push('/authors')"           class="bg-red-400 hover:bg-red-500 text-white font-semibold rounded-lg py-3 px-8 shadow-lg transition-colors duration-250"
>↩️ Cancel</button>
      </div>
    </form>

    <!-- Error Display -->
    <div v-else class="text-center text-red-500 font-semibold mt-10">
      Failed to load author data. 😢
    </div>
  </div>
</template>

<script>
import axios from 'axios';

export default {
  name: 'EditAuthor',
  props: {
    authorId: {
      type: [String, Number],
      required: true
    }
  },
  data() {
    return {
      author: null,
      form: {
        name: '',
        dateofbirth: '',
        nationality: '',
        numberOfWrittenBook: '',
        image: null,
      },
    };
  },
  methods: {
    async fetchAuthor() {
      try {
        const res = await axios.get(`http://127.0.0.1:8000/api/authors/show/${this.authorId}`);
        const author = res.data.data;
        author.image_url = author.image ? `http://127.0.0.1:8000/${author.image}` : null;
        this.author = author;

        this.form.name = author.name;
        this.form.dateofbirth = author.dateofbirth;
        this.form.nationality = author.nationality;
        this.form.numberOfWrittenBook = author.numberOfWrittenBook;
      } catch (err) {
        console.error("Failed to load author data:", err);
      }
    },
    handleImageUpload(event) {
      this.form.image = event.target.files[0];
    },
    async updateAuthor() {
      const formData = new FormData();
      formData.append('name', this.form.name);
      formData.append('dateofbirth', this.form.dateofbirth);
      formData.append('nationality', this.form.nationality);
      formData.append('numberOfWrittenBook', this.form.numberOfWrittenBook);
      if (this.form.image) {
        formData.append('image', this.form.image);
      }

      try {
        await axios.post(
          `http://127.0.0.1:8000/api/authors/update/${this.authorId}`,
          formData,
          { headers: { 'Content-Type': 'multipart/form-data' } }
        );
        alert('✅ Author updated successfully!');
        this.$router.push('/authors');
      } catch (error) {
        console.error('Update failed:', error);
        alert('❌ Failed to update author.');
      }
    }
  },
  mounted() {
    this.fetchAuthor();
  }
};
</script>


