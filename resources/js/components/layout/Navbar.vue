<template>
  <nav :class="['fixed top-0 w-full z-50 transition-all duration-500 py-6 px-12 flex justify-between items-center', isScrolled || !isHome ? 'bg-white shadow-sm' : 'bg-transparent']">
    <router-link to="/" class="text-2xl font-['Noto_Serif'] font-bold tracking-tighter" :class="isScrolled || !isHome ? 'text-charcoal' : 'text-white'">LUXEESTATE</router-link>
    <div class="hidden md:flex space-x-8 text-sm uppercase tracking-widest font-medium" :class="isScrolled || !isHome ? 'text-charcoal' : 'text-white'">
      <router-link :to="{ name: 'properties' }" class="hover:text-gold transition-colors">Collections</router-link>
      <a href="#" class="hover:text-gold transition-colors">Virtual Tours</a>
      <router-link v-if="isAuthenticated" :to="{ name: 'customer-dashboard' }" class="hover:text-gold transition-colors">My Collection</router-link>
      <router-link v-else :to="{ name: 'login' }" class="hover:text-gold transition-colors">Sign In</router-link>
    </div>
    <div class="flex items-center space-x-6">
      <div v-if="isAuthenticated" class="relative">
        <span class="material-symbols-outlined cursor-pointer" :class="isScrolled || !isHome ? 'text-charcoal' : 'text-white'">notifications</span>
        <span v-if="unreadCount > 0" class="absolute -top-1 -right-1 bg-gold text-white text-[8px] font-bold px-1.5 py-0.5 rounded-full">{{ unreadCount }}</span>
      </div>
      <button class="bg-primary text-white px-8 py-3 text-xs uppercase tracking-widest font-bold transition-all hover:bg-gold">List a Property</button>
    </div>
  </nav>
</template>

<script setup>
import { ref, onMounted, onUnmounted, computed } from 'vue';
import { useRoute } from 'vue-router';
import { supabase } from '../../supabase';

const route = useRoute();
const isHome = computed(() => route.name === 'home');
const isScrolled = ref(false);
const isAuthenticated = computed(() => !!localStorage.getItem('auth_token'));
const unreadCount = ref(0);

const handleScroll = () => {
  isScrolled.value = window.scrollY > 50;
};

const setupRealtime = () => {
    if (!isAuthenticated.value) return;
    
    // Subscribe to new notifications
    supabase
        .channel('schema-db-changes')
        .on(
            'postgres_changes',
            { event: 'INSERT', schema: 'public', table: 'notifications' },
            (payload) => {
                console.log('New notification:', payload);
                unreadCount.value++;
                // In a real app, we'd check if payload.new.user_id matches current user
            }
        )
        .subscribe();
};

onMounted(() => {
    window.addEventListener('scroll', handleScroll);
    setupRealtime();
});
onUnmounted(() => window.removeEventListener('scroll', handleScroll));
</script>
