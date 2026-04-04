<template>
  <div class="min-h-screen bg-off-white">
    <Navbar />
    
    <div class="pt-32 px-12 pb-12 flex justify-between items-end border-b border-charcoal/5">
       <div class="flex space-x-12 text-xs uppercase tracking-widest font-bold">
          <button v-for="cat in ['buy', 'rent', 'commercial']" :key="cat" @click="filters.category = cat; fetchProperties()" :class="filters.category === cat ? 'text-gold border-b border-gold' : 'text-charcoal/40'">{{ cat }}</button>
       </div>
       <button @click="showMap = !showMap" class="text-xs uppercase tracking-widest font-bold bg-charcoal text-white px-6 py-2">
          {{ showMap ? 'Show List' : 'Show Map' }}
       </button>
    </div>

    <div class="flex flex-col md:flex-row min-h-[calc(100vh-200px)]">
      <!-- Filter Sidebar -->
      <aside v-if="!showMap" class="w-full md:w-1/4 p-12 border-r border-charcoal/5">
        <h2 class="text-2xl font-['Noto_Serif'] mb-8">Filters</h2>
        <div class="space-y-8">
          <div>
            <label class="text-[10px] uppercase tracking-widest font-bold mb-2 block">Location</label>
            <input v-model="filters.location" @input="fetchProperties" type="text" placeholder="Search location..." class="w-full bg-transparent border-b border-charcoal/20 focus:border-gold outline-none py-2 text-sm font-['Noto_Serif']">
          </div>
          <div>
             <label class="text-[10px] uppercase tracking-widest font-bold mb-2 block">Price Range (Millions)</label>
             <input v-model="filters.max_price" @change="fetchProperties" type="range" min="1" max="100" class="w-full accent-gold">
             <div class="flex justify-between text-[10px] mt-2"><span>$1M</span><span>$100M+</span></div>
          </div>
          <div>
            <label class="text-[10px] uppercase tracking-widest font-bold mb-4 block">Architectural Type</label>
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

      <!-- Results Grid or Map -->
      <main :class="showMap ? 'w-full h-[80vh]' : 'w-full md:w-3/4 p-12'">
        <div v-if="showMap" id="map" class="w-full h-full grayscale-[0.5] contrast-[1.1]"></div>
        
        <template v-else>
          <div v-if="loading" class="grid grid-cols-1 md:grid-cols-2 gap-12 animate-pulse">
             <div v-for="i in 4" :key="i" class="h-96 bg-charcoal/5"></div>
          </div>
          
          <div v-else class="grid grid-cols-1 md:grid-cols-2 gap-12">
            <PropertyCard 
              v-for="property in properties" 
              :key="property.id"
              :id="property.id"
              :title="property.title"
              :location="property.location"
              :price="parseFloat(property.price)"
              :image="property.images?.[0] || 'https://images.unsplash.com/photo-1600585154340-be6199f7d009'"
            />
          </div>
        </template>
      </main>
    </div>
  </div>
</template>

<script setup>
import { ref, onMounted, reactive, watch } from 'vue';
import axios from 'axios';
import mapboxgl from 'mapbox-gl';
import 'mapbox-gl/dist/mapbox-gl.css';
import Navbar from '../layout/Navbar.vue';
import PropertyCard from './PropertyCard.vue';

const properties = ref([]);
const loading = ref(true);
const showMap = ref(false);
const types = ['Villa', 'Penthouse', 'Mansion', 'Estate'];

const filters = reactive({
  location: '',
  types: [],
  category: 'buy',
  max_price: 100
});

const fetchProperties = async () => {
  loading.value = true;
  try {
    const response = await axios.get('/api/properties', {
      params: {
        location: filters.location,
        type: filters.types.join(','),
        category: filters.category,
        max_price: filters.max_price * 1000000
      }
    });
    properties.value = response.data.data;
  } catch (error) {
    console.error(error);
  } finally {
    loading.value = false;
  }
};

const initMap = () => {
  mapboxgl.accessToken = 'pk.eyJ1IjoiYWJoaW5hdjMxNTE1IiwiYSI6ImNsemRzN3BqejBqN2UycW9uN2R4N2R4N2R4In0.V1_dummy_key'; // Placeholder
  const map = new mapboxgl.Map({
    container: 'map',
    style: 'mapbox://styles/mapbox/light-v11',
    center: [-118.2437, 34.0522], // LA
    zoom: 9
  });
  
  // Custom gold markers for properties would go here
};

onMounted(fetchProperties);
watch(showMap, (val) => { if (val) setTimeout(initMap, 100); });
</script>

<style>
.mapboxgl-ctrl-logo, .mapboxgl-ctrl-attrib { display: none !important; }
</style>
