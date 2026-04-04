<template>
  <div class="min-h-screen bg-off-white">
    <Navbar />
    <main class="pt-40 px-12 pb-24">
      <header class="mb-16">
        <h1 class="text-5xl font-['Noto_Serif'] mb-2">Welcome, Julian</h1>
        <p class="text-xs uppercase tracking-widest font-bold text-charcoal/40">Your curated luxury collection</p>
      </header>

      <section class="mb-24">
        <h2 class="text-xs uppercase tracking-widest font-bold mb-8">Saved Properties</h2>
        <div class="grid grid-cols-1 md:grid-cols-3 gap-12">
          <div v-for="i in 2" :key="i" class="group">
             <div class="aspect-video bg-charcoal/5 mb-4"></div>
             <p class="font-['Noto_Serif']">Sanctuary {{ i }}</p>
             <p class="text-sm text-gold font-bold mt-1">$12,000,000</p>
          </div>
        </div>
      </section>

      <section class="grid grid-cols-1 md:grid-cols-2 gap-24">
        <div>
          <h2 class="text-xs uppercase tracking-widest font-bold mb-8">Upcoming Showings</h2>
          <div class="space-y-6">
            <div class="bg-white p-8 border border-charcoal/5">
              <p class="text-lg font-['Noto_Serif'] mb-1">The Obsidian Sanctuary</p>
              <p class="text-sm text-charcoal/60 mb-6">Oct 24, 10:00 AM &bull; Agent: Marcus Chen</p>
              <button class="text-[10px] uppercase tracking-widest font-bold text-gold">Reschedule</button>
            </div>
          </div>
        </div>
        <div>
          <h2 class="text-xs uppercase tracking-widest font-bold mb-8">Messages</h2>
          <div class="space-y-4">
            <div v-for="i in 2" :key="i" class="pb-4 border-b border-charcoal/5 flex justify-between items-center">
              <p class="text-sm">Your inquiry for Estate {{ i }} has been received.</p>
              <button class="text-gold material-symbols-outlined text-sm">reply</button>
            </div>
          </div>
        </div>
      </section>
    </main>
  </div>
</template>

<script setup>
import Navbar from '../layout/Navbar.vue';
</script>
