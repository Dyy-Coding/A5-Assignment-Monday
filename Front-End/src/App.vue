<template>
  <div>
    <nav class="flex justify-between items-center bg-blue-800 text-white p-4 shadow-lg">
      <div class="flex space-x-4">
        <router-link to="/books" class="hover:underline">BookPage</router-link>
        <router-link to="/members" class="hover:underline">MemberPage</router-link>
        <router-link to="/authors" class="hover:underline">AuthorPage</router-link>
      </div>
    </nav>
    <router-view />
  </div>
</template>

<script>
export default {
  name: 'App',
}
</script>
