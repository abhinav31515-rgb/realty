<template>
  <div class="group cursor-pointer relative" :class="asymmetric ? 'md:mt-24' : ''">
    <!-- Action Icons -->
    <div class="absolute top-6 right-6 z-10 flex flex-col space-y-2">
      <button @click.stop="toggleFavorite" class="w-10 h-10 bg-white/90 backdrop-blur-md flex items-center justify-center transition-all hover:bg-gold hover:text-white">
         <span class="material-symbols-outlined text-[20px]" :class="isFavorited ? 'fill-1' : ''">favorite</span>
      </button>
      <button @click.stop="addToCompare" class="w-10 h-10 bg-white/90 backdrop-blur-md flex items-center justify-center transition-all hover:bg-gold hover:text-white">
         <span class="material-symbols-outlined text-[20px]">compare_arrows</span>
      </button>
    </div>

    <div @click="goToDetail" class="aspect-[4/5] overflow-hidden mb-6">
      <img :src="image" :alt="title" class="w-full h-full object-cover transition-transform duration-700 group-hover:scale-105">
    </div>
    <div @click="goToDetail" class="flex justify-between items-start">
      <div>
        <h3 class="text-xl font-['Noto_Serif'] mb-1">{{ title }}</h3>
        <p class="text-sm text-charcoal/60">{{ location }}</p>
      </div>
      <div class="text-lg font-['Noto_Serif'] font-bold">${{ price.toLocaleString() }}</div>
    </div>
  </div>
</template>

<script setup>
import { ref } from 'vue';
import { useRouter } from 'vue-router';
import api from '../../../api';

const props = defineProps({
  id: Number,
  title: String,
  location: String,
  price: Number,
  image: String,
  asymmetric: Boolean,
  type: String,
  area: Number,
  bhk: Number
});

const router = useRouter();
const isFavorited = ref(false);

const goToDetail = () => {
    // Record click for analytics
    api.post(`/properties/${props.id}/click`);
    if (props.id) router.push({ name: 'property-detail', params: { id: props.id } });
};

const addToCompare = () => {
  window.dispatchEvent(new CustomEvent('add-to-compare', { 
    detail: { ...props } 
  }));
};

const toggleFavorite = async () => {
  const token = localStorage.getItem('auth_token');
  if (!token) { router.push({ name: 'login' }); return; }
  try {
    if (isFavorited.value) {
      await api.delete(`/favorites/${props.id}`, { headers: { Authorization: `Bearer ${token}` } });
      isFavorited.value = false;
    } else {
      await api.post('/favorites', { property_id: props.id }, { headers: { Authorization: `Bearer ${token}` } });
      isFavorited.value = true;
    }
  } catch (error) { console.error(error); }
};
</script>

<style scoped>
.fill-1 { font-variation-settings: 'FILL' 1; color: #775a19; }
</style>
