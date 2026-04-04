<template>
  <nav :class="['fixed top-0 w-full z-50 transition-all duration-500 py-6 px-12 flex justify-between items-center', isScrolled ? 'bg-white shadow-sm' : 'bg-transparent']">
    <div class="text-2xl font-['Noto_Serif'] font-bold tracking-tighter" :class="isScrolled ? 'text-charcoal' : 'text-white'">LUXEESTATE</div>
    <div class="hidden md:flex space-x-8 text-sm uppercase tracking-widest font-medium" :class="isScrolled ? 'text-charcoal' : 'text-white'">
      <a href="#" class="hover:text-gold transition-colors">Collections</a>
      <a href="#" class="hover:text-gold transition-colors">Virtual Tours</a>
      <a href="#" class="hover:text-gold transition-colors">About</a>
      <a href="#" class="hover:text-gold transition-colors">Contact</a>
    </div>
    <button class="bg-primary text-white px-8 py-3 text-xs uppercase tracking-widest font-bold transition-all hover:bg-gold">List a Property</button>
  </nav>
</template>

<script setup>
import { ref, onMounted, onUnmounted } from 'vue';
const isScrolled = ref(false);
const handleScroll = () => {
  isScrolled.value = window.scrollY > 50;
};
onMounted(() => window.addEventListener('scroll', handleScroll));
onUnmounted(() => window.removeEventListener('scroll', handleScroll));
</script>
