<template>
  <div v-if="property" class="min-h-screen bg-off-white">
    <Navbar />
    
    <!-- Gallery -->
    <section class="pt-32 px-12">
      <div class="grid grid-cols-4 grid-rows-2 gap-4 h-[70vh]">
        <div class="col-span-3 row-span-2 overflow-hidden">
           <img :src="property.images?.[0] || 'https://images.unsplash.com/photo-1600585154340-be6199f7d009'" class="w-full h-full object-cover">
        </div>
        <div class="overflow-hidden">
           <img :src="property.images?.[1] || 'https://images.unsplash.com/photo-1600607687920-4e2a09cf159d'" class="w-full h-full object-cover">
        </div>
        <div class="overflow-hidden">
           <img :src="property.images?.[2] || 'https://images.unsplash.com/photo-1613490493576-7fde63acd811'" class="w-full h-full object-cover">
        </div>
      </div>
    </section>

    <!-- Content -->
    <section class="py-24 px-12 grid grid-cols-1 md:grid-cols-3 gap-24">
      <div class="md:col-span-2">
        <h1 class="text-6xl font-['Noto_Serif'] mb-4">{{ property.title }}</h1>
        <p class="text-xl text-gold mb-12 font-['Noto_Serif']">${{ parseFloat(property.price).toLocaleString() }} &bull; {{ property.location }}</p>
        
        <div class="prose prose-lg text-charcoal/80 mb-24">
          {{ property.description }}
        </div>

        <h3 class="text-xs uppercase tracking-widest font-bold mb-8">Amenities</h3>
        <div class="grid grid-cols-2 md:grid-cols-4 gap-8">
          <div v-for="amenity in (property.metadata?.amenities || ['Pool', 'Gym', 'Cinema'])" :key="amenity" class="flex flex-col items-center p-8 border border-charcoal/5">
             <span class="material-symbols-outlined text-gold mb-4">diamond</span>
             <span class="text-sm font-medium">{{ amenity }}</span>
          </div>
        </div>
      </div>

      <!-- Action Sidebar -->
      <aside>
        <div class="sticky top-40 bg-white p-12 border border-charcoal/5">
          <div v-if="bookingSuccess" class="text-center py-12">
             <span class="material-symbols-outlined text-gold text-5xl mb-4">verified</span>
             <p class="font-['Noto_Serif'] text-xl mb-2">Request Received</p>
             <p class="text-sm text-charcoal/40">Marcus Chen will contact you shortly to confirm your showing.</p>
          </div>
          <template v-else>
            <h4 class="text-xl font-['Noto_Serif'] mb-8">Inquire Privately</h4>
            <form @submit.prevent="handleBooking" class="space-y-6">
              <input v-model="bookingForm.name" type="text" placeholder="Full Name" class="w-full border-b border-charcoal/10 py-3 text-sm focus:border-gold outline-none" required>
              <input v-model="bookingForm.date" type="datetime-local" class="w-full border-b border-charcoal/10 py-3 text-sm focus:border-gold outline-none" required>
              <button type="submit" :disabled="bookingLoading" class="w-full bg-gold text-white py-4 text-xs uppercase tracking-widest font-bold hover:bg-primary transition-colors disabled:opacity-50">
                {{ bookingLoading ? 'Sending...' : 'Request a Showing' }}
              </button>
            </form>
            <div class="mt-8 pt-8 border-t border-charcoal/5 text-center">
              <p class="text-[10px] uppercase tracking-widest text-charcoal/40 mb-4">Assigned Agent</p>
              <p class="font-['Noto_Serif']">Marcus Chen</p>
            </div>
          </template>
        </div>
      </aside>
    </section>
  </div>
</template>

<script setup>
import { ref, onMounted, reactive } from 'vue';
import { useRoute, useRouter } from 'vue-router';
import axios from 'axios';
import Navbar from '../layout/Navbar.vue';

const route = useRoute();
const router = useRouter();
const property = ref(null);
const bookingLoading = ref(false);
const bookingSuccess = ref(false);

const bookingForm = reactive({
  name: '',
  date: ''
});

const handleBooking = async () => {
  const token = localStorage.getItem('auth_token');
  if (!token) {
    router.push({ name: 'login' });
    return;
  }

  bookingLoading.value = true;
  try {
    await axios.post('/api/bookings', {
      property_id: property.value.id,
      scheduled_at: bookingForm.date
    }, {
      headers: { Authorization: `Bearer ${token}` }
    });
    bookingSuccess.value = true;
  } catch (error) {
    alert('Failed to request showing. Please try again.');
  } finally {
    bookingLoading.value = false;
  }
};

onMounted(async () => {
  try {
    const response = await axios.get(`/api/properties/${route.params.id}`);
    property.value = response.data;
  } catch (error) {
    console.error('Error fetching property:', error);
  }
});
</script>
