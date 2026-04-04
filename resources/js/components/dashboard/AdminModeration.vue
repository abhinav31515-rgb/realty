<template>
  <div class="min-h-screen bg-off-white flex">
    <aside class="w-64 bg-charcoal text-white p-8">
      <router-link to="/admin" class="block text-gold mb-12 font-bold">← BACK</router-link>
      <h2 class="text-xs uppercase tracking-widest font-bold">Moderation</h2>
    </aside>

    <main class="flex-1 p-12">
      <h1 class="text-4xl font-['Noto_Serif'] mb-12">Pending Architectural Review</h1>
      
      <div v-if="pendingProperties.length === 0" class="text-charcoal/40 italic">No properties currently awaiting review.</div>

      <div class="grid grid-cols-1 gap-8">
        <div v-for="property in pendingProperties" :key="property.id" class="bg-white p-8 border border-charcoal/5 flex justify-between items-center">
          <div class="flex items-center space-x-8">
            <div class="w-24 h-24 bg-charcoal/5"></div>
            <div>
              <h3 class="text-xl font-['Noto_Serif']">{{ property.title }}</h3>
              <p class="text-sm text-charcoal/60">{{ property.location }} &bull; ${{ parseFloat(property.price).toLocaleString() }}</p>
            </div>
          </div>
          <div class="flex space-x-6">
            <button @click="approve(property.id)" class="text-gold text-xs uppercase tracking-widest font-bold">Approve</button>
            <button @click="reject(property.id)" class="text-charcoal/40 text-xs uppercase tracking-widest font-bold hover:text-red-500">Reject</button>
          </div>
        </div>
      </div>
    </main>
  </div>
</template>

<script setup>
import { ref, onMounted } from 'vue';
import axios from 'axios';

const pendingProperties = ref([]);

const fetchPending = async () => {
  const token = localStorage.getItem('auth_token');
  try {
    const response = await axios.get('/api/properties?status=pending', {
      headers: { Authorization: `Bearer ${token}` }
    });
    // For simplicity, using client-side filter if backend filter not fully ready
    pendingProperties.value = response.data.data.filter(p => p.status === 'pending');
  } catch (error) {
    console.error(error);
  }
};

const approve = async (id) => {
  const token = localStorage.getItem('auth_token');
  await axios.put(`/api/properties/${id}`, { status: 'active' }, {
    headers: { Authorization: `Bearer ${token}` }
  });
  fetchPending();
};

const reject = async (id) => {
  const token = localStorage.getItem('auth_token');
  await axios.put(`/api/properties/${id}`, { status: 'rejected' }, {
    headers: { Authorization: `Bearer ${token}` }
  });
  fetchPending();
};

onMounted(fetchPending);
</script>
