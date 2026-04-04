<template>
  <div v-if="selectedItems.length > 0" class="fixed bottom-0 left-0 w-full bg-charcoal text-white z-[150] shadow-2xl transform transition-transform duration-500">
    <div class="px-12 py-6 flex justify-between items-center">
      <div class="flex items-center space-x-12">
        <h4 class="text-xs uppercase tracking-widest font-bold">Compare Collection ({{ selectedItems.length }}/3)</h4>
        <div class="flex space-x-4">
           <div v-for="item in selectedItems" :key="item.id" class="relative">
              <img :src="item.image" class="w-12 h-12 object-cover border border-gold/50">
              <button @click="removeItem(item.id)" class="absolute -top-2 -right-2 bg-gold text-white text-[8px] rounded-full w-4 h-4">×</button>
           </div>
        </div>
      </div>
      <div class="flex space-x-8">
        <button @click="clear" class="text-xs uppercase tracking-widest font-bold text-white/40">Clear All</button>
        <router-link :to="{ name: 'compare' }" class="bg-gold text-white px-8 py-3 text-xs uppercase tracking-widest font-bold">Compare Now</router-link>
      </div>
    </div>
  </div>
</template>

<script setup>
import { ref, onMounted } from 'vue';

const selectedItems = ref([]);

const removeItem = (id) => {
  selectedItems.value = selectedItems.value.filter(i => i.id !== id);
  localStorage.setItem('compare_list', JSON.stringify(selectedItems.value));
};

const clear = () => {
  selectedItems.value = [];
  localStorage.removeItem('compare_list');
};

onMounted(() => {
  const list = localStorage.getItem('compare_list');
  if (list) selectedItems.value = JSON.parse(list);
  
  // Listen for custom events to add items
  window.addEventListener('add-to-compare', (e) => {
    if (selectedItems.value.length < 3 && !selectedItems.value.find(i => i.id === e.detail.id)) {
      selectedItems.value.push(e.detail);
      localStorage.setItem('compare_list', JSON.stringify(selectedItems.value));
    }
  });
});
</script>
