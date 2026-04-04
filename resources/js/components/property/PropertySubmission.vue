<template>
  <div class="min-h-screen bg-off-white pt-32 px-12 pb-24">
    <div class="max-w-4xl mx-auto">
      <header class="mb-16">
        <h1 class="text-6xl font-['Noto_Serif'] mb-4">Curate a New Masterpiece</h1>
        <p class="text-sm text-charcoal/40 uppercase tracking-widest font-bold">Share the architectural integrity of your property</p>
      </header>

      <!-- Progress Line -->
      <div class="w-full h-px bg-charcoal/5 mb-16 relative">
        <div class="h-px bg-gold transition-all duration-500" :style="{ width: (step / 3) * 100 + '%' }"></div>
      </div>

      <form @submit.prevent="submitListing" class="space-y-16">
        <!-- Step 1: Basic Info -->
        <div v-if="step === 1" class="space-y-12">
          <div class="grid grid-cols-1 md:grid-cols-2 gap-12">
            <div>
              <label class="text-[10px] uppercase tracking-widest font-bold mb-2 block">Listing Type</label>
              <select v-model="form.listing_category" class="w-full bg-transparent border-b border-charcoal/20 py-3 outline-none focus:border-gold">
                <option value="buy">For Sale</option>
                <option value="rent">For Rent</option>
                <option value="commercial">Commercial</option>
              </select>
            </div>
            <div>
              <label class="text-[10px] uppercase tracking-widest font-bold mb-2 block">Property Type</label>
              <select v-model="form.type" class="w-full bg-transparent border-b border-charcoal/20 py-3 outline-none focus:border-gold">
                <option v-for="t in ['Villa', 'Penthouse', 'Mansion', 'Estate']" :key="t" :value="t">{{ t }}</option>
              </select>
            </div>
          </div>
          <input v-model="form.title" type="text" placeholder="Property Title (Serif Style)" class="w-full text-3xl font-['Noto_Serif'] bg-transparent border-b border-charcoal/20 py-4 outline-none focus:border-gold">
          <textarea v-model="form.description" placeholder="Architectural Description..." rows="6" class="w-full bg-transparent border border-charcoal/10 p-6 outline-none focus:border-gold text-sm leading-relaxed"></textarea>
        </div>

        <!-- Step 2: Details & Luxury Specs -->
        <div v-if="step === 2" class="space-y-12">
          <div class="grid grid-cols-1 md:grid-cols-3 gap-12">
            <div>
              <label class="text-[10px] uppercase tracking-widest font-bold mb-2 block">Price (USD)</label>
              <input v-model="form.price" type="number" class="w-full bg-transparent border-b border-charcoal/20 py-3 outline-none focus:border-gold">
            </div>
            <div>
              <label class="text-[10px] uppercase tracking-widest font-bold mb-2 block">Total Area (SQ FT)</label>
              <input v-model="form.total_area" type="number" class="w-full bg-transparent border-b border-charcoal/20 py-3 outline-none focus:border-gold">
            </div>
             <div>
              <label class="text-[10px] uppercase tracking-widest font-bold mb-2 block">BHK Count</label>
              <input v-model="form.bhk_count" type="number" class="w-full bg-transparent border-b border-charcoal/20 py-3 outline-none focus:border-gold">
            </div>
          </div>
          <div class="grid grid-cols-1 md:grid-cols-2 gap-12">
            <div>
              <label class="text-[10px] uppercase tracking-widest font-bold mb-2 block">Furnishing</label>
              <select v-model="form.furnishing_status" class="w-full bg-transparent border-b border-charcoal/20 py-3 outline-none focus:border-gold">
                <option value="furnished">Fully Furnished</option>
                <option value="semi-furnished">Semi-Furnished</option>
                <option value="unfurnished">Unfurnished</option>
              </select>
            </div>
            <div>
              <label class="text-[10px] uppercase tracking-widest font-bold mb-2 block">Location</label>
              <input v-model="form.location" type="text" placeholder="e.g. Malibu, CA" class="w-full bg-transparent border-b border-charcoal/20 py-3 outline-none focus:border-gold">
            </div>
          </div>
        </div>

        <!-- Step 3: Media -->
        <div v-if="step === 3" class="space-y-12">
           <div class="border-2 border-dashed border-charcoal/10 p-24 text-center cursor-pointer hover:border-gold transition-colors">
              <span class="material-symbols-outlined text-gold text-5xl mb-4">cloud_upload</span>
              <p class="text-sm font-bold uppercase tracking-widest">Upload High-Resolution Imagery</p>
              <p class="text-[10px] text-charcoal/40 mt-2">Drag and drop or click to browse architectural photos</p>
           </div>
        </div>

        <div class="flex justify-between pt-12 border-t border-charcoal/5">
          <button v-if="step > 1" @click="step--" type="button" class="text-xs uppercase tracking-widest font-bold text-charcoal/40 hover:text-charcoal">Previous</button>
          <div v-else></div>
          <button v-if="step < 3" @click="step++" type="button" class="bg-charcoal text-white px-12 py-4 text-xs uppercase tracking-widest font-bold hover:bg-gold transition-all">Next Step</button>
          <button v-else type="submit" class="bg-gold text-white px-12 py-4 text-xs uppercase tracking-widest font-bold hover:bg-primary transition-all">Submit Listing</button>
        </div>
      </form>
    </div>
  </div>
</template>

<script setup>
import { ref, reactive } from 'vue';
import { useRouter } from 'vue-router';
import axios from 'axios';

const step = ref(1);
const router = useRouter();
const form = reactive({
  listing_category: 'buy',
  type: 'Villa',
  title: '',
  description: '',
  price: '',
  total_area: '',
  bhk_count: '',
  furnishing_status: 'furnished',
  location: ''
});

const submitListing = async () => {
  const token = localStorage.getItem('auth_token');
  try {
    await axios.post('/api/properties', { ...form, status: 'pending' }, {
      headers: { Authorization: `Bearer ${token}` }
    });
    alert('Property submitted for architectural review.');
    router.push('/dashboard');
  } catch (error) {
    alert('Submission failed. Please check your data.');
  }
};
</script>
