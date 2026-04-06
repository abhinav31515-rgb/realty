<template>
  <TransitionGroup name="toast" tag="div" class="fixed top-12 right-12 z-[300] space-y-4">
    <div v-for="toast in toasts" :key="toast.id" :class="['bg-charcoal text-white p-6 shadow-2xl border-l-4 min-w-[300px]', toast.type === 'error' ? 'border-red-500' : 'border-gold']">
       <div class="flex justify-between items-start">
          <p class="text-[10px] uppercase tracking-widest font-bold">{{ toast.title || 'Notification' }}</p>
          <button @click="remove(toast.id)" class="material-symbols-outlined text-sm opacity-40">close</button>
       </div>
       <p class="text-sm mt-2 leading-relaxed">{{ toast.message }}</p>
    </div>
  </TransitionGroup>
</template>

<script setup>
import { ref } from 'vue';

const toasts = ref([]);
let id = 0;

const add = (message, type = 'success', title = null) => {
  const currentId = id++;
  toasts.value.push({ id: currentId, message, type, title });
  setTimeout(() => remove(currentId), 5000);
};

const remove = (id) => {
  toasts.value = toasts.value.filter(t => t.id !== id);
};

defineExpose({ add });
</script>

<style scoped>
.toast-enter-active, .toast-leave-active { transition: all 0.5s ease; }
.toast-enter-from { opacity: 0; transform: translateX(100%); }
.toast-leave-to { opacity: 0; transform: scale(0.9); }
</style>
