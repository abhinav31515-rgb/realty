import { createRouter, createWebHistory } from 'vue-router';
import LandingPage from '../components/LandingPage.vue';
import PropertyList from '../components/property/PropertyList.vue';
import PropertyDetail from '../components/property/PropertyDetail.vue';
import Login from '../components/auth/Login.vue';

const routes = [
    {
        path: '/',
        name: 'home',
        component: LandingPage
    },
    {
        path: '/properties',
        name: 'properties',
        component: PropertyList
    },
    {
        path: '/properties/:id',
        name: 'property-detail',
        component: PropertyDetail
    },
    {
        path: '/login',
        name: 'login',
        component: Login
    }
];

export default createRouter({
    history: createWebHistory(),
    routes
});
