<script>
import { fetchCsrfCookie } from '@/common/functions';
import CircleLoader from '@/components/Loaders/CircleLoader.vue';
import SquaresLoader from '@/components/Loaders/SquaresLoader.vue';
import PaginationButtons from '@/components/Pagination/PaginationButtons.vue';
import axios from 'axios';
import Swal from 'sweetalert2';

export default {
    components: { SquaresLoader, PaginationButtons, CircleLoader },

    data() {
        return {
            disabledButtons: {},
            products: [],
            paginationInfo: {},
            currentPage: 1,
            loaded: false
        }
    },

    created() {
        fetchCsrfCookie();
        this.getProducts();
    },

    methods: {
        /**
         * Async function that fetches for the products that are not in the cart
         */
        async getProducts() {
            this.loaded = false;

            await axios
                .get(`/spa/products/all?page=${this.currentPage}`)
                .then(response => {
                    this.products = response.data?.data;
                    this.paginationInfo = response.data?.meta;
                });

            this.loaded = true;
        },

        /**
         * Handles the deletion of a product by its id and removes the item from the product list by its index
         * @param id 
         * @param index 
         */
        async handleDelete(id) {
            this.disabledButtons[id] = true;

            await axios
                .delete(`/spa/products/${id}`)
                .then(() => {
                    Swal.fire({
                        title: this.$t('success'),
                        text: this.$t('productDeleted'),
                        icon: 'success'
                    });
                })
                .catch(() => {
                    Swal.fire({
                        title: this.$t('errorTitle'),
                        text: this.$t('somethingWrongHappened'),
                        icon: 'error'
                    });
                });
            
            this.disabledButtons[id] = false;
        },

        /**
         * Handles the change of the current page index
         * 
         * @param {Number} newPage
         */
        handlePageChange(newPage) {
            this.currentPage = newPage;
            
            if (newPage !== this.paginationInfo.current_page) {
                this.getProducts();
            }
        }
    },
}
</script>

<template>
    <h1 class="text-white text-center text-5xl mb-10">{{ $t('dashboard') }}</h1>
    <div class="w-full flex flex-col justify-center items-center text-white">
        <SquaresLoader v-if="!loaded" />
        <table v-else class="w-[90%] rounded-lg">
            <thead>
                <tr class="bg-violet-800">
                    <th class="rounded-tl-lg">{{ $t('id') }}</th>
                    <th> {{ $t('image') }}</th>
                    <th> {{ $t('title') }}</th>
                    <th> {{ $t('description') }}</th>
                    <th> {{ $t('price') }}</th>
                    <th> {{ $t('createdAt') }}</th>
                    <th class="rounded-tr-lg"> {{ $t('actions') }}</th>
                </tr>
            </thead>
            <tbody>
                <tr class="bg-neutral-800" v-for="product in products" :key="product.id">
                    <td> {{ product.id }}</td>
                    <td><img class="h-20 rounded-lg" :src="product.image_url" :alt="$t('productAlt')"></td>
                    <td> {{ product.title }}</td>
                    <td> {{ product.description }}</td>
                    <td> {{ product.price }}</td>
                    <td> {{ product.created_at }}</td>
                    <td>
                        <div class="flex flex-col justify-center items-center w-full gap-2">
                            <RouterLink 
                                :to="{ name: 'product', params: { id: product.id } }" 
                                class="px-4 py-1 h-8 w-24 bg-blue-500 rounded-lg cursor-pointer hover:bg-blue-600 
                                focus:ring-blue-400 focus:ring-1"
                            >
                                {{ $t('edit') }}
                            </RouterLink>


                            <button 
                                :class="{
                                    'cursor-not-allowed': disabledButtons[product.id],
                                    'cursor-pointer' : !disabledButtons[product.id]
                                }" 
                                class="px-4 py-1 h-8 w-24 bg-red-500 rounded-lg hover:bg-red-600 
                                focus:ring-red-400 focus:ring-1" 
                                :disabled="disabledButtons[product.id]"
                                @click.prevent="handleDelete(product.id)"
                            >
                                <CircleLoader v-if="disabledButtons[product.id]" />
                                <span v-else>
                                    {{ $t('delete') }}
                                </span>
                            </button>
                        </div>
                    </td>
                </tr>
            </tbody>
        </table>
        <PaginationButtons :pagination-info="paginationInfo" @pageChange="handlePageChange($event)" />
    </div>
</template>
<style scoped>
th,
td {
    padding: 1rem;
    text-align: center;
}

td {
    border-bottom: 1px solid rgb(77, 77, 77);
}
</style>