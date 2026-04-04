<template>
  <div v-if="property" class="min-h-screen bg-off-white">
    <Navbar />
    
    <!-- Gallery -->
    <section class="pt-32 px-12">
      <div class="grid grid-cols-4 grid-rows-2 gap-4 h-[70vh]">
        <div class="col-span-3 row-span-2 overflow-hidden">
           <img :src="property.images?.[0] || 'https://images.unsplash.com/photo-1600585154340-be6199f7d009'" class="w-full h-full object-cover">
        </div>
        <div v-for="i in 2" :key="i" class="overflow-hidden">
           <img :src="property.images?.[i] || 'https://images.unsplash.com/photo-1600607687920-4e2a09cf159d'" class="w-full h-full object-cover">
        </div>
      </div>
    </section>

    <!-- Content -->
    <section class="py-24 px-12 grid grid-cols-1 md:grid-cols-3 gap-24">
      <div class="md:col-span-2">
        <h1 class="text-6xl font-['Noto_Serif'] mb-4">{{ property.title }}</h1>
        <p class="text-xl text-gold mb-12 font-['Noto_Serif']">${{ parseFloat(property.price).toLocaleString() }} &bull; {{ property.location }}</p>
        
        <div class="prose prose-lg text-charcoal/80 mb-24">
          {{ property.description }}
        </div>

        <h3 class="text-xs uppercase tracking-widest font-bold mb-8">Amenities</h3>
        <div class="grid grid-cols-2 md:grid-cols-4 gap-8">
          <div v-for="amenity in (property.metadata?.amenities || ['Pool', 'Gym', 'Cinema'])" :key="amenity" class="flex flex-col items-center p-8 border border-charcoal/5">
             <span class="material-symbols-outlined text-gold mb-4">diamond</span>
             <span class="text-sm font-medium">{{ amenity }}</span>
          </div>
        </div>
      </div>

      <!-- Action Sidebar -->
      <aside>
        <div class="sticky top-40 bg-white p-12 border border-charcoal/5">
          <h4 class="text-xl font-['Noto_Serif'] mb-8">Inquire Privately</h4>
          <form class="space-y-6">
            <input type="text" placeholder="Full Name" class="w-full border-b border-charcoal/10 py-3 text-sm focus:border-gold outline-none">
            <input type="email" placeholder="Email Address" class="w-full border-b border-charcoal/10 py-3 text-sm focus:border-gold outline-none">
            <button class="w-full bg-gold text-white py-4 text-xs uppercase tracking-widest font-bold hover:bg-primary transition-colors">Request a Showing</button>
          </form>
          <div class="mt-8 pt-8 border-t border-charcoal/5 text-center">
            <p class="text-[10px] uppercase tracking-widest text-charcoal/40 mb-4">Assigned Agent</p>
            <p class="font-['Noto_Serif']">Marcus Chen</p>
          </div>
        </div>
      </aside>
    </section>
  </div>
</template>

<script setup>
import { ref, onMounted } from 'vue';
import { useRoute } from 'vue-router';
import axios from 'axios';
import Navbar from '../layout/Navbar.vue';

const route = useRoute();
const property = ref(null);

onMounted(async () => {
  try {
    const response = await axios.get(`/api/properties/${route.params.id}`);
    property.value = response.data;
  } catch (error) {
    console.error('Error fetching property:', error);
  }
});
</script>
