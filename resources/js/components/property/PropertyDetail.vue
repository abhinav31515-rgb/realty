<template>
  <div v-if="property" class="min-h-screen bg-off-white">
    <Navbar />
    
    <!-- Immersive Fullscreen Gallery -->
    <section class="relative h-[90vh] bg-charcoal overflow-hidden group">
      <img :src="property.images?.[activeImage] || 'https://images.unsplash.com/photo-1600585154340-be6199f7d009'" class="w-full h-full object-cover opacity-80 transition-all duration-1000 transform scale-105 group-hover:scale-100">
      <div class="absolute inset-0 bg-gradient-to-t from-charcoal via-transparent to-transparent"></div>
      
      <div class="absolute bottom-24 left-12">
        <h1 class="text-7xl font-['Noto_Serif'] text-white mb-4">{{ property.title }}</h1>
        <p class="text-xl text-gold font-['Noto_Serif'] tracking-widest uppercase">{{ property.location }}</p>
      </div>

      <!-- Gallery Controls -->
      <div class="absolute bottom-12 right-12 flex space-x-4">
         <button v-for="(img, idx) in (property.images || [1,2,3])" :key="idx" @click="activeImage = idx" :class="['w-16 h-1 bg-white/20 transition-all', activeImage === idx ? 'bg-gold w-24' : '']"></button>
      </div>
    </section>

    <!-- Content Matrix -->
    <section class="py-32 px-12 grid grid-cols-1 md:grid-cols-12 gap-24">
      <div class="md:col-span-8">
        <div class="flex space-x-12 mb-16 pb-8 border-b border-charcoal/5 text-[10px] uppercase tracking-widest font-bold">
           <div><span class="text-charcoal/40 block mb-1">Price</span><span class="text-lg font-['Noto_Serif']">${{ parseFloat(property.price).toLocaleString() }}</span></div>
           <div class="w-px h-8 bg-charcoal/10"></div>
           <div><span class="text-charcoal/40 block mb-1">Total Area</span><span class="text-lg font-['Noto_Serif']">{{ property.total_area || 4500 }} SQ FT</span></div>
           <div class="w-px h-8 bg-charcoal/10"></div>
           <div><span class="text-charcoal/40 block mb-1">Configuration</span><span class="text-lg font-['Noto_Serif']">{{ property.bhk_count || 5 }} BHK</span></div>
        </div>

        <div class="prose prose-2xl text-charcoal/80 mb-24 font-light leading-relaxed">
          {{ property.description }}
        </div>

        <!-- Architectural Blueprint Section -->
        <h3 class="text-xs uppercase tracking-widest font-bold mb-12">Architectural Blueprint</h3>
        <div class="aspect-video bg-charcoal/5 border border-charcoal/10 flex items-center justify-center mb-24 group cursor-zoom-in">
           <span class="material-symbols-outlined text-charcoal/20 text-6xl transition-transform group-hover:scale-110">architecture</span>
           <p class="absolute text-[10px] uppercase tracking-widest font-bold text-charcoal/40 mt-32">View Full Schematic</p>
        </div>

        <!-- Locality Insights (Mapbox) -->
        <h3 class="text-xs uppercase tracking-widest font-bold mb-12">Locality Insights</h3>
        <div class="grid grid-cols-1 md:grid-cols-2 gap-12 mb-12">
           <div v-for="poi in localityItems" :key="poi.name" class="flex items-start space-x-6 p-8 border border-charcoal/5">
              <span class="material-symbols-outlined text-gold">{{ poi.icon }}</span>
              <div>
                 <p class="font-bold text-sm uppercase tracking-wider">{{ poi.name }}</p>
                 <p class="text-xs text-charcoal/60 mt-1">{{ poi.distance }} &bull; {{ poi.type }}</p>
              </div>
           </div>
        </div>
        <div id="locality-map" class="h-96 w-full bg-charcoal/5 grayscale"></div>
      </div>

      <!-- Action Sidebar -->
      <div class="md:col-span-4">
        <div class="sticky top-40 bg-white p-12 shadow-sm border border-charcoal/5">
          <div v-if="bookingSuccess" class="text-center py-12">
             <span class="material-symbols-outlined text-gold text-5xl mb-4">verified</span>
             <p class="font-['Noto_Serif'] text-xl mb-2">Request Received</p>
             <p class="text-sm text-charcoal/40">Our concierge will contact you to arrange a private viewing.</p>
          </div>
          <template v-else>
            <h4 class="text-xl font-['Noto_Serif'] mb-8">Schedule an Experience</h4>
            <form @submit.prevent="handleBooking" class="space-y-6">
              <input v-model="bookingForm.name" type="text" placeholder="Full Name" class="w-full border-b border-charcoal/10 py-4 text-sm focus:border-gold outline-none bg-transparent" required>
              <input v-model="bookingForm.date" type="datetime-local" class="w-full border-b border-charcoal/10 py-4 text-sm focus:border-gold outline-none bg-transparent" required>
              <button type="submit" :disabled="bookingLoading" class="w-full bg-charcoal text-white py-5 text-xs uppercase tracking-widest font-bold hover:bg-gold transition-all disabled:opacity-50">
                {{ bookingLoading ? 'Sending...' : 'Request Private Showing' }}
              </button>
            </form>
          </template>
        </div>
      </div>
    </section>
  </div>
</template>

<script setup>
import { ref, onMounted, reactive } from 'vue';
import { useRoute, useRouter } from 'vue-router';
import api from '../../../api';
import Navbar from '../layout/Navbar.vue';

const route = useRoute();
const router = useRouter();
const property = ref(null);
const activeImage = ref(0);
const bookingLoading = ref(false);
const bookingSuccess = ref(false);

const localityItems = [
  { name: 'Bel Air Country Club', distance: '1.2 miles', type: 'Private Club', icon: 'golf_course' },
  { name: 'The Harvard-Westlake School', distance: '3.4 miles', type: 'Education', icon: 'school' },
  { name: 'Cedars-Sinai Medical Center', distance: '5.8 miles', type: 'Health', icon: 'medical_services' },
  { name: 'Santa Monica Heliport', distance: '8.2 miles', type: 'Transport', icon: 'helicopter' }
];

const bookingForm = reactive({ name: '', date: '' });

const handleBooking = async () => {
  const token = localStorage.getItem('auth_token');
  if (!token) { router.push({ name: 'login' }); return; }
  bookingLoading.value = true;
  try {
    await api.post('/bookings', { property_id: property.value.id, scheduled_at: bookingForm.date }, { headers: { Authorization: `Bearer ${token}` } });
    bookingSuccess.value = true;
  } catch (error) { alert('Failed to request showing.'); } finally { bookingLoading.value = false; }
};

onMounted(async () => {
  try {
    const response = await api.get(`/properties/${route.params.id}`);
    property.value = response.data;
  } catch (error) { console.error(error); }
});
</script>
