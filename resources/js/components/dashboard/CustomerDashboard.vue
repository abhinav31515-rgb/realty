<template>
  <div class="min-h-screen bg-off-white">
    <Navbar />
    <main class="pt-40 px-12 pb-24">
      <header class="mb-16">
        <h1 class="text-5xl font-['Noto_Serif'] mb-2">Welcome Back</h1>
        <p class="text-xs uppercase tracking-widest font-bold text-charcoal/40">Your curated luxury collection</p>
      </header>

      <section class="mb-24">
        <h2 class="text-xs uppercase tracking-widest font-bold mb-8">Saved Properties</h2>
        <div v-if="favorites.length" class="grid grid-cols-1 md:grid-cols-3 gap-12">
          <PropertyCard 
            v-for="fav in favorites" 
            :key="fav.id"
            :id="fav.property.id"
            :title="fav.property.title"
            :location="fav.property.location"
            :price="parseFloat(fav.property.price)"
            :image="fav.property.images?.[0] || 'https://images.unsplash.com/photo-1600585154340-be6199f7d009'"
          />
        </div>
        <div v-else class="text-sm text-charcoal/40 italic">You haven't saved any masterpieces yet.</div>
      </section>

      <section class="grid grid-cols-1 md:grid-cols-2 gap-24">
        <div>
          <h2 class="text-xs uppercase tracking-widest font-bold mb-8">Upcoming Showings</h2>
          <div class="space-y-6">
            <div v-for="booking in bookings" :key="booking.id" class="bg-white p-8 border border-charcoal/5">
              <p class="text-lg font-['Noto_Serif'] mb-1">{{ booking.property?.title }}</p>
              <p class="text-sm text-charcoal/60 mb-6">{{ new Date(booking.scheduled_at).toLocaleString() }} &bull; Agent: Marcus Chen</p>
              <div class="flex justify-between items-center">
                 <span class="text-[10px] uppercase font-bold text-gold px-3 py-1 border border-gold/20">{{ booking.status }}</span>
                 <button @click="cancelBooking(booking.id)" class="text-[10px] uppercase tracking-widest font-bold text-charcoal/40">Cancel</button>
              </div>
            </div>
          </div>
        </div>
        <div>
          <h2 class="text-xs uppercase tracking-widest font-bold mb-8">Private Messages</h2>
          <div class="space-y-4">
            <div class="pb-4 border-b border-charcoal/5 flex justify-between items-center">
              <p class="text-sm">Your private tour for 'The Obsidian Sanctuary' is being processed.</p>
              <button class="text-gold material-symbols-outlined text-sm">reply</button>
            </div>
          </div>
        </div>
      </section>
    </main>
  </div>
</template>

<script setup>
import { ref, onMounted } from 'vue';
import api from '../../api';
import Navbar from '../layout/Navbar.vue';
import PropertyCard from '../property/PropertyCard.vue';

const favorites = ref([]);
const bookings = ref([]);

const fetchData = async () => {
  const token = localStorage.getItem('auth_token');
  try {
    const [fResp, bResp] = await Promise.all([
      api.get('/favorites', { headers: { Authorization: `Bearer ${token}` } }),
      api.get('/bookings', { headers: { Authorization: `Bearer ${token}` } })
    ]);
    favorites.value = fResp.data;
    bookings.value = bResp.data;
  } catch (error) {
    console.error(error);
  }
};

const cancelBooking = async (id) => {
  const token = localStorage.getItem('auth_token');
  try {
    await api.patch(`/bookings/${id}`, { status: 'cancelled' }, { headers: { Authorization: `Bearer ${token}` } });
    fetchData();
  } catch (error) {
    alert('Could not cancel booking');
  }
};

onMounted(fetchData);
</script>
