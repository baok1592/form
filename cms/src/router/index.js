import Vue from 'vue'
import Router from 'vue-router'
// import HelloWorld from '@/components/HelloWorld'


Vue.use(Router)

export default new Router({
	routes: [
		{
			path: '/',
			name: 'index',
			component: () => import('../view/index.vue')
		},
		{
			path: '/admin',
			name: 'admin',
			component: () => import('../view/admin/admin.vue')
		},
		{
			path: '/login',
			name: 'login',
			component: () => import('../view/admin/login.vue')
		},
		{
			path: '/excel',
			name: 'excel',
			component: () => import('../view/excel/excel.vue')
		},
	
		{
			path: '/order',
			name: 'order',
			component: () => import('../view/order/order.vue')
		},
		
		{
			path: '/sysinfo',
			name: 'sysinfo',
			component: () => import('../view/sys/sysinfo.vue')
		},


	]
})
