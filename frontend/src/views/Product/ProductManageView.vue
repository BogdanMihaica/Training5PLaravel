<!-- eslint-disable no-unused-vars -->
<script>
import { fetchCsrfCookie } from '@/common/functions';
import ErrorMessage from '@/components/Error/ErrorMessage.vue';
import CircleLoader from '@/components/Loaders/CircleLoader.vue';
import SquaresLoader from '@/components/Loaders/SquaresLoader.vue';
import router from '@/router';
import axios from 'axios';
import Swal from 'sweetalert2';

export default {
    components: { ErrorMessage, SquaresLoader, CircleLoader },

    data() {
        return {
            disabledButton: false,
            product:{},
            id: 0,
            image: null,
            edit: false,
            errors: {},
            loaded: true
        }
    },

    methods: {
        /**
         * Fetches the product from the database if there is a parameter in the url resembling a product id
         */
        async getProduct(id) {
            this.loaded = false;

            await axios
                .get(`/spa/products/${id}`)
                .then((res) => {
                    this.product = res.data?.data;
                    this.edit = true;
                })
                .catch(()=>{
                    router.push({ 'name' : 'notFound'});
                });

            this.loaded = true;
        },

        /**
         * Handles the process of patching or posting the active element from the database by using a FormData objejct
         * to successfully send the image to the server
         */
        async handleSubmit() {
            let formData = new FormData();

            formData.append('title', this.product.title);
            formData.append('description', this.product.description);
            formData.append('price', this.product.price);

            if (this.image) {
                formData.append('image', this.image);
            }

            this.disabledButton = true;

            if (this.edit) {
                formData.append('_method', 'PUT');

                await axios
                    .post(`/spa/products/${this.product.id}`, formData, {
                        headers: {
                            'Content-Type': 'multipart/form-data'
                        }
                    })
                    .then((res) => {
                        Swal.fire({
                            title: this.$t('success'),
                            text: this.$t('productUpdated'),
                            icon: 'success'
                        });

                        router.push({ name: 'products' });
                    })
                    .catch((error) => {
                        this.errors = error.response?.data?.errors;
                    });
            } else {
                await axios
                    .post(`/spa/products`, formData, {
                        headers: {
                            'Content-Type': 'multipart/form-data'
                        }
                    })
                    .then((res) => {
                        Swal.fire({
                            title: this.$t('success'),
                            text: this.$t('productCreated'),
                            icon: 'success'
                        });

                        const createdId = res.data?.data?.id;

                        router.push({ name: 'product', params: { id: createdId } })
                    })
                    .catch((error) => {
                        this.errors = error.response?.data?.errors;
                    });
            }

            this.disabledButton = false;
        },

        /**
         * Changes the image variable based on an event
         * 
         * @param e 
         */
        handleImageChange(e) {
            this.image = e.target.files[0];
        },
    },

    created() {
        fetchCsrfCookie();

        const id = this.$route.params.id;

        if (id) {
            this.getProduct(id);
        }
    },
}
</script>

<template>
    <div class="h-200 flex justify-center items-center text-white">
        <div v-if="!loaded" class="w-full h-200">
            <SquaresLoader class="mt-20 mx-auto" />
        </div>
        <div v-else class="bg-neutral-800 p-8 rounded-2xl shadow-lg w-128 border-1 border-violet-600">
            <h2 class="text-2xl font-semibold text-center text-white mb-6">
                {{ edit ? $t('editProduct') : $t('create') }}
            </h2>

            <div v-if="edit" class="w-full flex justify-center mb-2">
                <img :src="product.image_url" :alt="$t('productAlt')" class="h-50">
            </div>

            <form>
                <div class="mb-4">
                    <label for="title" class="block text-sm font-medium text-gray-300">
                        {{ $t('title') }}
                    </label>
                    <input 
                        type="text" 
                        id="title" 
                        v-model="product.title"
                        class="w-full p-2 mt-2 border border-gray-600 rounded-md focus:outline-none focus:ring-2 focus:ring-violet-500"
                        :placeholder="$t('enterTitle')" 
                    />
                    <ErrorMessage v-if="errors.title" :error="errors.title" />
                </div>

                <div class="mb-4">
                    <label for="description" class="block text-sm font-medium text-gray-300">
                        {{ $t('description') }}
                    </label>
                    <textarea 
                        id="description" 
                        v-model="product.description"
                        class="w-full p-2 mt-2 border border-gray-600 rounded-md focus:outline-none focus:ring-2 focus:ring-violet-500 resize-none"
                        :placeholder="$t('enterDescription')" rows="6"
                    >
                    </textarea>
                    <ErrorMessage v-if="errors.description" :error="errors.description" />
                </div>

                <div class="mb-4">
                    <label for="price" class="block text-sm font-medium text-gray-300">
                        {{ $t('price') }}
                    </label>
                    <input 
                        type="text" 
                        id="price" 
                        v-model="product.price"
                        class="w-full p-2 mt-2 border border-gray-600 rounded-md focus:outline-none focus:ring-2 focus:ring-violet-500"
                        :placeholder="$t('enterPrice')" 
                    />
                    <ErrorMessage v-if="errors.price" :error="errors.price" />
                </div>

                <div class="mb-4">
                    <label for="image" class="block text-sm font-medium text-gray-300">
                        {{ $t('image') }}
                    </label>
                    <input
                        class="mt-2 block w-full h-8 text-sm text-gray-900 border border-gray-300 rounded-lg cursor-pointer bg-gray-50 dark:text-gray-400 focus:outline-none"
                        type="file" 
                        id="image" 
                        @change="handleImageChange($event)"
                    />
                    <ErrorMessage v-if="errors.image" :error="errors.image" />
                </div>

                <div class="flex items-center justify-between">
                    <button
                        :class="{
                            'cursor-not-allowed': disabledButton,
                            'cursor-pointer' : !disabledButton
                        }"
                        class="h-12 w-full py-2 px-4 bg-violet-600 text-white rounded-md hover:bg-violet-700 focus:outline-none 
                            focus:ring-2 focus:ring-violet-500"
                        :disabled="disabledButton"
                        @click.prevent="handleSubmit()"
                    >
                        <CircleLoader v-if="disabledButton"/>
                        <span v-else>
                            {{ $t('save') }}
                        </span>
                    </button>
                </div>
            </form>
        </div>
    </div>
</template>