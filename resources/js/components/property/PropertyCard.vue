<template>
  <div class="group cursor-pointer" :class="asymmetric ? 'mt-24' : ''">
    <div class="aspect-[4/5] overflow-hidden mb-6">
      <img :src="image" :alt="title" class="w-full h-full object-cover transition-transform duration-700 group-hover:scale-105">
    </div>
    <div class="flex justify-between items-start">
      <div>
        <h3 class="text-xl font-['Noto_Serif'] mb-1">{{ title }}</h3>
        <p class="text-sm text-charcoal/60">{{ location }}</p>
      </div>
      <div class="text-lg font-['Noto_Serif'] font-bold">${{ price.toLocaleString() }}</div>
    </div>
  </div>
</template>

<script setup>
defineProps({
  title: String,
  location: String,
  price: Number,
  image: String,
  asymmetric: Boolean
});
</script>
