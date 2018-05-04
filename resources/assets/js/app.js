
/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');

window.Vue = require('vue');

import VueRouter from 'vue-router'

Vue.use(VueRouter)

/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */
const Navbar = require('./components/Navbar.vue');
const About = require('./components/About.vue');
const Contact = require('./components/Contact.vue');
const Index = require('./components/Phonebook.vue');
const routes = [

	{ path: '', component: Index },

	{ path: '/about', component: About },

	{ path: '/contact',	component: Contact }
];
//Vue.component('example-component', require('./components/ExampleComponent.vue'));
const router = new VueRouter({
	routes
});

const app = new Vue({
    el: '#app',
    components: {
    	appNavbar: Navbar,
    },
    router,
});
