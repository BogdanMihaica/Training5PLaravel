<script>
import SquaresLoader from '@/components/Loaders/SquaresLoader.vue';
import PaginationButtons from '@/components/Pagination/PaginationButtons.vue';
import router from '@/router';
import axios from 'axios';

export default {
    components: { SquaresLoader, PaginationButtons },

    data() {
        return {
            products: [],
            paginationInfo: {},
            currentPage: 1,
            order: {},
            loaded: false
        }
    },

    methods: {
        /**
         * Fetches the products of a specific order
         */
        async getProducts() {
            this.loaded = false;

            await axios
                .get(`/spa/orders/${this.order.id}/products?page=${this.currentPage}`)
                .then((res) => {
                    this.products = res.data?.data;
                    this.paginationInfo = res.data?.meta;
                })
                .catch(() => {
                    router.push({ name: 'notFound' });
                });

            this.loaded = true;
        },

        /**
         * Fetches the order details and the products associated with it
         * 
         * @param id
         */
        async getOrder(id) {
            this.loaded = false;

            await axios.get(`/spa/orders/${id}`)
                .then((res) => {
                    this.order = res.data?.data;
                })
                .catch(() => {
                    router.push({ name: 'notFound' });
                });

            await this.getProducts();

            this.loaded = true;
        },

        /**
         * Calculates the total cost of the order and returns it
         * 
         * @returns {Number}
         */
        computeGrandTotal() {
            let total = 0;

            if (this.products) {
                this.products.forEach(product => total += (product.price * product.pivot.quantity));
            }

            return total.toFixed(2);
        }
    },

    created() {
        const id = this.$route.params.id;

        if (id) {
            this.getOrder(id);
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

    <div class="text-white w-full">

        <SquaresLoader v-if="!loaded" class="mx-auto" />
        <div v-else>
            <h1 class="text-5xl text-center"> {{ $t("order") + " #" + order.id }}</h1>
            <div class="text-xl mb-10">
                <h2>{{ $t("customerName") + ": " + order.customer_name }}</h2>
                <h2>{{ $t("customerEmail") + ": " + order.customer_email }}</h2>
                <h2>{{ $t("createdAt") + ": " + order.created_at }}</h2>
            </div>

            <div class="w-full flex flex-col justify-center items-center text-white">
                <table class="w-[90%] rounded-lg">
                    <thead>
                        <tr class="bg-violet-800">
                            <th class="rounded-tl-lg">{{ $t('id') }}</th>
                            <th>{{ $t('image') }}</th>
                            <th>{{ $t('title') }}</th>
                            <th>{{ $t('description') }}</th>
                            <th>{{ $t('price') }}</th>
                            <th>{{ $t('quantity') }}</th>
                            <th>{{ $t('total') }}</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr class="bg-neutral-800" v-for="(product) in products" :key="product.id">
                            <td>{{ product.id }}</td>
                            <td><img class="h-20 rounded-lg" :src="product.image_url" :alt="$t('productAlt')"></td>
                            <td>{{ product.title }}</td>
                            <td>{{ product.description }}</td>
                            <td>{{ product.price }}</td>
                            <td>{{ product.pivot.quantity }}</td>
                            <td>{{ product.pivot.quantity * product.price }}</td>
                        </tr>

                        <tr class="bg-neutral-800">
                            <td colspan="5"></td>
                            <td>{{ $t('grandTotal') }}</td>
                            <td>{{ computeGrandTotal() }}</td>
                        </tr>
                    </tbody>
                </table>
                <PaginationButtons :pagination-info="paginationInfo" v-model="currentPage" />
            </div>
        </div>
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