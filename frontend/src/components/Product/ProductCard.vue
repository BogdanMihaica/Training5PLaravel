<script>
import axios from 'axios';
import ProductButton from './ProductButton.vue';
import Swal from 'sweetalert2';

export default {
    components: { ProductButton },

    data() {
        return {
            quantity: 1,
            disabledButton: false
        }
    },

    props: {
        product: Object,
        isCartPage: {
            type: Boolean,
            default: false
        },
    },

    methods: {
        /**
         * performs a request to add an item to the cart and alerts the user accordingly
         * 
         * @param id 
         * @param quantity 
         */
        async addToCart(id, quantity) {
            await axios
                .post(`/spa/cart`, {
                    quantity: quantity,
                    id: id
                })
                .then(() => {
                    Swal.fire({
                        title: this.$t('success'),
                        text: this.$t('addedToCart'),
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
        },

        /**
         * Performs a request to remove an item from the cart and alerts the user accordingly
         * 
         * @param id 
         */
        async removeFromCart(id) {
            await axios
                .delete(`/spa/cart/${id}`)
                .then(() => {
                    Swal.fire({
                        title: this.$t('success'),
                        text: this.$t('removedFromCart'),
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
        },

        /**
         * Handles the click of the button
         * 
         * @param id 
         * @param quantity 
         */
        async handleButtonClick(id, quantity) {
            this.disabledButton = true;

            if (this.isCartPage) {
                await this.removeFromCart(id);
            } else {
                await this.addToCart(id, quantity);
            }

            this.disabledButton = false;
        }
    },
}
</script>

<template>
    <div class="w-70 min-h-120 rounded-xl border-2 border-neutral-600 overflow-hidden 
        bg-gradient-to-t from-neutral-800 to-neutral-700">
        <div class="w-full flex-col items-center text-violet-100 p-4 h-full">
            <div class="flex flex-col h-full auto items-center justify-between space-y-4">
                <div class="w-full h-60 flex justify-center mt-1 overflow-hidden">
                    <img 
                        v-if="product.image_url" 
                        :src="product.image_url" 
                        :alt="$t('productAlt')"
                        class="rounded-lg border-2 border-neutral-600" 
                    />
                    <img v-else src="@/assets/placeholder.svg" :alt="$t('productAlt')"/>
                </div>

                <h2 class="text-2xl">{{ product.title }}</h2>
                <h3 class="text-xs mx-5">{{ product.description }}</h3>
                <h2 v-show="isCartPage" class="text-2xl"> {{ $t('quantity') + ": " + product.quantity }}</h2>
                <h2 class="text-3xl text-violet-300">${{ product.price }}</h2>

                <div class="flex justify-center items-center mt-1 flex-col">
                    <ProductButton 
                        :is-cart-page="isCartPage" 
                        @action="handleButtonClick(product.id, quantity || 0)" 
                        :disabled="disabledButton"
                    />

                    <label v-show="!isCartPage" :for="`quantity-${product.id}`">{{ $t('selectQuantity') }}</label>
                    <select v-show="!isCartPage" v-model="quantity" :id="`quantity-${product.id}`">
                        <option v-for="i in 10" :key="i" class="text-black">{{ i }}</option>
                    </select>
                </div>
            </div>
        </div>
    </div>
</template>