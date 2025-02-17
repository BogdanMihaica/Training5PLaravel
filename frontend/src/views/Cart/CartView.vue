<script>
import { fetchCsrfCookie } from '@/common/functions';
import ErrorMessage from '@/components/Error/ErrorMessage.vue';
import SquaresLoader from '@/components/Loaders/SquaresLoader.vue';
import PaginationButtons from '@/components/Pagination/PaginationButtons.vue';
import ProductCard from '@/components/Product/ProductCard.vue';
import axios from 'axios';
import Swal from 'sweetalert2';

export default {
	components: { ProductCard, SquaresLoader, ErrorMessage, PaginationButtons },

	data() {
		return {
			products: [],
			paginationInfo: {},
			currentPage: 1,
			loaded: false,
			checkoutOpen: false,
			name: '',
			email: '',
			errors: {}
		}
	},

	created() {
		fetchCsrfCookie();
		this.getProducts();
	},

	methods: {
		/**
		 * Fetches the products corresponding with the server session variable 'cart'
		 */
		async getProducts() {
			this.loaded = false;

			await axios
				.get(`/spa/cart?page=${this.currentPage}`)
				.then(response => {
					this.products = response.data?.data;
					this.paginationInfo = response.data?.meta;
				});

			this.loaded = true;
		},

		/**
		 * Toggles the value of checkoutOpen
		 */
		toggleCheckout() {
			this.checkoutOpen = !this.checkoutOpen;
		},

		/**
		 * Handles the checkout process by making a post request to the server
		 */
		async handleCheckout() {
			await axios
				.post(`/spa/orders`, {
					name: this.name,
					email: this.email
				})
				.then(() => {
					Swal.fire({
						title: this.$t('success'),
						text: this.$t('orderPlaced'),
						icon: 'success'
					});

					this.products = [];
				})
				.catch(error => {
					this.errors = error.response?.data?.errors || {};
				});
		}
	},

	watch: {
		currentPage() {
			this.getProducts();
		}
	}
}
</script>

<template>
	<h1 class="text-white text-center text-5xl mb-10">{{ $t('yourShoppingCart') }}</h1>

	<div v-show="!loaded" class="w-full h-500">
		<SquaresLoader class="mt-20 mx-auto"></SquaresLoader>
	</div>

	<div class="w-full flex flex-wrap gap-4 justify-center">
		<ProductCard v-for="product in products" :key="product.id" :product="product" :is-cart-page="true" />
		<PaginationButtons :pagination-info="paginationInfo" v-model="currentPage" />
	</div>

	<div class="my-6 w-full flex justify-center items-center flex-col">
		<button v-if="!checkoutOpen" class=" cursor-pointer w-40 py-2 px-4 bg-violet-600 text-white rounded-md
			hover:bg-violet-700 focus:outline-none focus:ring-2 focus:ring-violet-500" @click.prevent=" toggleCheckout()">
			{{ $t('checkout') }}
		</button>

		<div v-else
			class="w-100 h-auto py-5 bg-neutral-800 border-1 border-violet-600 flex justify-center items-center flex-col rounded-lg">

			<div class="w-full flex flex-row-reverse">
				<button class="cursor-pointer w-40 text-white" @click.prevent="toggleCheckout()">
					<i class="fas fa-x"></i>
				</button>
			</div>

			<h2 class="text-2xl font-semibold text-center text-white mb-6">{{ $t('checkout') }}</h2>

			<form @submit.prevent="handleCheckout" class="w-[70%]">
				<div class="mb-4">
					<label for="customer-email" class="block text-sm font-medium text-gray-300">
						{{ $t('email') }}
					</label>
					<input type="email" id="customer-email" v-model="email"
						class="text-white w-full p-2 mt-2 border border-gray-600 rounded-md focus:outline-none focus:ring-2 focus:ring-violet-500"
						:placeholder="$t('enterEmail')" />
					<ErrorMessage v-if="errors.email" :error="errors.email" />
				</div>

				<div class="mb-6">
					<label for="name" class="block text-sm font-medium text-gray-300">{{ $t('name') }}</label>
					<input type="text" id="name" v-model="name"
						class="text-white w-full p-2 mt-2 border border-gray-600 rounded-md focus:outline-none focus:ring-2 focus:ring-violet-500"
						:placeholder="$t('enterName')" />
					<ErrorMessage v-if="errors.name" :error="errors.name" />
				</div>

				<div class="flex items-center justify-between">
					<button type="submit" class="cursor-pointer w-full py-2 px-4 bg-violet-600 text-white rounded-md 
						hover:bg-violet-700 focus:outline-none focus:ring-2 focus:ring-violet-500">
						{{ $t('submit') }}
					</button>
				</div>
				<ErrorMessage v-if="errors.cart" :error="errors.cart" />
			</form>
		</div>
	</div>
</template>
