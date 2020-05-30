/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');

window.Vue = require('vue');

//vuetify
import Vuetify from './plugins/vuetify';


//vue router
import VueRouter from 'vue-router'
Vue.use(VueRouter)


//vue carousel importing
import VueCarousel from 'vue-carousel';


//registering component

Vue.component('system-bar', require('./components/home/partials/systembar.vue').default);
Vue.component('main-component', require('./components/main.vue').default);
Vue.component('top-bar', require('./components/home/partials/topbar.vue').default);
Vue.component('nav-bar', require('./components/home/partials/navbar.vue').default);
Vue.component('footer-bar', require('./components/home/partials/footer.vue').default);
Vue.component('data-content', require('./components/home/front/index_page/content.vue').default);
Vue.component('carousel', require('./components/home/front/index_page/carousel.vue').default);
Vue.component('premium', require('./components/home/front/index_page/premium.vue').default);
Vue.component('search', require('./components/home/partials/search.vue').default);
Vue.component('login', require('./components/login.vue').default);

import { routes } from './routes.js';
const router = new VueRouter({
    routes,
    mode: 'history',
    scrollBehavior(to, from, savedPosition) {
        return {
            x: 0,
            y: 0
        }
    }
});

Vue.prototype.$loggedIn = window.Auth.loggedIn;
const app = new Vue({
    vuetify: Vuetify,
    el: '#app',
    router
});