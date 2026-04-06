import { createRouter, createWebHistory } from 'vue-router';

// Implement Dynamic Imports (Lazy Loading) to improve initial load time
const LandingPage = () => import('../components/LandingPage.vue');
const PropertyList = () => import('../components/property/PropertyList.vue');
const PropertyDetail = () => import('../components/property/PropertyDetail.vue');
const Login = () => import('../components/auth/Login.vue');
const AdminDashboard = () => import('../components/dashboard/AdminDashboard.vue');
const AgentDashboard = () => import('../components/dashboard/AgentDashboard.vue');
const CustomerDashboard = () => import('../components/dashboard/CustomerDashboard.vue');
const AdminContentManager = () => import('../components/cms/AdminContentManager.vue');
const PropertySubmission = () => import('../components/property/PropertySubmission.vue');
const AdminModeration = () => import('../components/dashboard/AdminModeration.vue');
const CompareView = () => import('../components/property/CompareView.vue');

const routes = [
    { path: '/', name: 'home', component: LandingPage },
    { path: '/properties', name: 'properties', component: PropertyList },
    { path: '/properties/:id', name: 'property-detail', component: PropertyDetail },
    { path: '/login', name: 'login', component: Login },
    { path: '/admin', name: 'admin-dashboard', component: AdminDashboard },
    { path: '/agent', name: 'agent-dashboard', component: AgentDashboard },
    { path: '/dashboard', name: 'customer-dashboard', component: CustomerDashboard },
    { path: '/admin/content', name: 'admin-content', component: AdminContentManager },
    { path: '/list-property', name: 'list-property', component: PropertySubmission },
    { path: '/admin/moderation', name: 'admin-moderation', component: AdminModeration },
    { path: '/compare', name: 'compare', component: CompareView }
];

export default createRouter({
    history: createWebHistory(),
    routes
});
