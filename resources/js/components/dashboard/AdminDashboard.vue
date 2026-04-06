<template>
  <div class="min-h-screen bg-off-white flex">
    <aside class="w-64 bg-charcoal text-white p-8 hidden md:block">
      <div class="text-xl font-bold mb-12">LUXEESTATE</div>
      <nav class="space-y-6 text-xs uppercase tracking-widest font-bold">
        <router-link to="/admin" class="block text-gold">Overview</router-link>
        <router-link to="/admin/content" class="block hover:text-gold transition-colors text-white/60">CMS Manager</router-link>
        <a href="#" class="block hover:text-gold transition-colors text-white/60">Properties</a>
        <a href="#" class="block hover:text-gold transition-colors text-white/60">Bookings</a>
      </nav>
    </aside>

    <main class="flex-1 p-12">
      <header class="flex justify-between items-center mb-12">
        <h1 class="text-4xl font-['Noto_Serif']">Dashboard Overview</h1>
        <div class="flex items-center space-x-6">
           <span class="material-symbols-outlined text-charcoal/40">notifications</span>
           <div class="w-8 h-8 bg-gold/20 flex items-center justify-center font-bold text-[10px]">AD</div>
        </div>
      </header>

      <div class="grid grid-cols-1 md:grid-cols-4 gap-8 mb-12">
        <div v-for="(val, key) in stats" :key="key" class="bg-white p-8 border border-charcoal/5">
          <p class="text-[10px] uppercase tracking-widest text-charcoal/40 mb-2 font-bold">{{ key.replace('_', ' ') }}</p>
          <p class="text-3xl font-['Noto_Serif']">{{ formatStat(key, val) }}</p>
        </div>
      </div>

      <div class="bg-white p-12 border border-charcoal/5">
        <h2 class="text-xl font-['Noto_Serif'] mb-8">Recent Booking Requests</h2>
        <table class="w-full text-left">
          <thead>
            <tr class="text-[10px] uppercase tracking-widest font-bold text-charcoal/40 border-b border-charcoal/5">
              <th class="pb-4">Property</th>
              <th class="pb-4">Customer</th>
              <th class="pb-4">Scheduled At</th>
              <th class="pb-4 text-right">Action</th>
            </tr>
          </thead>
          <tbody class="text-sm">
            <tr v-for="booking in bookings" :key="booking.id" class="border-b border-charcoal/5 last:border-0">
              <td class="py-6 font-medium">{{ booking.property?.title }}</td>
              <td class="py-6">{{ booking.customer?.name }}</td>
              <td class="py-6">{{ new Date(booking.scheduled_at).toLocaleString() }}</td>
              <td class="py-6 text-right">
                <select @change="updateStatus(booking.id, $event.target.value)" :value="booking.status" class="bg-transparent border-none text-[10px] font-bold uppercase text-gold outline-none cursor-pointer">
                   <option value="pending">Pending</option>
                   <option value="confirmed">Confirm</option>
                   <option value="cancelled">Cancel</option>
                </select>
              </td>
            </tr>
          </tbody>
        </table>
      </div>
    </main>
  </div>
</template>

<script setup>
import { ref, onMounted } from 'vue';
import api from '../../api';

const stats = ref({});
const bookings = ref([]);

const fetchData = async () => {
  const token = localStorage.getItem('auth_token');
  try {
    const [sResp, bResp] = await Promise.all([
      api.get('/dashboard/stats', { headers: { Authorization: `Bearer ${token}` } }),
      api.get('/bookings', { headers: { Authorization: `Bearer ${token}` } })
    ]);
    stats.value = sResp.data;
    bookings.value = bResp.data;
  } catch (error) {
    console.error(error);
  }
};

const updateStatus = async (id, status) => {
  const token = localStorage.getItem('auth_token');
  try {
    await api.patch(`/bookings/${id}`, { status }, { headers: { Authorization: `Bearer ${token}` } });
    fetchData();
  } catch (error) {
    alert('Failed to update status');
  }
};

const formatStat = (key, val) => {
  if (key.includes('revenue')) return '$' + (val / 1000000).toFixed(1) + 'M';
  return val;
};

onMounted(fetchData);
</script>
