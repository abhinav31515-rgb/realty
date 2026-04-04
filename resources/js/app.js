import './bootstrap';
import { createApp } from 'vue';

const app = createApp({});

// Auto-register components if needed
// Object.entries(import.meta.glob('./**/*.vue', { eager: true })).forEach(([path, definition]) => {
//     app.component(path.split('/').pop().replace(/\.\w+$/, ''), definition.default);
// });

app.mount('#app');
