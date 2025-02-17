<script>
import { awaitCsrfCookie } from '@/common/functions';
import SquaresLoader from '@/components/Loaders/SquaresLoader.vue';
import PaginationButtons from '@/components/Pagination/PaginationButtons.vue';
import ProductCard from '@/components/Product/ProductCard.vue';
import axios from 'axios';

export default {
	components: { ProductCard, SquaresLoader, PaginationButtons },

	data() {
		return {
			products: [],
			currentPage: 1,
			paginationInfo: {},
			loaded: false,
		}
	},

	created() {
		awaitCsrfCookie();
		this.getProducts();
	},

	methods: {
		/**
		 * Async function that fetches for the products that are not in the cart
		 */
		async getProducts() {
			this.loaded = false;

			await axios.get(`/spa/products?page=${this.currentPage}`)
				.then(response => {
					this.products = response.data?.data;
					this.paginationInfo = response.data?.meta;
				})

			this.loaded = true;
		},
	},

	watch: {
		currentPage() {
			this.getProducts();
		}
	}
}
</script>
<template>
	<h1 class="text-white text-center text-5xl mb-10">{{ $t('browse') }}</h1>

	<div v-show="!loaded" class="w-full h-500">
		<SquaresLoader class="mt-20 mx-auto" />
	</div>

	<div class="w-full flex flex-wrap gap-4 justify-center">
		<ProductCard v-for="(product, i) in products" :key="product.id" :index="i" :product="product" />
		<PaginationButtons :pagination-info="paginationInfo" v-model="currentPage" />
	</div>
</template>
