/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');

window.Vue = require('vue');

//easy toast
import VueIziToast from 'vue-izitoast';
import 'izitoast/dist/css/iziToast.min.css';
Vue.use(VueIziToast);

//vuetify
import Vuetify from './plugins/vuetify';


//vue router
import VueRouter from 'vue-router'
Vue.use(VueRouter)


//vue carousel importing
import VueCarousel from 'vue-carousel';

//vue event bus
window.EventBus = new Vue();

//laravel vue authorization part
import Authorization from './authorization/authorize';
Vue.use(Authorization);

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
Vue.component('empty', require('./components/empty.vue').default);
Vue.component('favorite', require('./components/home/favorite.vue').default);
Vue.component('page-not-found', require('./components/empty.vue').default);
Vue.component('profile-form', require('./components/home/back/profile/form.vue').default);
Vue.component('mymenu', require('./components/home/back/myAds/myMenu.vue').default);

Vue.component('cover', require('./components/home/coverImage.vue').default);
Vue.component('card-date', require('./components/home/cardDate.vue').default);
Vue.component('card-title', require('./components/home/cardTitle.vue').default);
Vue.component('card-lazy', require('./components/home/card-lazy.vue').default);
Vue.component('user-menu', require('./components/home/partials/userMenu.vue').default);
Vue.component('card-menu', require('./components/home/cardMenu.vue').default);

//common form
Vue.component('common-form', require('./components/home/back/form/commonForm.vue').default);

// create ads component
Vue.component('property', require('./components/home/back/form/create/property.vue').default);
Vue.component('vehicle', require('./components/home/back/form/create/vehicle.vue').default);
Vue.component('mobile', require('./components/home/back/form/create/mobile.vue').default);
Vue.component('jobs', require('./components/home/back/form/create/jobs.vue').default);
Vue.component('other', require('./components/home/back/form/create/other.vue').default);

// edit ads component
Vue.component('editproperty', require('./components/home/back/form/edit/property.vue').default);
Vue.component('editvehicle', require('./components/home/back/form/edit/vehicle.vue').default);
Vue.component('editmobile', require('./components/home/back/form/edit/mobile.vue').default);
Vue.component('editjobs', require('./components/home/back/form/edit/jobs.vue').default);
Vue.component('edit-other', require('./components/home/back/form/edit/other.vue').default);


//confirm vue
Vue.component('nav-filter', require('./components/filter.vue').default);

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

//Vue.prototype.$loggedIn = window.Auth.loggedIn;
const app = new Vue({
    vuetify: Vuetify,
    el: '#app',
    router
});