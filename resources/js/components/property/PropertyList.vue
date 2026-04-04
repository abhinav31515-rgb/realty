<template>
  <div class="min-h-screen bg-off-white pt-32 px-12">
    <div class="flex flex-col md:flex-row gap-12">
      <!-- Filter Sidebar -->
      <aside class="w-full md:w-1/4">
        <h2 class="text-2xl font-['Noto_Serif'] mb-8">Filters</h2>
        <div class="space-y-8">
          <div>
            <label class="text-[10px] uppercase tracking-widest font-bold mb-2 block">Location</label>
            <input v-model="filters.location" @input="fetchProperties" type="text" placeholder="Search location..." class="w-full bg-transparent border-b border-charcoal/20 focus:border-gold outline-none py-2 text-sm">
          </div>
          <div>
            <label class="text-[10px] uppercase tracking-widest font-bold mb-4 block">Property Type</label>
            <div class="space-y-2">
              <label v-for="type in types" :key="type" class="flex items-center space-x-3 cursor-pointer group">
                <input type="checkbox" v-model="filters.types" :value="type" @change="fetchProperties" class="hidden">
                <div class="w-4 h-4 border border-charcoal/20 group-hover:border-gold transition-colors flex items-center justify-center" :class="filters.types.includes(type) ? 'bg-gold border-gold' : ''">
                   <span v-if="filters.types.includes(type)" class="material-symbols-outlined text-[12px] text-white">check</span>
                </div>
                <span class="text-sm">{{ type }}</span>
              </label>
            </div>
          </div>
        </div>
      </aside>

      <!-- Results Grid -->
      <main class="w-full md:w-3/4">
        <div class="flex justify-between items-center mb-12">
          <p class="text-sm text-charcoal/40">{{ properties.length }} Masterpieces Found</p>
        </div>
        
        <div v-if="loading" class="grid grid-cols-1 md:grid-cols-2 gap-12 animate-pulse">
           <div v-for="i in 4" :key="i" class="h-96 bg-charcoal/5"></div>
        </div>
        
        <div v-else class="grid grid-cols-1 md:grid-cols-2 gap-12">
          <PropertyCard 
            v-for="property in properties" 
            :key="property.id"
            :title="property.title"
            :location="property.location"
            :price="parseFloat(property.price)"
            :image="property.images?.[0] || 'https://images.unsplash.com/photo-1600585154340-be6199f7d009'"
            @click="goToDetail(property.id)"
          />
        </div>
      </main>
    </div>
  </div>
</template>

<script setup>
import { ref, onMounted, reactive } from 'vue';
import { useRouter } from 'vue-router';
import axios from 'axios';
import PropertyCard from './PropertyCard.vue';

const router = useRouter();
const properties = ref([]);
const loading = ref(true);
const types = ['Villa', 'Penthouse', 'Mansion', 'Estate'];

const filters = reactive({
  location: '',
  types: []
});

const fetchProperties = async () => {
  loading.value = true;
  try {
    const response = await axios.get('/api/properties', {
      params: {
        location: filters.location,
        type: filters.types.join(',')
      }
    });
    properties.value = response.data.data;
  } catch (error) {
    console.error('Error fetching properties:', error);
  } finally {
    loading.value = false;
  }
};

const goToDetail = (id) => {
  router.push({ name: 'property-detail', params: { id } });
};

onMounted(fetchProperties);
</script>
