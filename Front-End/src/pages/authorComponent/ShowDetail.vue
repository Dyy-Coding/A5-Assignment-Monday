<template>
  <div class="px-6 py-8 max-w-3xl mx-auto bg-gradient-to-br from-purple-100 via-pink-100 to-yellow-100 rounded-3xl shadow-lg">
    <!-- Loading -->
    <div v-if="loading" class="text-center py-16 animate-fade-in">
      <span class="material-icons animate-spin text-pink-500 text-7xl mb-6 select-none">autorenew</span>
      <p class="text-xl font-semibold text-pink-600 tracking-wide">Loading author details...</p>
    </div>

    <!-- Author Details -->
    <div v-else-if="author" class="bg-white rounded-2xl p-8 shadow-xl transform hover:scale-[1.03] transition-transform duration-300">
      <h1 class="text-4xl font-extrabold text-gradient mb-8 select-text">
        {{ author.name || 'N/A' }}
      </h1>

      <div class="flex flex-col md:flex-row items-center md:items-start gap-8">
        <img
          v-if="author.image_url"
          :src="author.image_url"
          alt="Author Image"
          class="w-48 h-48 rounded-xl shadow-md object-cover border-4 border-sky-300"
        />
        <div class="flex-1 space-y-4 text-gray-700 text-lg leading-relaxed">
          <p><span class="font-semibold text-sky-500">Name:</span> {{ (author.name) }}</p>
          <p><span class="font-semibold text-sky-500">Date of Birth:</span> {{ formatDate(author.dateofbirth) }}</p>
          <p><span class="font-semibold text-sky-500">Nationality:</span> {{ author.nationality || 'N/A' }}</p>
          <p><span class="font-semibold text-sky-500">Number of Written Books:</span> {{ author.numberOfWrittenBook || 'N/A' }}</p>
          
        </div>
      </div>

      <button
        @click="$router.push('/authors')" 
        class="mt-10 w-full md:w-auto bg-sky-500 hover:bg-sky-600 text-white font-semibold rounded-lg py-3 px-8 shadow-lg transition-colors duration-250"
      >
        Back
      </button>
    </div>

    <!-- Error -->
    <div v-else class="text-center py-16 text-black-500 font-bold text-xl select-none">
      <p>Author details could not be loaded.</p>
    </div>
  </div>
</template>

<script>
import axios from 'axios';

export default {
  props: {
    authorId: {
      type: [String, Number],
      required: true
    }
  },
  data() {
    return {
      author: null,
      loading: false
    };
  },
  methods: {
    async fetchAuthor() {
      this.loading = true;
      try {
        const response = await axios.get(`http://127.0.0.1:8000/api/authors/show/${this.authorId}`);

        let authorData = response.data.data;
        // console.log(response);
        // console.log(response.data.data);

        
        // Construct image URL
        authorData.image_url = authorData.image ? `http://127.0.0.1:8000/${authorData.image}` : null;
        console.log(authorData.image_url);

        this.author = authorData;
        console.log(authorData);
      } catch (error) {
        console.error('Error loading author details:', error);
        this.author = null;
      } finally {
        this.loading = false;
      }
    },
    formatDate(dateStr) {
      if (!dateStr) return 'N/A';
      const d = new Date(dateStr);
      if (isNaN(d)) return 'N/A';
      return d.toLocaleDateString();
    }
  },
  watch: {
    authorId: {
      immediate: true,
      handler() {
        this.fetchAuthor();
      }
    }
  }
};
</script>

<style scoped>
@import url('https://fonts.googleapis.com/css2?family=Poppins:wght@600;800&display=swap');

.text-gradient {
  background: linear-gradient(90deg, #03cdff, #7873f5);
  -webkit-text-fill-color: transparent;
}

.animate-fade-in {
  animation: fadeIn 0.6s ease forwards;
}

@keyframes fadeIn {
  from { opacity: 0; }
  to { opacity: 1; }
}

/* Scrollbar Styling for books list */
::-webkit-scrollbar {
  width: 6px;
}
::-webkit-scrollbar-track {
  background: #16ffff;
  border-radius: 8px;
}
::-webkit-scrollbar-thumb {
  background-color: #486bec; /* pink-500 */
  border-radius: 8px;
}

/* Material Icons Fix */
.material-icons {
  user-select: none;
  pointer-events: none;
}

/* Smooth image hover scale */
img:hover {
  transform: scale(1.05);
  transition: transform 0.3s ease;
}
</style>
