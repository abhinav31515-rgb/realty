<template>
  <nav class="md:hidden fixed bottom-0 left-0 w-full bg-white border-t border-charcoal/5 px-6 py-4 flex justify-between items-center z-[200]">
    <router-link to="/" class="flex flex-col items-center text-charcoal/40" active-class="text-gold">
      <span class="material-symbols-outlined text-lg">home</span>
      <span class="text-[8px] uppercase font-bold tracking-widest mt-1">Home</span>
    </router-link>
    <router-link :to="{ name: 'properties' }" class="flex flex-col items-center text-charcoal/40" active-class="text-gold">
      <span class="material-symbols-outlined text-lg">search</span>
      <span class="text-[8px] uppercase font-bold tracking-widest mt-1">Explore</span>
    </router-link>
    <router-link :to="{ name: 'customer-dashboard' }" class="flex flex-col items-center text-charcoal/40" active-class="text-gold">
      <span class="material-symbols-outlined text-lg">favorite</span>
      <span class="text-[8px] uppercase font-bold tracking-widest mt-1">Collection</span>
    </router-link>
    <router-link :to="{ name: 'login' }" class="flex flex-col items-center text-charcoal/40" active-class="text-gold">
      <span class="material-symbols-outlined text-lg">person</span>
      <span class="text-[8px] uppercase font-bold tracking-widest mt-1">Profile</span>
    </router-link>
  </nav>
</template>
