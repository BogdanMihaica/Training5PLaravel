import { createRouter, createWebHistory } from 'vue-router'
import { useAuthStore } from '@/stores/authStore'
import NotFound from '@/components/NotFound/NotFound.vue'
import ProductHomeView from '@/views/Product/ProductHomeView.vue'
import ProductDashboardView from '@/views/Product/ProductDashboardView.vue'
import ProductManageView from '@/views/Product/ProductManageView.vue'
import LoginView from '@/views/Auth/LoginView.vue'
import CartView from '@/views/Cart/CartView.vue'
import OrderDashboardView from '@/views/Order/OrderDashboardView.vue'
import OrderView from '@/views/Order/OrderView.vue'

const router = createRouter({
	history: createWebHistory(import.meta.env.BASE_URL),
	routes: [
		{
			path: '/',
			name: 'home',
			component: ProductHomeView,
		},
		{
			path: '/cart',
			name: 'cart',
			component: CartView,
		},
		{
			path: '/login',
			name: 'login',
			component: LoginView,
		},
		{
			path: '/products',
			name: 'products',
			component: ProductDashboardView,
		},
		{
			path: '/products/create',
			name: 'create',
			component: ProductManageView,
		},
		{
			path: '/products/:id/edit',
			name: 'product',
			component: ProductManageView,
		},
		{
			path: '/orders',
			name: 'orders',
			component: OrderDashboardView,
		},
		{
			path: '/order/:id',
			name: 'order',
			component: OrderView,
		},
		{
			path: "/:catchAll(.*)",
			component: NotFound
		},
		{
			path: "/404",
			name: 'notFound',
			component: NotFound
		}
	],
})

router.beforeEach(async (to, from, next) => {
	const authStore = useAuthStore();
	const privateRoutes = ['products', 'product', 'orders', 'order', 'upload', 'login'];

	if (!authStore.isInitialized) {
		await authStore.initialize();
	}

	if (privateRoutes.includes(to.name)) {
		if (to.name === 'login' && authStore.isAuthenticated) {
			next({ name: 'products' });
		} else if (to.name !== 'login' && !authStore.isAuthenticated ) {
			next({ name: 'login' });
		} else {
			next();
		}
	} else {
		next();
	}
});

export default router
