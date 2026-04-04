<template>
  <div class="min-h-screen bg-off-white flex">
    <aside class="w-64 bg-charcoal text-white p-8">
      <router-link to="/admin" class="block text-gold mb-12 font-bold">← BACK TO DASHBOARD</router-link>
      <h2 class="text-xs uppercase tracking-widest font-bold mb-8">Content Management</h2>
      <nav class="space-y-4 text-sm">
        <button @click="contentType = 'guide'" :class="contentType === 'guide' ? 'text-gold' : 'text-white/60'">Guides</button>
        <button @click="contentType = 'faq'" :class="contentType === 'faq' ? 'text-gold' : 'text-white/60'" class="block">FAQs</button>
        <button @click="contentType = 'blog'" :class="contentType === 'blog' ? 'text-gold' : 'text-white/60'" class="block">Blog</button>
      </nav>
    </aside>

    <main class="flex-1 p-12">
      <header class="flex justify-between items-center mb-12">
        <h1 class="text-4xl font-['Noto_Serif']">Manage {{ contentType }}s</h1>
        <button @click="openCreateModal" class="bg-gold text-white px-8 py-3 text-xs uppercase tracking-widest font-bold hover:bg-primary transition-all">New Entry</button>
      </header>

      <div class="bg-white border border-charcoal/5">
        <div v-for="item in contentItems" :key="item.id" class="p-8 border-b border-charcoal/5 flex justify-between items-center last:border-0">
          <div>
            <h3 class="font-['Noto_Serif'] text-lg">{{ item.title }}</h3>
            <p class="text-xs text-charcoal/40 uppercase tracking-widest mt-1">Slug: {{ item.slug }}</p>
          </div>
          <div class="flex space-x-6 text-xs uppercase tracking-widest font-bold">
            <button class="text-gold">Edit</button>
            <button class="text-charcoal/40 hover:text-red-500">Delete</button>
          </div>
        </div>
      </div>
    </main>

    <!-- Simple Modal Overlay -->
    <div v-if="showModal" class="fixed inset-0 bg-charcoal/60 backdrop-blur-sm z-[100] flex items-center justify-center p-12">
       <div class="bg-white w-full max-w-2xl p-12 relative">
          <button @click="showModal = false" class="absolute top-8 right-8 material-symbols-outlined">close</button>
          <h2 class="text-3xl font-['Noto_Serif'] mb-8">Create {{ contentType }}</h2>
          <form @submit.prevent="saveContent" class="space-y-6">
             <input v-model="form.title" type="text" placeholder="Title" class="w-full border-b border-charcoal/20 py-3 outline-none focus:border-gold">
             <input v-model="form.slug" type="text" placeholder="Slug" class="w-full border-b border-charcoal/20 py-3 outline-none focus:border-gold">
             <textarea v-model="form.body" placeholder="Content Body (Markdown supported)" rows="8" class="w-full border border-charcoal/10 p-4 outline-none focus:border-gold text-sm"></textarea>
             <button type="submit" class="w-full bg-gold text-white py-4 text-xs uppercase tracking-widest font-bold">Publish</button>
          </form>
       </div>
    </div>
  </div>
</template>

<script setup>
import { ref, onMounted, watch } from 'vue';
import axios from 'axios';

const contentType = ref('guide');
const contentItems = ref([]);
const showModal = ref(false);
const form = ref({ title: '', slug: '', body: '' });

const fetchContent = async () => {
  try {
    const response = await axios.get(`/api/content?type=${contentType.value}`);
    contentItems.value = response.data;
  } catch (error) {
    console.error('Error fetching content:', error);
  }
};

const openCreateModal = () => {
  form.value = { title: '', slug: '', body: '' };
  showModal.value = true;
};

const saveContent = async () => {
  try {
    const token = localStorage.getItem('auth_token');
    await axios.post('/api/content', { ...form.value, type: contentType.value }, {
        headers: { Authorization: `Bearer ${token}` }
    });
    showModal.value = false;
    fetchContent();
  } catch (error) {
    alert('Failed to save content. Ensure you are logged in as admin.');
  }
};

onMounted(fetchContent);
watch(contentType, fetchContent);
</script>
