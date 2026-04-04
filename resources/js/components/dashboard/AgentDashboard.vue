<template>
  <div class="min-h-screen bg-off-white flex">
    <aside class="w-64 bg-charcoal text-white p-8 hidden md:block">
      <div class="text-xl font-bold mb-12">LUXEESTATE</div>
      <nav class="space-y-6 text-xs uppercase tracking-widest font-bold">
        <router-link to="/" class="block text-white/40 hover:text-gold transition-colors">Client Site</router-link>
        <a href="#" class="block text-gold">Agent Hub</a>
        <router-link to="/list-property" class="block hover:text-gold transition-colors text-white/60">Post Property</router-link>
        <a href="#" class="block hover:text-gold transition-colors text-white/60">My Leads</a>
      </nav>
    </aside>

    <main class="flex-1 p-12 pb-32">
      <header class="mb-12 flex justify-between items-start">
        <div>
           <h1 class="text-4xl font-['Noto_Serif'] mb-2">Agent Performance</h1>
           <p class="text-[10px] text-charcoal/40 uppercase tracking-widest font-bold">Verified Portfolio: Alexander</p>
        </div>
        <div class="bg-gold text-white px-6 py-3 text-[10px] font-bold uppercase tracking-widest">Live: 12 Masterpieces</div>
      </header>

      <div class="grid grid-cols-1 md:grid-cols-3 gap-8 mb-12">
        <div class="bg-white p-8 border border-charcoal/5">
          <p class="text-[10px] uppercase tracking-widest text-charcoal/40 mb-2 font-bold">Commissions (YTD)</p>
          <p class="text-4xl font-['Noto_Serif'] text-gold">$1.24M</p>
          <div class="h-1 bg-charcoal/5 mt-4"><div class="h-1 bg-gold w-3/4"></div></div>
        </div>
        <div class="bg-white p-8 border border-charcoal/5">
          <p class="text-[10px] uppercase tracking-widest text-charcoal/40 mb-2 font-bold">Client Inquiries</p>
          <p class="text-4xl font-['Noto_Serif']">45</p>
          <p class="text-[10px] text-gold mt-2 font-bold">+8 THIS WEEK</p>
        </div>
        <div class="bg-white p-8 border border-charcoal/5">
          <p class="text-[10px] uppercase tracking-widest text-charcoal/40 mb-2 font-bold">Virtual Tours Held</p>
          <p class="text-4xl font-['Noto_Serif']">128</p>
          <p class="text-[10px] text-charcoal/40 mt-2 font-bold">89% COMPLETION</p>
        </div>
      </div>

      <!-- Lead Status Tracking -->
      <div class="bg-white p-12 border border-charcoal/5 mb-12">
        <h2 class="text-xl font-['Noto_Serif'] mb-8">Active Leads</h2>
        <div class="space-y-4">
           <div v-for="lead in leads" :key="lead.id" class="p-6 border border-charcoal/5 flex justify-between items-center group hover:border-gold transition-colors">
              <div class="flex items-center space-x-6">
                 <div class="w-10 h-10 bg-gold/10 flex items-center justify-center font-bold text-[10px]">{{ lead.customer.name.substring(0,2).toUpperCase() }}</div>
                 <div>
                    <p class="text-sm font-bold uppercase tracking-widest">{{ lead.customer.name }}</p>
                    <p class="text-xs text-charcoal/40">Inquired about: {{ lead.property.title }}</p>
                 </div>
              </div>
              <div class="flex items-center space-x-8">
                 <select class="bg-transparent border-none text-[10px] font-bold uppercase text-gold outline-none">
                    <option :value="lead.status">{{ lead.status }}</option>
                    <option value="contacted">Contacted</option>
                    <option value="qualified">Qualified</option>
                 </select>
                 <button class="material-symbols-outlined text-charcoal/20 group-hover:text-gold">chat_bubble</button>
              </div>
           </div>
        </div>
      </div>
    </main>
  </div>
</template>

<script setup>
const leads = [
  { id: 1, customer: { name: 'Julian V.' }, property: { title: 'The Obsidian Sanctuary' }, status: 'new' },
  { id: 2, customer: { name: 'Sophia L.' }, property: { title: 'Marquina Villa' }, status: 'contacted' }
];
</script>
