<template>
  <div class="min-h-screen bg-gray-50">
    <nav class="bg-indigo-700 shadow-lg">
      <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between h-16 items-center">
          <div class="flex items-center">
            <div class="text-2xl font-bold text-white flex items-center">
              <span class="material-icons mr-2">local_library</span>
              LibraryPro
            </div>
          </div>
          <div class="hidden md:block">
            <div class="ml-10 flex items-baseline space-x-4">
              <router-link 
                to="/books" 
                class="px-3 py-2 rounded-md text-sm font-medium text-white hover:bg-indigo-600 transition duration-300 flex items-center"
                active-class="bg-indigo-800"
              >
                <span class="material-icons mr-1">menu_book</span> Books
              </router-link>
              <router-link 
                to="/members" 
                class="px-3 py-2 rounded-md text-sm font-medium text-white hover:bg-indigo-600 transition duration-300 flex items-center"
                active-class="bg-indigo-800"
              >
                <span class="material-icons mr-1">people</span> Members
              </router-link>
              <router-link 
                to="/authors" 
                class="px-3 py-2 rounded-md text-sm font-medium text-white hover:bg-indigo-600 transition duration-300 flex items-center"
                active-class="bg-indigo-800"
              >
                <span class="material-icons mr-1">person</span> Authors
              </router-link>
            </div>
          </div>
        </div>
      </div>
    </nav>

    <main class="max-w-7xl mx-auto py-6 sm:px-6 lg:px-8">
      <router-view />
    </main>
  </div>
</template>

<script>
export default {
  name: 'App'
};
</script>

<style>
.router-link-active {
  background-color: rgba(255, 255, 255, 0.1);
}
</style>