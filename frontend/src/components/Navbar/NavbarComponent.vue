<script>
import { useAuthStore } from '@/stores/authStore';
import NavbarLink from './NavbarLink.vue';
import { mapStores } from 'pinia';

export default {
    components: { NavbarLink },

    data() {
        return {
            loggedIn: false
        }
    },

    methods: {
        /**
         * Handles the logout of the user
         */
        async handleLogout() {
            await this.authStore.logout();
        },

        /**
         * Handles the locale change
         * 
         * @param language 
         */
        async handleLocaleChange(language) {
            this.$i18n.locale = language.toUpperCase();
        }
    },

    computed: {
        ...mapStores(useAuthStore),

        /**
         * Checks if the user is authenticated
         */
        isAuthenticated() {
            return this.authStore.isAuthenticated;
        },
    }
}
</script>

<template>
    <div
        class="top-0 w-full h-15 bg-gradient-to-r from-violet-500 to-violet-600 rounded-b-2xl fixed flex justify-between items-center">
        <div class="flex gap-5">
            <NavbarLink :route="{ 'name': 'home' }" icon="fas fa-house" class="first:ml-5">{{ $t('home') }}</NavbarLink>
            <NavbarLink :route="{ 'name': 'cart' }" icon="fas fa-cart-shopping">{{ $t('cart') }}</NavbarLink>
            <NavbarLink v-show="!isAuthenticated" :route="{ 'name': 'login' }" icon="fas fa-right-to-bracket">{{ $t('login') }}</NavbarLink>
            <span v-show="isAuthenticated" class="flex gap-5">
                <NavbarLink :route="{ 'name': 'products' }" icon="fas fa-boxes-stacked">{{ $t('products') }}</NavbarLink>
                <NavbarLink :route="{ 'name': 'orders' }" icon="fas fa-box">{{ $t('orders') }}</NavbarLink>
                <NavbarLink :route="{ 'name': 'create' }" icon="fas fa-upload">{{ $t('create') }}</NavbarLink>
                <button 
                    class="text-white rounded-lg min-w-20 px-4 py-2 bg-red-800 transition-all duration-500 flex justify-center items-center text-lg
                        hover:bg-red-600 cursor-pointer" 
                    @click.prevent="handleLogout"
                >
                    {{ $t('logout') }}
                </button>
            </span>
        </div>

        <div class="mr-10 flex gap-2">
            <button 
                class="cursor-pointer px-3 bg-violet-300 text-black rounded-sm hover:bg-violet-400"
                @click.prevent="handleLocaleChange('en')"
            >
                {{ $t('en') }}
            </button>
            <button 
                class="cursor-pointer px-3 bg-violet-300 text-black rounded-sm hover:bg-violet-400"
                @click.prevent="handleLocaleChange('ro')"
            >
                {{ $t('ro') }}
            </button>
        </div>
    </div>
</template>