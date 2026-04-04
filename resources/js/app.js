import './bootstrap';
import { createApp } from 'vue';
import LandingPage from './components/LandingPage.vue';

const app = createApp({});
app.component('landing-page', LandingPage);
app.mount('#app');
