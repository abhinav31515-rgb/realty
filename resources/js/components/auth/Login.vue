<template>
  <div class="min-h-screen flex flex-col md:flex-row bg-off-white">
    <!-- Left side: Image -->
    <div class="hidden md:block md:w-1/2 relative overflow-hidden">
      <img src="https://images.unsplash.com/photo-1600607687920-4e2a09cf159d" class="w-full h-full object-cover">
      <div class="absolute inset-0 bg-gold/10"></div>
    </div>

    <!-- Right side: Form -->
    <div class="w-full md:w-1/2 flex items-center justify-center p-12">
      <div class="max-w-md w-full">
        <router-link to="/" class="text-xs uppercase tracking-widest font-bold text-gold mb-12 block">← Back to Collections</router-link>
        <h1 class="text-5xl font-['Noto_Serif'] mb-12">Access the Collection</h1>
        
        <form @submit.prevent="handleLogin" class="space-y-8">
          <div>
            <label class="text-[10px] uppercase tracking-widest font-bold mb-2 block">Email Address</label>
            <input v-model="form.email" type="email" class="w-full bg-transparent border-b border-charcoal/20 py-3 text-sm focus:border-gold outline-none" required>
          </div>
          <div>
            <label class="text-[10px] uppercase tracking-widest font-bold mb-2 block">Password</label>
            <input v-model="form.password" type="password" class="w-full bg-transparent border-b border-charcoal/20 py-3 text-sm focus:border-gold outline-none" required>
          </div>
          
          <button type="submit" :disabled="loading" class="w-full bg-gold text-white py-4 text-xs uppercase tracking-widest font-bold hover:bg-primary transition-all disabled:opacity-50">
            {{ loading ? 'Authenticating...' : 'Sign In' }}
          </button>
        </form>

        <div class="mt-12 space-y-4">
           <a href="#" class="block text-center text-xs uppercase tracking-widest font-bold text-charcoal/40 hover:text-gold transition-colors">Forgot Password?</a>
           <a href="#" class="block text-center text-xs uppercase tracking-widest font-bold text-charcoal/40 hover:text-gold transition-colors underline underline-offset-4">Request Private Access</a>
        </div>
      </div>
    </div>
  </div>
</template>

<script setup>
import { reactive, ref } from 'vue';
import { inject } from 'vue';
import { useRouter } from 'vue-router';
import axios from 'axios';

const router = useRouter();
const notify = inject('notify');
const loading = ref(false);
const form = reactive({
  email: '',
  password: ''
});

const handleLogin = async () => {
  loading.value = true;
  try {
    const response = await axios.post('/api/login', form);
    localStorage.setItem('auth_token', response.data.token);
    notify('Welcome to the collection.', 'success', 'Identity');
    router.push({ name: 'home' });
  } catch (error) {
    notify('Authentication failed. Please check your credentials.', 'error', 'Security');
  } finally {
    loading.value = false;
  }
};
</script>
