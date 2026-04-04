<template>
  <div class="min-h-screen flex flex-col">
    <Navbar />
    
    <!-- Hero -->
    <section class="relative h-screen flex items-center px-12 overflow-hidden">
      <div class="absolute inset-0 z-0">
        <img src="https://images.unsplash.com/photo-1600585154340-be6199f7d009" alt="Modern Villa" class="w-full h-full object-cover">
        <div class="absolute inset-0 bg-charcoal/20"></div>
      </div>
      
      <div class="relative z-10 max-w-4xl">
        <h1 class="text-8xl font-['Noto_Serif'] text-white leading-none mb-8 -ml-1">Reshape Your<br>Reality</h1>
        <div class="bg-white/90 backdrop-blur-md p-2 flex items-center w-full max-w-2xl mt-12">
          <input v-model="search" type="text" placeholder="Location" class="flex-1 bg-transparent border-none focus:ring-0 px-6 py-4 text-sm">
          <div class="h-8 w-px bg-charcoal/10"></div>
          <button @click="goToListings" class="bg-charcoal text-white px-10 py-4 text-xs uppercase tracking-widest font-bold">Search</button>
        </div>
      </div>
    </section>

    <!-- Featured -->
    <section class="py-32 px-12">
      <div class="flex justify-between items-end mb-16">
        <h2 class="text-4xl font-['Noto_Serif']">Featured Collection</h2>
        <router-link :to="{ name: 'properties' }" class="text-xs uppercase tracking-widest font-bold border-b border-gold pb-1">View All Properties</router-link>
      </div>
      
      <div class="grid grid-cols-1 md:grid-cols-3 gap-12">
        <PropertyCard 
          title="The Obsidian Sanctuary" 
          location="Beverly Hills, CA" 
          :price="24500000" 
          image="https://images.unsplash.com/photo-1613490493576-7fde63acd811"
          @click="router.push('/properties/1')"
        />
        <PropertyCard 
          title="The Zenith Penthouse" 
          location="New York, NY" 
          :price="18200000" 
          image="https://images.unsplash.com/photo-1512917774080-9991f1c4c750"
          asymmetric
          @click="router.push('/properties/2')"
        />
        <PropertyCard 
          title="Marquina Villa" 
          location="Bel Air, CA" 
          :price="15750000" 
          image="https://images.unsplash.com/photo-1600607687920-4e2a09cf159d"
        />
      </div>
    </section>

    <!-- Services -->
    <section class="bg-charcoal text-white py-32 px-12">
      <div class="grid grid-cols-1 md:grid-cols-3 gap-24">
        <div v-for="service in services" :key="service.title">
          <span class="material-symbols-outlined text-gold text-4xl mb-6">{{ service.icon }}</span>
          <h4 class="text-xl font-['Noto_Serif'] mb-4">{{ service.title }}</h4>
          <p class="text-sm text-white/60 leading-relaxed">{{ service.desc }}</p>
        </div>
      </div>
    </section>

    <footer class="bg-off-white py-24 px-12 border-t border-charcoal/5">
      <div class="text-center text-xs uppercase tracking-widest text-charcoal/40">
        &copy; 2026 LuxeEstate. Architectural Integrity.
      </div>
    </footer>
  </div>
</template>

<script setup>
import { ref } from 'vue';
import { useRouter } from 'vue-router';
import Navbar from './layout/Navbar.vue';
import PropertyCard from './property/PropertyCard.vue';

const router = useRouter();
const search = ref('');

const goToListings = () => {
    router.push({ name: 'properties', query: { location: search.value } });
};

const services = [
  { icon: 'auto_awesome', title: 'Curated Listings', desc: 'Only the most architecturally significant properties make it into our private collection.' },
  { icon: 'vr_pano', title: 'Virtual Reality Tours', desc: 'Experience every corner of your future home from anywhere in the world with 8K clarity.' },
  { icon: 'concierge', title: 'Bespoke Concierge', desc: 'From private jet transfers to interior design consultations, we handle every detail.' }
];
</script>
