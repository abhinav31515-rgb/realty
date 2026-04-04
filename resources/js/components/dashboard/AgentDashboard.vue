<template>
  <div class="min-h-screen bg-off-white flex">
    <aside class="w-64 bg-charcoal text-white p-8 hidden md:block">
      <div class="text-xl font-bold mb-12">LUXEESTATE</div>
      <nav class="space-y-6 text-xs uppercase tracking-widest font-bold">
        <a href="#" class="block text-gold">Overview</a>
        <a href="#" class="block hover:text-gold transition-colors text-white/60">My Listings</a>
        <a href="#" class="block hover:text-gold transition-colors text-white/60">Leads</a>
      </nav>
    </aside>

    <main class="flex-1 p-12">
      <header class="mb-12">
        <h1 class="text-4xl font-['Noto_Serif'] mb-2">Agent Performance</h1>
        <p class="text-sm text-charcoal/40 uppercase tracking-widest font-bold">Welcome back, Marcus Chen</p>
      </header>

      <div class="grid grid-cols-1 md:grid-cols-3 gap-8 mb-12">
        <div class="bg-white p-8 border border-charcoal/5">
          <p class="text-[10px] uppercase tracking-widest text-charcoal/40 mb-2 font-bold">Commissions</p>
          <p class="text-4xl font-['Noto_Serif'] text-gold">$1.2M</p>
        </div>
        <div class="bg-white p-8 border border-charcoal/5">
          <p class="text-[10px] uppercase tracking-widest text-charcoal/40 mb-2 font-bold">Properties Sold</p>
          <p class="text-4xl font-['Noto_Serif']">12</p>
        </div>
        <div class="bg-white p-8 border border-charcoal/5">
          <p class="text-[10px] uppercase tracking-widest text-charcoal/40 mb-2 font-bold">New Leads</p>
          <p class="text-4xl font-['Noto_Serif']">45</p>
        </div>
      </div>

      <div class="bg-white p-12 border border-charcoal/5">
        <h2 class="text-xl font-['Noto_Serif'] mb-8">Current Listings</h2>
        <div class="space-y-6">
          <div v-for="i in 3" :key="i" class="flex items-center justify-between pb-6 border-b border-charcoal/5 last:border-0">
             <div class="flex items-center space-x-6">
                <div class="w-16 h-16 bg-charcoal/5"></div>
                <div>
                   <p class="font-['Noto_Serif']">Estate {{ i }}</p>
                   <p class="text-[10px] text-charcoal/40 uppercase tracking-widest">Active</p>
                </div>
             </div>
             <div class="text-right">
                <p class="text-sm font-bold">24 Inquiries</p>
                <button class="text-[10px] text-gold uppercase tracking-widest font-bold">View Analytics</button>
             </div>
          </div>
        </div>
      </div>
    </main>
  </div>
</template>

<script setup>
</script>
