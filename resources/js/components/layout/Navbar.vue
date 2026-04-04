<template>
  <nav :class="['fixed top-0 w-full z-50 transition-all duration-500 py-6 px-12 flex justify-between items-center', isScrolled || !isHome ? 'bg-white shadow-sm' : 'bg-transparent']">
    <router-link to="/" class="text-2xl font-['Noto_Serif'] font-bold tracking-tighter" :class="isScrolled || !isHome ? 'text-charcoal' : 'text-white'">LUXEESTATE</router-link>
    <div class="hidden md:flex space-x-8 text-sm uppercase tracking-widest font-medium" :class="isScrolled || !isHome ? 'text-charcoal' : 'text-white'">
      <router-link :to="{ name: 'properties' }" class="hover:text-gold transition-colors">Collections</router-link>
      <a href="#" class="hover:text-gold transition-colors">Virtual Tours</a>
      <a href="#" class="hover:text-gold transition-colors">About</a>
      <a href="#" class="hover:text-gold transition-colors">Contact</a>
    </div>
    <button class="bg-primary text-white px-8 py-3 text-xs uppercase tracking-widest font-bold transition-all hover:bg-gold">List a Property</button>
  </nav>
</template>

<script setup>
import { ref, onMounted, onUnmounted, computed } from 'vue';
import { useRoute } from 'vue-router';

const route = useRoute();
const isHome = computed(() => route.name === 'home');
const isScrolled = ref(false);

const handleScroll = () => {
  isScrolled.value = window.scrollY > 50;
};

onMounted(() => window.addEventListener('scroll', handleScroll));
onUnmounted(() => window.removeEventListener('scroll', handleScroll));
</script>
