<template>
  <div class="min-h-screen bg-off-white pt-40 px-12 pb-24">
    <Navbar />
    <h1 class="text-6xl font-['Noto_Serif'] mb-24">Architectural Comparison</h1>
    
    <div class="grid grid-cols-4 gap-12">
      <div class="space-y-12">
        <div class="h-64 flex flex-col justify-end pb-8 border-b border-charcoal/5">
           <h3 class="text-xs uppercase tracking-widest font-bold text-charcoal/40">Specifications</h3>
        </div>
        <div v-for="spec in specs" :key="spec" class="py-6 border-b border-charcoal/5 text-sm uppercase tracking-widest font-bold">
           {{ spec }}
        </div>
      </div>

      <div v-for="item in items" :key="item.id" class="space-y-12">
        <div class="h-64 border-b border-charcoal/5">
           <img :src="item.image" class="w-full h-48 object-cover mb-4">
           <h4 class="font-['Noto_Serif'] text-lg">{{ item.title }}</h4>
        </div>
        <div class="py-6 border-b border-charcoal/5 text-gold font-bold">
           ${{ item.price.toLocaleString() }}
        </div>
        <div class="py-6 border-b border-charcoal/5">
           {{ item.type }}
        </div>
        <div class="py-6 border-b border-charcoal/5">
           {{ item.location }}
        </div>
        <div class="py-6 border-b border-charcoal/5">
           {{ item.area }} SQ FT
        </div>
        <div class="py-6 border-b border-charcoal/5">
           {{ item.bhk }} BHK
        </div>
      </div>
    </div>
  </div>
</template>

<script setup>
import { ref, onMounted } from 'vue';
import Navbar from '../layout/Navbar.vue';

const items = ref([]);
const specs = ['Price', 'Property Type', 'Location', 'Total Area', 'Configuration'];

onMounted(() => {
  const list = localStorage.getItem('compare_list');
  if (list) items.value = JSON.parse(list);
});
</script>
