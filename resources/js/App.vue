<template>
    <router-view></router-view>
    <CompareDrawer />
    <BottomNav />
    <Toast ref="toastRef" />
</template>

<script setup>
import { ref, onMounted, provide } from 'vue';
import CompareDrawer from './components/property/CompareDrawer.vue';
import BottomNav from './components/layout/BottomNav.vue';
import Toast from './components/ui/Toast.vue';

const toastRef = ref(null);

provide('notify', (msg, type, title) => {
    if (toastRef.value) toastRef.value.add(msg, type, title);
});
</script>
