import { createRouter, createWebHistory } from 'vue-router';
import LandingPage from '../components/LandingPage.vue';
import PropertyList from '../components/property/PropertyList.vue';
import PropertyDetail from '../components/property/PropertyDetail.vue';

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
    }
];

export default createRouter({
    history: createWebHistory(),
    routes
});
