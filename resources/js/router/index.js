import { createRouter, createWebHistory } from 'vue-router';
import LandingPage from '../components/LandingPage.vue';
import PropertyList from '../components/property/PropertyList.vue';
import PropertyDetail from '../components/property/PropertyDetail.vue';
import Login from '../components/auth/Login.vue';
import AdminDashboard from '../components/dashboard/AdminDashboard.vue';
import AgentDashboard from '../components/dashboard/AgentDashboard.vue';
import CustomerDashboard from '../components/dashboard/CustomerDashboard.vue';
import AdminContentManager from '../components/cms/AdminContentManager.vue';
import PropertySubmission from '../components/property/PropertySubmission.vue';
import AdminModeration from '../components/dashboard/AdminModeration.vue';

const routes = [
    { path: '/', name: 'home', component: LandingPage },
    { path: '/properties', name: 'properties', component: PropertyList },
    { path: '/properties/:id', name: 'property-detail', component: PropertyDetail },
    { path: '/login', name: 'login', component: Login },
    { path: '/admin', name: 'admin-dashboard', component: AdminDashboard },
    { path: '/agent', name: 'agent-dashboard', component: AgentDashboard },
    { path: '/dashboard', name: 'customer-dashboard', component: CustomerDashboard },
    { path: '/admin/content', name: 'admin-content', component: AdminContentManager },
    { path: '/list-property', name: 'list-property', component: PropertySubmission }
    },
    {
        path: '/admin/moderation',
        name: 'admin-moderation',
        component: AdminModeration
];

export default createRouter({
    history: createWebHistory(),
    routes
});
