import Vue from 'vue'
import Router from 'vue-router'


import Home from './components/Home'
import About from './pages/About'
import Contact from './pages/Contact'

Vue.use(Router)

export default new Router({
	mode: 'history',
	routes: [
		{
			path: '/',
			component: Home
		},
		{
			path: '/about',
			component: About
		},
		{
			path: '/contact',
			component: Contact
		}
	]
})