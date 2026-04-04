<template>
  <div class="min-h-screen bg-off-white flex">
    <!-- Sidebar -->
    <aside class="w-64 bg-charcoal text-white p-8 hidden md:block">
      <div class="text-xl font-bold mb-12">LUXEESTATE</div>
      <nav class="space-y-6 text-xs uppercase tracking-widest font-bold">
        <a href="#" class="block text-gold">Overview</a>
        <a href="#" class="block hover:text-gold transition-colors text-white/60">Properties</a>
        <a href="#" class="block hover:text-gold transition-colors text-white/60">Bookings</a>
        <a href="#" class="block hover:text-gold transition-colors text-white/60">Users</a>
      </nav>
    </aside>

    <!-- Main Content -->
    <main class="flex-1 p-12">
      <header class="flex justify-between items-center mb-12">
        <h1 class="text-4xl font-['Noto_Serif']">Dashboard Overview</h1>
        <div class="flex items-center space-x-6">
           <span class="material-symbols-outlined text-charcoal/40">notifications</span>
           <div class="w-8 h-8 bg-gold/20 flex items-center justify-center font-bold text-[10px]">AD</div>
        </div>
      </header>

      <!-- KPI Cards -->
      <div class="grid grid-cols-1 md:grid-cols-4 gap-8 mb-12">
        <div v-for="kpi in stats" :key="kpi.label" class="bg-white p-8 border border-charcoal/5">
          <p class="text-[10px] uppercase tracking-widest text-charcoal/40 mb-2 font-bold">{{ kpi.label }}</p>
          <p class="text-3xl font-['Noto_Serif']">{{ kpi.value }}</p>
          <p class="text-[10px] text-gold mt-2 font-bold">{{ kpi.trend }}</p>
        </div>
      </div>

      <!-- Table -->
      <div class="bg-white p-12 border border-charcoal/5">
        <h2 class="text-xl font-['Noto_Serif'] mb-8">Recent Bookings</h2>
        <table class="w-full text-left">
          <thead>
            <tr class="text-[10px] uppercase tracking-widest font-bold text-charcoal/40 border-b border-charcoal/5">
              <th class="pb-4">Property</th>
              <th class="pb-4">Customer</th>
              <th class="pb-4">Date</th>
              <th class="pb-4">Status</th>
            </tr>
          </thead>
          <tbody class="text-sm">
            <tr v-for="booking in bookings" :key="booking.id" class="border-b border-charcoal/5 last:border-0">
              <td class="py-6 font-medium">{{ booking.property }}</td>
              <td class="py-6">{{ booking.customer }}</td>
              <td class="py-6">{{ booking.date }}</td>
              <td class="py-6"><span class="text-gold font-bold uppercase text-[10px]">{{ booking.status }}</span></td>
            </tr>
          </tbody>
        </table>
      </div>
    </main>
  </div>
</template>

<script setup>
const stats = [
  { label: 'Total Revenue', value: '$42.5M', trend: '+12% GROWTH' },
  { label: 'Active Listings', value: '148', trend: 'STABLE' },
  { label: 'Total Bookings', value: '892', trend: '+5% THIS MONTH' },
  { label: 'Pending Approvals', value: '14', trend: 'ACTION REQ' }
];

const bookings = [
  { id: 1, property: 'The Obsidian Sanctuary', customer: 'Julian V.', date: 'Oct 24, 10:00 AM', status: 'Confirmed' },
  { id: 2, property: 'The Zenith Penthouse', customer: 'Sophia L.', date: 'Oct 25, 02:30 PM', status: 'Pending' }
];
</script>
